<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class SbpBankResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $name
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            $data['name']
        );
    }
}

