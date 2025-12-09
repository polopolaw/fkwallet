<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Services;

use Polopolaw\FKWallet\Auth\SignatureGenerator;
use Polopolaw\FKWallet\Contracts\FKWalletServiceInterface;
use Polopolaw\FKWallet\DTO\BalanceResponse;
use Polopolaw\FKWallet\DTO\CurrencyResponse;
use Polopolaw\FKWallet\DTO\HistoryResponse;
use Polopolaw\FKWallet\DTO\MobileCarrierResponse;
use Polopolaw\FKWallet\DTO\OnlineOrderResponse;
use Polopolaw\FKWallet\DTO\OnlineOrderStatusResponse;
use Polopolaw\FKWallet\DTO\OnlineProductCategoryResponse;
use Polopolaw\FKWallet\DTO\OnlineProductResponse;
use Polopolaw\FKWallet\DTO\PaymentSystemResponse;
use Polopolaw\FKWallet\DTO\Requests\OnlineOrderRequest;
use Polopolaw\FKWallet\DTO\Requests\TransferRequest;
use Polopolaw\FKWallet\DTO\Requests\WithdrawalRequest;
use Polopolaw\FKWallet\DTO\SbpBankResponse;
use Polopolaw\FKWallet\DTO\TransferResponse;
use Polopolaw\FKWallet\DTO\TransferStatusResponse;
use Polopolaw\FKWallet\DTO\WithdrawalResponse;
use Polopolaw\FKWallet\DTO\WithdrawalStatusResponse;
use Polopolaw\FKWallet\Enums\OrderStatusType;
use Polopolaw\FKWallet\Exceptions\ApiException;
use Polopolaw\FKWallet\Exceptions\OrderNotFoundException;
use Polopolaw\FKWallet\Http\ClientInterface;
use Polopolaw\FKWallet\Http\Response;

class FKWalletService implements FKWalletServiceInterface
{
    private ?string $proxy = null;
    private string $publicKey;
    private string $privateKey;

    public function __construct(
        private readonly ClientInterface $client,
        private readonly string $apiUrl,
        private readonly string $defaultPublicKey,
        private readonly string $defaultPrivateKey
    ) {
        $this->publicKey = $defaultPublicKey;
        $this->privateKey = $defaultPrivateKey;
    }

    public function proxy(string $proxy): static
    {
        $this->proxy = $proxy;
        $this->client->setProxy($proxy);
        return $this;
    }

    public function withCredentials(string $publicKey, string $privateKey): static
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;

