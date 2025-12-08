<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class TransferResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $fromPublicKey,
        private readonly string $toPublicKey,
        private readonly float $amount,
        private readonly string $currencyCode,
        private readonly int $status
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFromPublicKey(): string
    {
        return $this->fromPublicKey;
    }

    public function getToPublicKey(): string
    {
        return $this->toPublicKey;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            $data['from_public_key'],
            $data['to_public_key'],
            (float) $data['amount'],
            $data['currency_code'],
            (int) $data['status']
        );
    }
}

