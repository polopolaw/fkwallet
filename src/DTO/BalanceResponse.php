<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

use Polopolaw\FKWallet\ValueObjects\Balance;

final class BalanceResponse
{
    /**
     * @param Balance[] $balances
     */
    public function __construct(
        private readonly array $balances
    ) {
    }

    /**
     * @return Balance[]
     */
    public function getBalances(): array
    {
        return $this->balances;
    }

    public static function fromArray(array $data): self
    {
        $balances = [];
        foreach ($data as $balanceData) {
            $balances[] = new Balance(
                $balanceData['currency_code'],
                (float) $balanceData['value']
            );
        }

        return new self($balances);
    }
}

