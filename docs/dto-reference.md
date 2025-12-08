# DTO Reference

Complete reference for all Data Transfer Objects.

## Response DTOs

### BalanceResponse

Represents wallet balance response.

**Methods:**
- `getBalances(): Balance[]` - Get array of balances
- `fromArray(array $data): self` - Create from array

---

### HistoryResponse

Represents transaction history response.

**Methods:**
- `getTransactions(): array` - Get transactions array
- `getTotal(): int` - Get total count
- `getPage(): int` - Get current page
- `getLimit(): int` - Get items per page

---

### CurrencyResponse

Represents currency information.

**Methods:**
- `getId(): int` - Get currency ID
- `getCode(): string` - Get currency code
- `getCourse(): float` - Get currency course

---

### PaymentSystemResponse

Represents payment system information.

**Methods:**
- `getId(): int` - Get payment system ID
- `getCode(): string` - Get payment system code

---

### SbpBankResponse

Represents SBP bank information.

**Methods:**
- `getId(): int` - Get bank ID
- `getName(): string` - Get bank name

---

### MobileCarrierResponse

Represents mobile carrier information.

**Methods:**
- `getId(): int` - Get carrier ID
- `getName(): string` - Get carrier name

---

### WithdrawalResponse

Represents withdrawal creation response.

**Methods:**
- `getId(): int` - Get withdrawal ID
- `getOrderId(): string` - Get order ID
- `getAmount(): float` - Get amount
- `getCurrencyCode(): string` - Get currency code
- `getStatus(): int` - Get status

---

### WithdrawalStatusResponse

Represents withdrawal status response.

**Methods:**
- `getId(): int` - Get withdrawal ID
- `getOrderId(): string` - Get order ID
- `getAmount(): float` - Get amount
- `getCurrencyCode(): string` - Get currency code
- `getStatus(): int` - Get status
- `getErrorMessage(): ?string` - Get error message if any

---

### TransferResponse

Represents transfer creation response.

**Methods:**
- `getId(): int` - Get transfer ID
- `getFromPublicKey(): string` - Get sender public key
- `getToPublicKey(): string` - Get recipient public key
- `getAmount(): float` - Get amount
- `getCurrencyCode(): string` - Get currency code
- `getStatus(): int` - Get status

---

### TransferStatusResponse

Represents transfer status response.

**Methods:**
- `getId(): int` - Get transfer ID
- `getFromWalletNumber(): int` - Get sender wallet number
- `getToWalletNumber(): int` - Get recipient wallet number
- `getStatus(): int` - Get status

---

### OnlineProductCategoryResponse

Represents online product category.

**Methods:**
- `getId(): int` - Get category ID
- `getName(): string` - Get category name

---

### OnlineProductResponse

Represents online product.

**Methods:**
- `getId(): int` - Get product ID
- `getNameRu(): string` - Get product name in Russian
- `getNameEn(): string` - Get product name in English
- `getDescriptionRu(): string` - Get product description in Russian
- `getDescriptionEn(): string` - Get product description in English
- `getHelpDescriptionRu(): string` - Get help description in Russian
- `getHelpDescriptionEn(): string` - Get help description in English
- `getSlug(): string` - Get product slug
- `getPrice(): float` - Get product price
- `getCurrency(): string` - Get currency code
- `getSort(): int` - Get sort order
- `getFields(): array` - Get product fields (array of objects with key, placeholder, values, info)

---

### OnlineOrderResponse

Represents online order creation response.

**Methods:**
- `getOrderId(): string` - Get order ID
- `getProductId(): int` - Get product ID
- `getAmount(): float` - Get amount
- `getCurrencyCode(): string` - Get currency code
- `getStatus(): int` - Get status

---

### OnlineOrderStatusResponse

Represents online order status response.

**Methods:**
- `getOrderId(): string` - Get order ID
- `getProductId(): int` - Get product ID
- `getAmount(): float` - Get amount
- `getCurrencyCode(): string` - Get currency code
- `getStatus(): int` - Get status
- `getErrorMessage(): ?string` - Get error message if any

---

### WithdrawalNotification

Represents withdrawal status notification from FKWallet webhook.

**Methods:**
- `getId(): int` - Get FKWallet operation number
- `getOrderId(): string` - Get your operation number
- `getCurrencyId(): int` - Get currency ID
- `getPaymentSystemId(): int` - Get payment system ID
- `getDescription(): string` - Get description
- `getStatus(): WithdrawalStatus` - Get withdrawal status (returns WithdrawalStatus enum)
- `getAmount(): float` - Get amount
- `getFee(): float` - Get commission
- `getAccount(): string` - Get account
- `fromArray(array $data): self` - Create from array (used for webhook processing)

**Example:**
```php
use Polopolaw\FKWallet\DTO\WithdrawalNotification;

$notification = WithdrawalNotification::fromArray($request->all());
$status = $notification->getStatus(); // Returns WithdrawalStatus enum
```

---

## Request DTOs

### WithdrawalRequest

Request DTO for creating withdrawal.

**Constructor:**
```php
new WithdrawalRequest(
    Amount $amount,
    CurrencyId $currencyId,
    PaymentSystemId $paymentSystemId,
    string $account,
    int $feeFromBalance,
    string $idempotenceKey
)
```

**Methods:**
- `toArray(): array` - Convert to array

---

### TransferRequest

Request DTO for creating transfer.

**Constructor:**
```php
new TransferRequest(
    int $toWalletId,
    Amount $amount,
    CurrencyId $currencyId,
    int $feeFromBalance,
    ?string $description,
    string $idempotenceKey
)
```

**Methods:**
- `getToWalletId(): int` - Get recipient wallet ID
- `getAmount(): Amount` - Get amount
- `getCurrencyId(): CurrencyId` - Get currency ID
- `getFeeFromBalance(): int` - Get fee from balance flag (1 - fee from balance, 0 - fee from payment)
- `getDescription(): ?string` - Get description (nullable)
- `getIdempotenceKey(): string` - Get idempotence key
- `toArray(): array` - Convert to array

---

### OnlineOrderRequest

Request DTO for creating online order.

**Constructor:**
```php
new OnlineOrderRequest(
    int $onlineProductId,
    CurrencyId $currencyId,
    ?float $amount,
    array $fields,
    string $idempotenceKey
)
```

**Parameters:**
- `$onlineProductId` (int) - Product ID
- `$currencyId` (CurrencyId) - Currency ID
- `$amount` (?float) - Amount (optional)
- `$fields` (array) - Additional fields as array of objects with "key" and "value" keys, e.g. `[['key' => 'Input1', 'value' => '@testValue']]`
- `$idempotenceKey` (string) - Unique request key

**Methods:**
- `getOnlineProductId(): int` - Get product ID
- `getCurrencyId(): CurrencyId` - Get currency ID
- `getAmount(): ?float` - Get amount (nullable)
- `getFields(): array` - Get additional fields
- `getIdempotenceKey(): string` - Get idempotence key
- `toArray(): array` - Convert to array