        return $this;
    }

    public function getBalance(): BalanceResponse
    {
        $url = $this->buildUrl($this->publicKey, 'balance');
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return BalanceResponse::fromArray($data);
    }

    public function getHistory(
        ?string $dateFrom = null,
        ?string $dateTo = null,
        int $page = 1,
        int $limit = 10
    ): HistoryResponse {
        $url = $this->buildUrl($this->publicKey, 'history');
        $params = [];
        if ($dateFrom !== null) {
            $params['date_from'] = $dateFrom;
        }
        if ($dateTo !== null) {
            $params['date_to'] = $dateTo;
        }
        $params['page'] = $page;
        $params['limit'] = $limit;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return HistoryResponse::fromArray($data);
    }

    public function getCurrencies(): array
    {
        $url = $this->buildUrl($this->publicKey, 'currencies');
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        $currencies = [];
        foreach ($data as $currencyData) {
            $currencies[] = CurrencyResponse::fromArray($currencyData);
        }

        return $currencies;
    }

    public function getPaymentSystems(): array
    {
        $url = $this->buildUrl($this->publicKey, 'payment_systems');
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        $paymentSystems = [];
        foreach ($data as $paymentSystemData) {
            $paymentSystems[] = PaymentSystemResponse::fromArray($paymentSystemData);
        }

        return $paymentSystems;
    }

    public function getSbpList(): array
    {
        $url = $this->buildUrl($this->publicKey, 'sbp_list');
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        $banks = [];
        foreach ($data as $bankData) {
            $banks[] = SbpBankResponse::fromArray($bankData);
        }

        return $banks;
    }

    public function getMobileCarrierList(): array
    {
        $url = $this->buildUrl($this->publicKey, 'mobile_carrier_list');
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        $carriers = [];
        foreach ($data as $carrierData) {
            $carriers[] = MobileCarrierResponse::fromArray($carrierData);
        }

        return $carriers;
    }

    public function getWithdrawalStatus(
        int|string $orderId,
        OrderStatusType $type = OrderStatusType::ORDER_ID
    ): WithdrawalStatusResponse {
        $url = $this->buildUrl($this->publicKey, "withdrawal/{$orderId}");
        $url .= '?type=' . $type->value;
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return WithdrawalStatusResponse::fromArray($data);
    }

    public function getTransferStatus(int|string $id): TransferStatusResponse
    {
        $url = $this->buildUrl($this->publicKey, "transfer/{$id}");
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return TransferStatusResponse::fromArray($data);
    }

    public function getOnlineProductCategories(): array
    {
        $url = $this->buildUrl($this->publicKey, 'op/categories');
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        $categories = [];
        foreach ($data as $categoryData) {
            $categories[] = OnlineProductCategoryResponse::fromArray($categoryData);
        }

        return $categories;
    }

    public function getOnlineProducts(int $categoryId): array
    {
        $url = $this->buildUrl($this->publicKey, "op/categories/{$categoryId}/products");
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        $products = [];
        foreach ($data as $productData) {
            $products[] = OnlineProductResponse::fromArray($productData);
        }

        return $products;
    }

    public function getOnlineOrderStatus(int $orderId): OnlineOrderStatusResponse
    {
        $url = $this->buildUrl($this->publicKey, "op/status/{$orderId}");
        $signature = $this->generateSignature($this->publicKey, 'GET');
        $response = $this->client->get($url, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return OnlineOrderStatusResponse::fromArray($data);
    }

    public function createWithdrawal(WithdrawalRequest $request): WithdrawalResponse
    {
        $url = $this->buildUrl($this->publicKey, 'withdrawal');
        $payload = $request->toArray();
        $signature = $this->generateSignature($this->publicKey, 'POST', $payload);
        $response = $this->client->post($url, $payload, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return WithdrawalResponse::fromArray($data);
    }

    public function createTransfer(TransferRequest $request): TransferResponse
    {
        $url = $this->buildUrl($this->publicKey, 'transfer');
        $queryParams = $request->toArray();
        
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        
        $signature = $this->generateSignature($this->publicKey, 'POST', $queryParams);
        $response = $this->client->post($url, [], $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return TransferResponse::fromArray($data);
    }

    public function createOnlineOrder(OnlineOrderRequest $request): OnlineOrderResponse
    {
        $url = $this->buildUrl($this->publicKey, 'op/create');
        $payload = $request->toArray();
        $signature = $this->generateSignature($this->publicKey, 'POST', $payload);
        $response = $this->client->post($url, $payload, $this->buildHeaders($signature), $this->proxy);
        $data = $this->extractData($response);

        return OnlineOrderResponse::fromArray($data);
    }

    private function buildUrl(string $publicKey, string $endpoint): string
    {
        return rtrim($this->apiUrl, '/') . '/' . $publicKey . '/' . ltrim($endpoint, '/');
    }

    private function generateSignature(string $publicKey, string $method, ?array $payload = null): string
    {
        $privateKey = $this->getPrivateKeyForPublicKey($publicKey);
        $generator = new SignatureGenerator($publicKey, $privateKey);

        if ($method === 'POST' && $payload !== null) {
            return $generator->forPost($payload);
        }

        return $generator->forGet();
    }

    private function getPrivateKeyForPublicKey(string $publicKey): string
    {
        if ($publicKey === $this->publicKey) {
            return $this->privateKey;
        }

        if ($publicKey === $this->defaultPublicKey) {
            return $this->defaultPrivateKey;
        }

        return $this->privateKey;
    }

    private function buildHeaders(string $signature): array
    {
        return [
            'Authorization' => 'Bearer ' . $signature,
            'Accept' => 'application/json',
        ];
    }

    private function extractData(Response $response): array
    {
        if (!$response->isSuccessful()) {
            throw new ApiException('API request failed with status code: ' . $response->getStatusCode());
        }

        $body = $response->getBody();
        if (!isset($body['status']) || $body['status'] !== 'ok') {
            $errorMessage = $body['data']['message'] ?? 'Unknown error';
            throw new ApiException('API error: ' . $errorMessage);
        }

        return $body['data'] ?? [];
    }
}

