<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\DTO;


final class OnlineOrderResponse
{
    public function __construct(
        private readonly int $id,
        private readonly int $status,
        private readonly ?string $couponCode = null,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            (int) $data['status'],
            $data['coupon_code'],
        );
    }
}

