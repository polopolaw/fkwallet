# Webhooks

Guide for handling FKWallet webhooks.

## Overview

FKWallet sends notifications (in form-data format) when withdrawal status changes. You can configure the notification URL in your personal account, in the API key settings.

**Important:** Always verify the IP address of the server sending you information. FKWallet IP addresses:
- 168.119.157.136
- 168.119.60.227
- 178.154.197.79
- 51.250.54.238

## Default Controller

The package provides a default controller `WithdrawalNotificationController` for handling withdrawal status notifications. This controller:

- Validates incoming notification data
- Creates a `WithdrawalNotification` DTO from the request
- Returns a JSON response

### Using Default Controller

```php
// routes/web.php

use Polopolaw\FKWallet\Http\Controllers\WithdrawalNotificationController;
use Polopolaw\FKWallet\Middleware\ValidateFKWalletIp;

Route::post('/webhook/fkwallet', [WithdrawalNotificationController::class, 'handle'])
    ->middleware(ValidateFKWalletIp::class)
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
```

### Customizing Default Controller

You can extend the default controller to add your own logic:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Polopolaw\FKWallet\DTO\WithdrawalNotification;
use Polopolaw\FKWallet\Http\Controllers\WithdrawalNotificationController as BaseController;

class CustomWebhookController extends BaseController
{
    public function handle(Request $request)
    {
        $data = $request->all();
        $notification = WithdrawalNotification::fromArray($data);
        
        // Your custom logic here
        // Example: Update withdrawal status in database
        // Withdrawal::where('order_id', $notification->getOrderId())
        //     ->update(['status' => $notification->getStatus()]);
        
        return response()->json(['status' => 'ok']);
    }
}
```

### Using Your Own Controller

If you want to use a completely different controller, you can configure it in `config/fkwallet.php`:

```php
'webhook_controller' => \App\Http\Controllers\YourCustomWebhookController::class,
```

Or via environment variable:

```env
FKWALLET_WEBHOOK_CONTROLLER=App\Http\Controllers\YourCustomWebhookController
```

## IP Validation

FKWallet sends webhooks from specific IP addresses. Always validate the IP address before processing webhooks.

### Using Middleware

```php
use Polopolaw\FKWallet\Middleware\ValidateFKWalletIp;

Route::post('/webhook/fkwallet', [WebhookController::class, 'handle'])
    ->middleware(ValidateFKWalletIp::class);
```

### Allowed IPs

- 168.119.157.136
- 168.119.60.227
- 178.154.197.79
- 51.250.54.238

### Manual IP Validation

```php
use Illuminate\Http\Request;

$allowedIps = [
    '168.119.157.136',
    '168.119.60.227',
    '178.154.197.79',
    '51.250.54.238',
];

if (!in_array($request->ip(), $allowedIps, true)) {
    abort(403, 'Access denied');
}
```

## Webhook Data Structure

Withdrawal status notifications contain the following parameters:

| Parameter | Description |
|-----------|-------------|
| `id` | FKWallet operation number |
| `order_id` | Your operation number |
| `currency_id` | Currency ID |
| `payment_system_id` | Payment system ID |
| `description` | Description |
| `status` | Withdrawal status |
| `amount` | Amount |
| `fee` | Commission |
| `account` | Account |

### Using WithdrawalNotification DTO

The package provides a `WithdrawalNotification` DTO that you can use to work with notification data:

```php
use Polopolaw\FKWallet\DTO\WithdrawalNotification;

$notification = WithdrawalNotification::fromArray($request->all());

// Access notification data
$id = $notification->getId();
$orderId = $notification->getOrderId();
$currencyId = $notification->getCurrencyId();
$paymentSystemId = $notification->getPaymentSystemId();
$description = $notification->getDescription();
$status = $notification->getStatus(); // Returns WithdrawalStatus enum
$amount = $notification->getAmount();
$fee = $notification->getFee();
$account = $notification->getAccount();
```

## Complete Example

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Polopolaw\FKWallet\DTO\WithdrawalNotification;
use Polopolaw\FKWallet\Middleware\ValidateFKWalletIp;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $notification = WithdrawalNotification::fromArray($request->all());
            
            // Process notification
            \Log::info('Withdrawal notification received', [
                'id' => $notification->getId(),
                'order_id' => $notification->getOrderId(),
                'status' => $notification->getStatus()->value,
                'amount' => $notification->getAmount(),
            ]);
            
            // Update your database, send notifications, etc.
            
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            \Log::error('Webhook processing error', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);
            
            return response()->json(
                ['status' => 'error', 'message' => $e->getMessage()],
                400
            );
        }
    }
}
```

## Route Configuration

```php
// routes/web.php

use App\Http\Controllers\WebhookController;
use Polopolaw\FKWallet\Middleware\ValidateFKWalletIp;

Route::post('/webhook/fkwallet', [WebhookController::class, 'handle'])
    ->middleware(ValidateFKWalletIp::class)
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
```

## Security Best Practices

1. Always validate IP addresses using the `ValidateFKWalletIp` middleware
2. Use HTTPS for webhook endpoints
3. Implement idempotency checks to prevent duplicate processing
4. Log all webhook events for debugging and auditing
5. Handle errors gracefully and return appropriate HTTP status codes
6. Validate all incoming data before processing
7. Consider implementing rate limiting for webhook endpoints

