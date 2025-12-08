<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class WithdrawalResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $orderId,
        private readonly float $amount,
        private readonly string $currencyCode,
        private readonly int $status
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
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
            $data['order_id'],
            (float) $data['amount'],
            $data['currency_code'],
            (int) $data['status']
        );
    }
}

