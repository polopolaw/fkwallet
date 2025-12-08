<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO\Requests;

use Polopolaw\FKWallet\ValueObjects\Amount;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;

final class TransferRequest
{
    public function __construct(
        private readonly int $toWalletId,
        private readonly Amount $amount,
        private readonly CurrencyId $currencyId,
        private readonly int $feeFromBalance,
        private readonly ?string $description,
        private readonly string $idempotenceKey,
    ) {
    }

    public function getToWalletId(): int
    {
        return $this->toWalletId;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrencyId(): CurrencyId
    {
        return $this->currencyId;
    }

    public function getFeeFromBalance(): int
    {
        return $this->feeFromBalance;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIdempotenceKey(): string
    {
        return $this->idempotenceKey;
    }

    public function toArray(): array
    {
        $data = [
            'to_wallet_id' => "F$this->toWalletId",
            'amount' => $this->amount->getValue(),
            'currency_id' => $this->currencyId->getValue(),
            'fee_from_balance' => $this->feeFromBalance,
            'idempotence_key' => $this->idempotenceKey,
        ];

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        return $data;
    }
}

