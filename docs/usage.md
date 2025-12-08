# Usage Examples

## Getting Wallet Balance

```php
use Polopolaw\FKWallet\Facades\FKWallet;

$balance = FKWallet::getBalance();
$balances = $balance->getBalances();

foreach ($balances as $balanceItem) {
    echo $balanceItem->getCurrencyCode() . ': ' . $balanceItem->getValue() . PHP_EOL;
}
```

## Getting Transaction History

```php
$history = FKWallet::getHistory(
    dateFrom: '2024-01-01',
    dateTo: '2024-12-31',
    page: 1,
    limit: 50
);

$transactions = $history->getTransactions();
$total = $history->getTotal();
```

## Getting Currencies

```php
$currencies = FKWallet::getCurrencies();

foreach ($currencies as $currency) {
    echo $currency->getId() . ' - ' . $currency->getCode() . ' - ' . $currency->getCourse() . PHP_EOL;
}
```

## Using Proxy

You can specify a proxy server for requests in two ways:

### Option 1: Start with proxy()

```php
$balance = FKWallet::proxy('http://proxy.example.com:8080')->getBalance();
$currencies = FKWallet::proxy('http://proxy.example.com:8080')->getCurrencies();
```

### Option 2: Chain proxy() after method

```php
$balance = FKWallet::getBalance()->proxy('http://proxy.example.com:8080');
$history = FKWallet::getHistory(dateFrom: '2024-01-01')->proxy('http://proxy.example.com:8080');
```

Both approaches are equivalent and will use the specified proxy for the HTTP request.

## Creating a Withdrawal

```php
use Polopolaw\FKWallet\DTO\Requests\WithdrawalRequest;
use Polopolaw\FKWallet\ValueObjects\Amount;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;
use Polopolaw\FKWallet\ValueObjects\PaymentSystemId;

$request = new WithdrawalRequest(
    new Amount(100.0),
    new CurrencyId(1),
    new PaymentSystemId(5),
    account: '79261234567',
    feeFromBalance: 1,
    idempotenceKey: 'unique_order_id_' . time()
);

$withdrawal = FKWallet::createWithdrawal($request);
echo 'Withdrawal ID: ' . $withdrawal->getId() . PHP_EOL;
echo 'Order ID: ' . $withdrawal->getOrderId() . PHP_EOL;
```

## Creating a Transfer

```php
use Polopolaw\FKWallet\DTO\Requests\TransferRequest;
use Polopolaw\FKWallet\ValueObjects\Amount;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;

$request = new TransferRequest(
    toWalletId: 12345,
    amount: new Amount(50.0),
    currencyId: new CurrencyId(1),
    feeFromBalance: 1,
    description: 'Payment for services',
    idempotenceKey: 'transfer_' . time()
);

$transfer = FKWallet::createTransfer($request);
echo 'Transfer ID: ' . $transfer->getId() . PHP_EOL;
```

## Checking Withdrawal Status

```php
use Polopolaw\FKWallet\Enums\OrderStatusType;

$status = FKWallet::getWithdrawalStatus(
    'order_id_123',
    OrderStatusType::ORDER_ID
);

echo 'Status: ' . $status->getStatus() . PHP_EOL;
if ($status->getErrorMessage()) {
    echo 'Error: ' . $status->getErrorMessage() . PHP_EOL;
}
```

## Getting Online Products

```php
$categories = FKWallet::getOnlineProductCategories();

foreach ($categories as $category) {
    echo $category->getId() . ' - ' . $category->getName() . PHP_EOL;
    
    $products = FKWallet::getOnlineProducts($category->getId());
    foreach ($products as $product) {
        echo '  ' . $product->getNameRu() . ' - ' . $product->getPrice() . ' ' . $product->getCurrency() . PHP_EOL;
        echo '    Description: ' . $product->getDescriptionRu() . PHP_EOL;
        echo '    Slug: ' . $product->getSlug() . PHP_EOL;
    }
}
```

## Creating Online Order

```php
use Polopolaw\FKWallet\DTO\Requests\OnlineOrderRequest;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;

$request = new OnlineOrderRequest(
    onlineProductId: 123,
    currencyId: new CurrencyId(1),
    amount: 100.0,
    fields: [
        ['key' => 'Input1', 'value' => '@testValue'],
        ['key' => 'Input2', 'value' => 'anotherValue']
    ],
    idempotenceKey: 'order_' . time()
);

$order = FKWallet::createOnlineOrder($request);
echo 'Order ID: ' . $order->getOrderId() . PHP_EOL;
```

## Error Handling

```php
use Polopolaw\FKWallet\Exceptions\ApiException;
use Polopolaw\FKWallet\Exceptions\ValidationException;

try {
    $balance = FKWallet::getBalance();
} catch (ApiException $e) {
    echo 'API Error: ' . $e->getMessage();
} catch (ValidationException $e) {
    echo 'Validation Error: ' . $e->getMessage();
}
```

