<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class TransferStatusResponse
{
    public function __construct(
        private readonly int $id,
        private readonly int $fromWalletNumber,
        private readonly int $toWalletNumber,
        private readonly int $status
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFromWalletNumber(): int
    {
        return $this->fromWalletNumber;
    }

    public function getToWalletNumber(): int
    {
        return $this->toWalletNumber;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (int) $data['from_wallet_number'],
            (int) $data['to_wallet_number'],
            (int) $data['status']
        );
    }
}

