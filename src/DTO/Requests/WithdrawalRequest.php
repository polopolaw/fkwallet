<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO\Requests;

use Polopolaw\FKWallet\ValueObjects\Amount;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;
use Polopolaw\FKWallet\ValueObjects\PaymentSystemId;

final class WithdrawalRequest
{
    public function __construct(
        private readonly Amount $amount,
        private readonly CurrencyId $currencyId,
        private readonly PaymentSystemId $paymentSystemId,
        private readonly string $account,
        private readonly int $feeFromBalance,
        private readonly string $idempotenceKey
    ) {
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrencyId(): CurrencyId
    {
        return $this->currencyId;
    }

    public function getPaymentSystemId(): PaymentSystemId
    {
        return $this->paymentSystemId;
    }

    public function getAccount(): string
    {
        return $this->account;
    }

    public function getFeeFromBalance(): int
    {
        return $this->feeFromBalance;
    }

    public function getIdempotenceKey(): string
    {
        return $this->idempotenceKey;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount->getValue(),
            'currency_id' => $this->currencyId->getValue(),
            'payment_system_id' => $this->paymentSystemId->getValue(),
            'account' => $this->account,
            'fee_from_balance' => $this->feeFromBalance,
            'idempotence_key' => $this->idempotenceKey,
        ];
    }
}

