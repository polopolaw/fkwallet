<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class HistoryResponse
{
    /**
     * @param Transaction[] $transactions
     */
    public function __construct(
        private readonly array $transactions
    ) {
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public static function fromArray(array $data): self
    {
        $transactions = [];
        
        // Если данные приходят как массив транзакций напрямую
        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $transactionData) {
                $transactions[] = Transaction::fromArray($transactionData);
            }
        }
        
        return new self($transactions);
    }
}

