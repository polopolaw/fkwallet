# API Reference

Complete reference for all available API methods.

> **Important:** All methods use the `FKWALLET_PUBLIC_KEY` and `FKWALLET_PRIVATE_KEY` from your configuration file. You don't need to pass public key as a parameter.

## GET Methods

### getBalance

Get wallet balance.

```php
FKWallet::getBalance(): BalanceResponse
```

**Returns:** `BalanceResponse`

**Example:**
```php
$balance = FKWallet::getBalance();
```

**With proxy:**
```php
$balance = FKWallet::proxy('http://proxy.example.com:8080')->getBalance();
```

---

### getHistory

Get transaction history.

```php
FKWallet::getHistory(
    ?string $dateFrom = null,
    ?string $dateTo = null,
    int $page = 1,
    int $limit = 10
): HistoryResponse
```

**Parameters:**
- `$dateFrom` (string|null) - Start date (format: YYYY-MM-DD)
- `$dateTo` (string|null) - End date (format: YYYY-MM-DD)
- `$page` (int) - Page number
- `$limit` (int) - Items per page

**Returns:** `HistoryResponse`

---

### getCurrencies

Get list of currencies.

```php
FKWallet::getCurrencies(): array
```

**Returns:** Array of `CurrencyResponse`

---

### getPaymentSystems

Get payment systems.

```php
FKWallet::getPaymentSystems(): array
```

**Returns:** Array of `PaymentSystemResponse`

---

### getSbpList

Get SBP banks list.

```php
FKWallet::getSbpList(): array
```

**Returns:** Array of `SbpBankResponse`

---

### getMobileCarrierList

Get mobile carriers list.

```php
FKWallet::getMobileCarrierList(): array
```

**Returns:** Array of `MobileCarrierResponse`

---

### getWithdrawalStatus

Get withdrawal status.

```php
FKWallet::getWithdrawalStatus(
    string $orderId,
    OrderStatusType $type = OrderStatusType::ORDER_ID
): WithdrawalStatusResponse
```

**Parameters:**
- `$orderId` (string) - Order ID or withdrawal ID
- `$type` (OrderStatusType) - Type: `ORDER_ID` or `ID`

**Returns:** `WithdrawalStatusResponse`

---

### getTransferStatus

Get transfer status.

```php
FKWallet::getTransferStatus(int $id): TransferStatusResponse
```

**Parameters:**
- `$id` (int) - Transfer ID

**Returns:** `TransferStatusResponse`

---

### getOnlineProductCategories

Get online product categories.

```php
FKWallet::getOnlineProductCategories(): array
```

**Returns:** Array of `OnlineProductCategoryResponse`

---

### getOnlineProducts

Get online products by category.

```php
FKWallet::getOnlineProducts(int $categoryId): array
```

**Parameters:**
- `$categoryId` (int) - Category ID

**Returns:** Array of `OnlineProductResponse`

---

### getOnlineOrderStatus

Get online order status.

```php
FKWallet::getOnlineOrderStatus(string $orderId): OnlineOrderStatusResponse
```

**Parameters:**
- `$orderId` (string) - Order ID

**Returns:** `OnlineOrderStatusResponse`

---

## POST Methods

### createWithdrawal

Create withdrawal.

```php
FKWallet::createWithdrawal(WithdrawalRequest $request): WithdrawalResponse
```

**Parameters:**
- `$request` (WithdrawalRequest) - Withdrawal request DTO

**Returns:** `WithdrawalResponse`

---

### createTransfer

Create transfer.

```php
FKWallet::createTransfer(TransferRequest $request): TransferResponse
```

**Parameters:**
- `$request` (TransferRequest) - Transfer request DTO

**Returns:** `TransferResponse`

---

### createOnlineOrder

Create online order.

```php
FKWallet::createOnlineOrder(OnlineOrderRequest $request): OnlineOrderResponse
```

**Parameters:**
- `$request` (OnlineOrderRequest) - Online order request DTO

**Returns:** `OnlineOrderResponse`

---

## Proxy Support

All methods support proxy configuration. You can specify a proxy server in two ways:

### Option 1: Start with proxy()

```php
FKWallet::proxy('http://proxy.example.com:8080')->getBalance();
FKWallet::proxy('http://proxy.example.com:8080')->createWithdrawal($request);
```

Both approaches are equivalent and will use the specified proxy for the HTTP request.

## Runtime Credentials

You can override the configured API keys on the fly using `withCredentials()`:

```php
FKWallet::withCredentials('public_key', 'private_key')->getBalance();
```

This works the same way as `proxy()`, allowing you to chain it before or after any call.

