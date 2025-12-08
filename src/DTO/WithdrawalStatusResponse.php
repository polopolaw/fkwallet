<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

use Polopolaw\FKWallet\Enums\WithdrawalStatus;

final class WithdrawalStatusResponse
{
    public function __construct(
        private readonly int $id,
        private readonly WithdrawalStatus $status,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): WithdrawalStatus
    {
        return $this->status;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            WithdrawalStatus::from($data['status']),
        );
    }
}

