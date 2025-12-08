<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Http;

class Response
{
    public function __construct(
        private readonly int $statusCode,
        private readonly array $body,
        private readonly array $headers = []
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function getData(): array
    {
        return $this->body['data'] ?? [];
    }
}

