<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

use Polopolaw\FKWallet\Enums\WithdrawalStatus;

final class WithdrawalNotification
{
    public function __construct(
        private readonly int $id,
        private readonly string $orderId,
        private readonly int $currencyId,
        private readonly int $paymentSystemId,
        private readonly string $description,
        private readonly WithdrawalStatus $status,
        private readonly float $amount,
        private readonly float $fee,
        private readonly string $account,
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

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    public function getPaymentSystemId(): int
    {
        return $this->paymentSystemId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): WithdrawalStatus
    {
        return $this->status;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getFee(): float
    {
        return $this->fee;
    }

    public function getAccount(): string
    {
        return $this->account;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (string) $data['order_id'],
            (int) $data['currency_id'],
            (int) $data['payment_system_id'],
            (string) ($data['description'] ?? ''),
            WithdrawalStatus::from((int) $data['status']),
            (float) $data['amount'],
            (float) $data['fee'],
            (string) $data['account'],
        );
    }
}

