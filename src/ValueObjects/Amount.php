<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\ValueObjects;

final class Amount
{
    public function __construct(
        private readonly float $value
    ) {
        if ($this->value <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than zero');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}

