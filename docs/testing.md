# Testing

Guide for testing with FKWallet package.

## Running Tests

```bash
composer test
```

## Test Structure

```
tests/
├── TestCase.php
├── Unit/
│   ├── ValueObjectsTest.php
│   ├── DTOTest.php
│   ├── SignatureGeneratorTest.php
│   └── ServiceTest.php
└── Feature/
    └── ApiIntegrationTest.php
```

## Unit Tests

### Testing Value Objects

```php
use Polopolaw\FKWallet\ValueObjects\Amount;

test('amount must be greater than zero', function () {
    expect(fn() => new Amount(-100))
        ->toThrow(InvalidArgumentException::class);
});
```

### Testing DTOs

```php
use Polopolaw\FKWallet\DTO\BalanceResponse;

test('balance response from array', function () {
    $data = [
        ['currency_code' => 'USD', 'value' => 100.0],
        ['currency_code' => 'EUR', 'value' => 50.0],
    ];
    
    $response = BalanceResponse::fromArray($data);
    expect($response->getBalances())->toHaveCount(2);
});
```

## Integration Tests

### Mocking HTTP Client

```php
use Polopolaw\FKWallet\Http\ClientInterface;
use Polopolaw\FKWallet\Http\Response;

test('get balance', function () {
    $mockClient = Mockery::mock(ClientInterface::class);
    $mockClient->shouldReceive('get')
        ->once()
        ->andReturn(new Response(200, [
            'data' => [
                'status' => 'ok',
                'data' => [
                    ['currency_code' => 'USD', 'value' => 100.0],
                ],
            ],
        ]));
    
    $service = new FKWalletService(
        $mockClient,
        'https://api.fkwallet.io/v1/',
        'public_key',
        'private_key'
    );
    
    $balance = $service->getBalance();
    expect($balance->getBalances())->toHaveCount(1);
});
```

## Test Helpers

### Creating Test Data

```php
use Polopolaw\FKWallet\ValueObjects\Amount;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;

function createTestAmount(float $value = 100.0): Amount
{
    return new Amount($value);
}

function createTestCurrencyId(int $id = 1): CurrencyId
{
    return new CurrencyId($id);
}
```

## Pest Configuration

The package uses Pest for testing. Configuration is in `pest.php`:

```php
<?php

declare(strict_types=1);

use Orchestra\Testbench\TestCase;

uses(TestCase::class)->in(__DIR__);
```

## Test Coverage

Run tests with coverage:

```bash
composer test -- --coverage
```

## Continuous Integration

Example GitHub Actions workflow:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
      - run: composer install
      - run: composer test
```

