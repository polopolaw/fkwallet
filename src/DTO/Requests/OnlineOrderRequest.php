<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO\Requests;

use Polopolaw\FKWallet\ValueObjects\CurrencyId;

final class OnlineOrderRequest
{
    /**
     * @param array<int, array{key: string, value: string}> $fields
     */
    public function __construct(
        private readonly int $onlineProductId,
        private readonly CurrencyId $currencyId,
        private readonly ?float $amount,
        private readonly array $fields,
        private readonly string $idempotenceKey
    ) {
        $this->validateFields($fields);
    }

    public function getOnlineProductId(): int
    {
        return $this->onlineProductId;
    }

    public function getCurrencyId(): CurrencyId
    {
        return $this->currencyId;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @return array<int, array{key: string, value: string}>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getIdempotenceKey(): string
    {
        return $this->idempotenceKey;
    }

    public function toArray(): array
    {
        $data = [
            'online_product_id' => $this->onlineProductId,
            'currency_id' => $this->currencyId->getValue(),
            'fields' => $this->fields,
            'idempotence_key' => $this->idempotenceKey,
        ];

        if ($this->amount !== null) {
            $data['amount'] = $this->amount;
        }

        return $data;
    }

    /**
     * @param array<int, array{key: string, value: string}> $fields
     */
    private function validateFields(array $fields): void
    {
        foreach ($fields as $field) {
            if (!isset($field['key']) || !isset($field['value'])) {
                throw new \InvalidArgumentException('Each field must have "key" and "value" keys');
            }
            if (!is_string($field['key']) || !is_string($field['value'])) {
                throw new \InvalidArgumentException('Field "key" and "value" must be strings');
            }
        }
    }
}

