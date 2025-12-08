<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class Transaction
{
    public function __construct(
        private readonly int $id,
        private readonly int $currency,
        private readonly string $currencyCode,
        private readonly float $amount,
        private readonly string $date,
        private readonly string $operation,
        private readonly string $operationTitle,
        private readonly TransactionInfo $info
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCurrency(): int
    {
        return $this->currency;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getOperationTitle(): string
    {
        return $this->operationTitle;
    }

    public function getInfo(): TransactionInfo
    {
        return $this->info;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (int) $data['currency'],
            $data['currency_code'],
            (float) $data['amount'],
            $data['date'],
            $data['operation'],
            $data['operation_title'],
            TransactionInfo::fromArray($data['info'])
        );
    }
}

