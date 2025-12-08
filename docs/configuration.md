# Configuration

## Environment Variables

All configuration can be set via environment variables in your `.env` file:

```env
FKWALLET_API_URL=https://api.fkwallet.io/v1/
FKWALLET_PUBLIC_KEY=your_public_key_here
FKWALLET_PRIVATE_KEY=your_private_key_here
FKWALLET_TIMEOUT=30
FKWALLET_RETRY_ATTEMPTS=3
FKWALLET_WEBHOOK_CONTROLLER=Polopolaw\FKWallet\Http\Controllers\WithdrawalNotificationController
```

## Configuration File

The configuration file is located at `config/fkwallet.php`:

```php
return [
    'api_url' => env('FKWALLET_API_URL', 'https://api.fkwallet.io/v1/'),
    'public_key' => env('FKWALLET_PUBLIC_KEY', ''),
    'private_key' => env('FKWALLET_PRIVATE_KEY', ''),
    'timeout' => (int) env('FKWALLET_TIMEOUT', 30),
    'retry_attempts' => (int) env('FKWALLET_RETRY_ATTEMPTS', 3),
    'webhook_controller' => env('FKWALLET_WEBHOOK_CONTROLLER', \Polopolaw\FKWallet\Http\Controllers\WithdrawalNotificationController::class),
];
```

## Runtime Configuration

You can also configure the service at runtime:

```php
use Polopolaw\FKWallet\Contracts\FKWalletServiceInterface;

$service = app(FKWalletServiceInterface::class);
```

## Proxy Configuration

The package supports proxy configuration for HTTP requests. You can specify a proxy in two ways:

### Using Facade with proxy()

```php
use Polopolaw\FKWallet\Facades\FKWallet;

// Option 1: Start with proxy()
$balance = FKWallet::proxy('http://proxy.example.com:8080')->getBalance();

// Option 2: Chain proxy() after method
$balance = FKWallet::getBalance()->proxy('http://proxy.example.com:8080');
```

### Using Service directly

```php
use Polopolaw\FKWallet\Contracts\FKWalletServiceInterface;

$service = app(FKWalletServiceInterface::class);
$service->setProxy('http://proxy.example.com:8080');
$balance = $service->getBalance();
$service->setProxy(null); // Clear proxy after use
```

**Proxy format:**
- HTTP proxy: `http://proxy.example.com:8080`
- HTTPS proxy: `https://proxy.example.com:8080`
- SOCKS5 proxy: `socks5://proxy.example.com:1080`

## Multiple Public Keys

If you need to work with multiple public keys, you can create service instances manually:

```php
use Polopolaw\FKWallet\Http\GuzzleClient;
use Polopolaw\FKWallet\Services\FKWalletService;
use GuzzleHttp\Client;

$client = new GuzzleClient(
    new Client(['base_uri' => config('fkwallet.api_url')]),
    config('fkwallet.timeout'),
    config('fkwallet.retry_attempts')
);

$service = new FKWalletService(
    $client,
    config('fkwallet.api_url'),
    'public_key_1',
    'private_key_1'
);
```

## IP Validation Middleware

For webhook endpoints, use the IP validation middleware:

```php
use Polopolaw\FKWallet\Middleware\ValidateFKWalletIp;

Route::post('/webhook/fkwallet', [WebhookController::class, 'handle'])
    ->middleware(ValidateFKWalletIp::class);
```

Allowed IPs:
- 168.119.157.136
- 168.119.60.227
- 178.154.197.79
- 51.250.54.238

## Webhook Controller Configuration

By default, the package provides a built-in controller `WithdrawalNotificationController` for handling withdrawal status notifications. You can use your own controller by specifying it in the configuration:

```env
FKWALLET_WEBHOOK_CONTROLLER=App\Http\Controllers\YourCustomWebhookController
```

Or in the config file:

```php
'webhook_controller' => \App\Http\Controllers\YourCustomWebhookController::class,
```

The default controller is `Polopolaw\FKWallet\Http\Controllers\WithdrawalNotificationController`.

