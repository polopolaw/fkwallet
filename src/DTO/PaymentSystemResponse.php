<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class PaymentSystemResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $code
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            $data['code']
        );
    }
}

