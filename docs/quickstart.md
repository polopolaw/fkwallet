# Quick Start

Get started with FKWallet package in minutes.

## Installation

```bash
composer require polopolaw/fkwallet
```

## Configuration

Publish and configure:

```bash
php artisan vendor:publish --provider="Polopolaw\FKWallet\FKWalletServiceProvider" --tag="config"
```

Add to `.env`:

```env
FKWALLET_API_URL=https://api.fkwallet.io/v1/
FKWALLET_PUBLIC_KEY=your_public_key
FKWALLET_PRIVATE_KEY=your_private_key
```

## Basic Usage

### Get Balance

```php
use Polopolaw\FKWallet\Facades\FKWallet;

$balance = FKWallet::getBalance();
$balances = $balance->getBalances();

foreach ($balances as $balance) {
    echo $balance->getCurrencyCode() . ': ' . $balance->getValue();
}
```

### Get Currencies

```php
$currencies = FKWallet::getCurrencies();

foreach ($currencies as $currency) {
    echo $currency->getId() . ' - ' . $currency->getCode() . ' - ' . $currency->getCourse();
}
```

### Create Withdrawal

```php
use Polopolaw\FKWallet\DTO\Requests\WithdrawalRequest;
use Polopolaw\FKWallet\ValueObjects\Amount;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;
use Polopolaw\FKWallet\ValueObjects\PaymentSystemId;

$request = new WithdrawalRequest(
    new Amount(100.0),
    new CurrencyId(1),
    new PaymentSystemId(5),
    '79261234567',
    1,
    'unique_order_id_' . time()
);

$withdrawal = FKWallet::createWithdrawal($request);
```

### Using Proxy

You can use a proxy server for requests:

```php
$balance = FKWallet::proxy('http://proxy.example.com:8080')->getBalance();
```

## Next Steps

- Read [Installation Guide](installation.md) for detailed setup
- Check [Usage Examples](usage.md) for more examples
- See [API Reference](api-reference.md) for all available methods

