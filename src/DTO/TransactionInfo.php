<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;

final class TransactionInfo
{
    public function __construct(
        private readonly int $id,
        private readonly float $amount,
        private readonly ?float $amountTo,
        private readonly float $fee,
        private readonly ?string $account,
        private readonly ?string $extPaymentId,
        private readonly string $status,
        private readonly string $statusTitle,
        private readonly string $description,
        private readonly ?string $currencyFromCode,
        private readonly ?string $currencyToCode,
        private readonly ?string $courseCurrency,
        private readonly ?float $course,
        private readonly string $createdAt,
        private readonly ?string $completedAt,
        private readonly ?string $userOrderId,
        private readonly ?string $bankName,
        private readonly ?int $paymentSystemId,
        private readonly ?string $subType
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAmountTo(): ?float
    {
        return $this->amountTo;
    }

    public function getFee(): float
    {
        return $this->fee;
    }

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function getExtPaymentId(): ?string
    {
        return $this->extPaymentId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusTitle(): string
    {
        return $this->statusTitle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCurrencyFromCode(): ?string
    {
        return $this->currencyFromCode;
    }

    public function getCurrencyToCode(): ?string
    {
        return $this->currencyToCode;
    }

    public function getCourseCurrency(): ?string
    {
        return $this->courseCurrency;
    }

    public function getCourse(): ?float
    {
        return $this->course;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getCompletedAt(): ?string
    {
        return $this->completedAt;
    }

    public function getUserOrderId(): ?string
    {
        return $this->userOrderId;
    }

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function getPaymentSystemId(): ?int
    {
        return $this->paymentSystemId;
    }

    public function getSubType(): ?string
    {
        return $this->subType;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (float) $data['amount'],
            isset($data['amount_to']) && $data['amount_to'] !== null ? (float) $data['amount_to'] : null,
            (float) ($data['fee'] ?? 0),
            $data['account'] ?? null,
            $data['ext_payment_id'] ?? null,
            $data['status'],
            $data['status_title'],
            $data['description'] ?? '',
            $data['currency_from_code'] ?? null,
            $data['currency_to_code'] ?? null,
            $data['course_currency'] ?? null,
            isset($data['course']) && $data['course'] !== null ? (float) $data['course'] : null,
            $data['created_at'],
            $data['completed_at'] ?? null,
            $data['user_order_id'] ?? null,
            $data['bank_name'] ?? null,
            isset($data['payment_system_id']) && $data['payment_system_id'] !== null ? (int) $data['payment_system_id'] : null,
            $data['sub_type'] ?? null
        );
    }
}

