<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\ValueObjects;

final class Balance
{
    public function __construct(
        private readonly string $currencyCode,
        private readonly float $value
    ) {
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'currency_code' => $this->currencyCode,
            'value' => $this->value,
        ];
    }
}

