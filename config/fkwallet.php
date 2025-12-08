<?php

declare(strict_types=1);

return [
    'api_url' => env('FKWALLET_API_URL', 'https://api.fkwallet.io/v1/'),
    'public_key' => env('FKWALLET_PUBLIC_KEY', ''),
    'private_key' => env('FKWALLET_PRIVATE_KEY', ''),
    'timeout' => (int) env('FKWALLET_TIMEOUT', 30),
    'retry_attempts' => (int) env('FKWALLET_RETRY_ATTEMPTS', 3),
    'webhook_controller' => env('FKWALLET_WEBHOOK_CONTROLLER', \Polopolaw\FKWallet\Http\Controllers\WithdrawalNotificationController::class),
];


