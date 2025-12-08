<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Auth;

use Polopolaw\FKWallet\ValueObjects\PrivateKey;

class SignatureGenerator implements SignatureGeneratorInterface
{
    private string $publicKey;

    private PrivateKey $privateKey;

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = new PrivateKey($privateKey);
    }

    public function forGet(): string
    {
        return hash('sha256', $this->privateKey->getValue());
    }

    public function forPost(array $payload): string
    {
        $body = json_encode($payload, JSON_THROW_ON_ERROR);
        return hash('sha256', $body . $this->privateKey->getValue());
    }

    public function publicKey(): string
    {
        return $this->publicKey;
    }
}


