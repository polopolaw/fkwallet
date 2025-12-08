# Exceptions

Complete reference for all exceptions.

## Exception Hierarchy

```
FKWalletException (base)
├── ApiException
├── InvalidPublicKeyException
├── InvalidSignatureException
└── ValidationException
```

## FKWalletException

Base exception for all FKWallet exceptions.

```php
use Polopolaw\FKWallet\Exceptions\FKWalletException;

try {
    // ...
} catch (FKWalletException $e) {
    // Handle any FKWallet exception
}
```

## ApiException

Thrown when API request fails.

**Common causes:**
- Network errors
- Invalid API response
- HTTP errors
- API returned error status

**Example:**
```php
use Polopolaw\FKWallet\Exceptions\ApiException;

try {
    $balance = FKWallet::getBalance();
} catch (ApiException $e) {
    echo 'API Error: ' . $e->getMessage();
}
```

## InvalidPublicKeyException

Thrown when public key is invalid or empty.

**Example:**
```php
use Polopolaw\FKWallet\Exceptions\InvalidPublicKeyException;
use Polopolaw\FKWallet\ValueObjects\PublicKey;

try {
    $publicKey = new PublicKey('');
} catch (InvalidPublicKeyException $e) {
    echo 'Invalid public key: ' . $e->getMessage();
}
```

## InvalidSignatureException

Thrown when private key is invalid or signature generation fails.

**Example:**
```php
use Polopolaw\FKWallet\Exceptions\InvalidSignatureException;
use Polopolaw\FKWallet\ValueObjects\PrivateKey;

try {
    $privateKey = new PrivateKey('');
} catch (InvalidSignatureException $e) {
    echo 'Invalid private key: ' . $e->getMessage();
}
```

## ValidationException

Thrown when request validation fails.

**Example:**
```php
use Polopolaw\FKWallet\Exceptions\ValidationException;
use Polopolaw\FKWallet\ValueObjects\Amount;

try {
    $amount = new Amount(-100);
} catch (ValidationException $e) {
    echo 'Validation error: ' . $e->getMessage();
}
```

## Error Handling Best Practices

### Catch Specific Exceptions

```php
use Polopolaw\FKWallet\Exceptions\ApiException;
use Polopolaw\FKWallet\Exceptions\ValidationException;

try {
    $balance = FKWallet::getBalance();
} catch (ApiException $e) {
    // Handle API errors
    Log::error('FKWallet API error', ['error' => $e->getMessage()]);
} catch (ValidationException $e) {
    // Handle validation errors
    Log::warning('FKWallet validation error', ['error' => $e->getMessage()]);
}
```

### Retry Logic

```php
use Polopolaw\FKWallet\Exceptions\ApiException;

$maxRetries = 3;
$attempt = 0;

while ($attempt < $maxRetries) {
    try {
        $balance = FKWallet::getBalance();
        break;
    } catch (ApiException $e) {
        $attempt++;
        if ($attempt >= $maxRetries) {
            throw $e;
        }
        sleep(1);
    }
}
```

