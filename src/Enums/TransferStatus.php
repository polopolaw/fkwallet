<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Enums;

enum TransferStatus: int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case FAILED = 2;
    case CANCELLED = 8;
    case REFUNDED = 9;
}

