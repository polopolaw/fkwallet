<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Facades;

use Illuminate\Support\Facades\Facade;
use Polopolaw\FKWallet\Contracts\FKWalletServiceInterface;
use Polopolaw\FKWallet\DTO\BalanceResponse;
use Polopolaw\FKWallet\DTO\CurrencyResponse;
use Polopolaw\FKWallet\DTO\HistoryResponse;
use Polopolaw\FKWallet\DTO\MobileCarrierResponse;
use Polopolaw\FKWallet\DTO\OnlineOrderResponse;
use Polopolaw\FKWallet\DTO\OnlineOrderStatusResponse;
use Polopolaw\FKWallet\DTO\OnlineProductCategoryResponse;
use Polopolaw\FKWallet\DTO\OnlineProductResponse;
use Polopolaw\FKWallet\DTO\PaymentSystemResponse;
use Polopolaw\FKWallet\DTO\Requests\OnlineOrderRequest;
use Polopolaw\FKWallet\DTO\Requests\TransferRequest;
use Polopolaw\FKWallet\DTO\Requests\WithdrawalRequest;
use Polopolaw\FKWallet\DTO\SbpBankResponse;
use Polopolaw\FKWallet\DTO\TransferResponse;
use Polopolaw\FKWallet\DTO\TransferStatusResponse;
use Polopolaw\FKWallet\DTO\WithdrawalResponse;
use Polopolaw\FKWallet\DTO\WithdrawalStatusResponse;
use Polopolaw\FKWallet\Enums\OrderStatusType;

/**
 * @method static FKWalletServiceInterface proxy(string $proxy)
 * @method static FKWalletServiceInterface withCredentials(string $publicKey, string $privateKey)
 * @method static BalanceResponse getBalance()
 * @method static HistoryResponse getHistory(?string $dateFrom = null, ?string $dateTo = null, int $page = 1, int $limit = 10)
 * @method static array<CurrencyResponse> getCurrencies()
 * @method static array<PaymentSystemResponse> getPaymentSystems()
 * @method static array<SbpBankResponse> getSbpList()
 * @method static array<MobileCarrierResponse> getMobileCarrierList()
 * @method static WithdrawalStatusResponse getWithdrawalStatus(string|int $orderId, OrderStatusType $type = OrderStatusType::ORDER_ID)
 * @method static TransferStatusResponse getTransferStatus(int|string $id)
 * @method static array<OnlineProductCategoryResponse> getOnlineProductCategories()
 * @method static array<OnlineProductResponse> getOnlineProducts(int $categoryId)
 * @method static OnlineOrderStatusResponse getOnlineOrderStatus(int $orderId)
 * @method static WithdrawalResponse createWithdrawal(WithdrawalRequest $request)
 * @method static TransferResponse createTransfer(TransferRequest $request)
 * @method static OnlineOrderResponse createOnlineOrder(OnlineOrderRequest $request)
 * 
 * @see FKWalletService
 */
class FKWallet extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FKWalletServiceInterface::class;
    }
}

