<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\ValueObjects;

use Polopolaw\FKWallet\Exceptions\InvalidPublicKeyException;

final class PublicKey
{
    public function __construct(
        private readonly string $value
    ) {
        if (empty($this->value)) {
            throw new InvalidPublicKeyException('Public key cannot be empty');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

