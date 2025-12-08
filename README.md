# FKWallet Laravel Package

Laravel package for integration with fkwallet.io API.

## Recent Changes

## Quick Start

### Using Facade

```php
use Polopolaw\FKWallet\Facades\FKWallet;

$balance = FKWallet::getBalance();

$currencies = FKWallet::getCurrencies();

$withdrawal = FKWallet::createWithdrawal(new \Polopolaw\FKWallet\DTO\Requests\WithdrawalRequest(
    new \Polopolaw\FKWallet\ValueObjects\Amount(100.0),
    new \Polopolaw\FKWallet\ValueObjects\CurrencyId(1),
    new \Polopolaw\FKWallet\ValueObjects\PaymentSystemId(5),
    '79261234567',
    1,
    'unique_order_id'
));
```

### Using Proxy

You can specify a proxy for requests in two ways:

```php
$balance = FKWallet::proxy('http://proxy.example.com:8080')->getBalance();
```

### Using Service

```php
use Polopolaw\FKWallet\Contracts\FKWalletServiceInterface;

$service = app(FKWalletServiceInterface::class);
$balance = $service->getBalance();
```
## Installation

Install the package via Composer:

```bash
composer require polopolaw/fkwallet
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Polopolaw\FKWallet\FKWalletServiceProvider" --tag="config"
```

Add the following to your `.env` file:

```env
FKWALLET_API_URL=https://api.fkwallet.io/v1/
FKWALLET_PUBLIC_KEY=your_public_key_here
FKWALLET_PRIVATE_KEY=your_private_key_here
FKWALLET_TIMEOUT=30
FKWALLET_RETRY_ATTEMPTS=3
```


## Available Methods

> **Note:** All methods use the `FKWALLET_PUBLIC_KEY` and `FKWALLET_PRIVATE_KEY` from your configuration file. You don't need to pass public key as a parameter.

### GET Methods

- `getBalance()` - Get wallet balance
- `getHistory(?string $dateFrom, ?string $dateTo, int $page, int $limit)` - Get transaction history
- `getCurrencies()` - Get list of currencies
- `getPaymentSystems()` - Get payment systems
- `getSbpList()` - Get SBP banks list
- `getMobileCarrierList()` - Get mobile carriers list
- `getWithdrawalStatus(string $orderId, OrderStatusType $type)` - Get withdrawal status
- `getTransferStatus(int $id)` - Get transfer status
- `getOnlineProductCategories()` - Get online product categories
- `getOnlineProducts(int $categoryId)` - Get online products
- `getOnlineOrderStatus(string $orderId)` - Get online order status

### POST Methods

- `createWithdrawal(WithdrawalRequest $request)` - Create withdrawal
- `createTransfer(TransferRequest $request)` - Create transfer
- `createOnlineOrder(OnlineOrderRequest $request)` - Create online order

### Proxy Support

All methods support proxy configuration:

```php
// Using proxy() method
FKWallet::proxy('http://proxy.example.com:8080')->getBalance();

// Chaining proxy() after method
FKWallet::getBalance()->proxy('http://proxy.example.com:8080');
```

## Documentation

For detailed documentation, see the [docs](docs) directory.

To generate Docusaurus documentation:

```bash
cd docs
npm install
npm start
```

## Testing

Run tests with Pest:

```bash
composer test
```

## Requirements

- PHP 8.1+
- Laravel 9.0+ | 10.0+ | 11.0+

## License

MIT

