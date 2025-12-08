<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Enums;

enum WithdrawalStatus: int
{
    case PENDING = 0;
    case PROCESSING = 1;
    case COMPLETED = 2;
    case FAILED = 3;
    case CANCELLED = 4;
    case REJECTED = 5;
    case REFUNDED = 6;
    case ON_HOLD = 7;
    case AWAITING_CONFIRMATION = 8;
    case EXPIRED = 9;
    case PARTIALLY_COMPLETED = 10;
    case BLOCKED = 11;
}

