<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Http;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Polopolaw\FKWallet\Exceptions\ApiException;

class GuzzleClient implements ClientInterface
{
    private ?string $proxy = null;

    public function __construct(
        private readonly GuzzleHttpClient $client,
        private readonly int $timeout = 30,
        private readonly int $retryAttempts = 3
    ) {
    }

    public function get(string $url, array $headers = [], ?string $proxy = null): Response
    {
        return $this->request('GET', $url, ['headers' => $headers], $proxy ?? $this->proxy);
    }

    public function post(string $url, array $data = [], array $headers = [], ?string $proxy = null): Response
    {
        return $this->request('POST', $url, [
            'headers' => array_merge($headers, ['Content-Type' => 'application/json']),
            'json' => $data,
        ], $proxy ?? $this->proxy);
    }

    public function setProxy(?string $proxy): void
    {
        $this->proxy = $proxy;
    }

    public function getProxy(): ?string
    {
        return $this->proxy;
    }

    private function request(string $method, string $url, array $options = [], ?string $proxy = null): Response
    {
        $options['timeout'] = $this->timeout;
        
        if ($proxy !== null) {
            $options['proxy'] = $proxy;
        }
        
        $lastException = null;

        for ($attempt = 1; $attempt <= $this->retryAttempts; $attempt++) {
            try {
                $response = $this->client->request($method, $url, $options);
                $body = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

                return new Response(
                    $response->getStatusCode(),
                    $body,
                    $response->getHeaders()
                );
            } catch (ClientException $e) {
                // For 4xx errors, extract error message from response body
                $errorMessage = $this->extractErrorMessage($e);
                $lastException = $e;
                
                // Don't retry 4xx errors (client errors)
                if ($e->getResponse() && $e->getResponse()->getStatusCode() >= 400 && $e->getResponse()->getStatusCode() < 500) {
                    throw new ApiException($errorMessage, $e->getResponse()->getStatusCode(), $e);
                }
                
                if ($attempt === $this->retryAttempts) {
                    break;
                }
                usleep(100000 * $attempt);
            } catch (GuzzleException $e) {
                $lastException = $e;
                if ($attempt === $this->retryAttempts) {
                    break;
                }
                usleep(100000 * $attempt);
            } catch (\JsonException $e) {
                throw new ApiException('Invalid JSON response: ' . $e->getMessage(), 0, $e);
            }
        }

        $errorMessage = $lastException instanceof ClientException 
            ? $this->extractErrorMessage($lastException)
            : 'Request failed after ' . $this->retryAttempts . ' attempts: ' . $lastException->getMessage();
        
        $statusCode = $lastException instanceof ClientException && $lastException->getResponse()
            ? $lastException->getResponse()->getStatusCode()
            : 0;

        throw new ApiException($errorMessage, $statusCode, $lastException);
    }

    private function extractErrorMessage(ClientException $e): string
    {
        $response = $e->getResponse();
        if ($response === null) {
            return $e->getMessage();
        }

        try {
            $body = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            
            // Try to extract message from common API error response formats
            if (isset($body['message'])) {
                return $body['message'];
            }
            
            if (isset($body['error']['message'])) {
                return $body['error']['message'];
            }
            
            if (isset($body['data']['message'])) {
                return $body['data']['message'];
            }
            
            // Fallback to status code message
            return sprintf(
                'Client error: `%s %s` resulted in a `%d %s` response',
                $e->getRequest()->getMethod(),
                (string) $e->getRequest()->getUri(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            );
        } catch (\JsonException) {
            // If response body is not JSON, use default message
            return sprintf(
                'Client error: `%s %s` resulted in a `%d %s` response',
                $e->getRequest()->getMethod(),
                (string) $e->getRequest()->getUri(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            );
        }
    }
}

