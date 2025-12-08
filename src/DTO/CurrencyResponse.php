<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class CurrencyResponse
{
    public function __construct(
        private readonly int $id,
        private readonly string $code,
        private readonly float $course
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

    public function getCourse(): float
    {
        return $this->course;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            $data['code'],
            (float) $data['course']
        );
    }
}

