<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Enums;

enum OrderStatusType: string
{
    case ID = 'id'; // id - номер заказа в нашей системе
    case ORDER_ID = 'order_id'; // Ваш номер заказа
}

