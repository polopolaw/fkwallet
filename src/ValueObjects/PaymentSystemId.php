<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\ValueObjects;

final class PaymentSystemId
{
    public function __construct(
        private readonly int $value
    ) {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('Payment system ID must be greater than zero');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}

