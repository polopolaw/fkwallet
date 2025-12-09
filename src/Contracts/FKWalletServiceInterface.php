<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Contracts;

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

interface FKWalletServiceInterface
{
    public function proxy(string $proxy): static;
    public function withCredentials(string $publicKey, string $privateKey): static;
    public function getBalance(): BalanceResponse;

    public function getHistory(
        ?string $dateFrom = null,
        ?string $dateTo = null,
        int $page = 1,
        int $limit = 10
    ): HistoryResponse;

    public function getCurrencies(): array;

    public function getPaymentSystems(): array;

    public function getSbpList(): array;

    public function getMobileCarrierList(): array;

    public function getWithdrawalStatus(int|string $orderId, OrderStatusType $type = OrderStatusType::ORDER_ID): WithdrawalStatusResponse;

    public function getTransferStatus(int|string $id): TransferStatusResponse;

    public function getOnlineProductCategories(): array;

    public function getOnlineProducts(int $categoryId): array;

    public function getOnlineOrderStatus(int $orderId): OnlineOrderStatusResponse;

    public function createWithdrawal(WithdrawalRequest $request): WithdrawalResponse;

    public function createTransfer(TransferRequest $request): TransferResponse;

    public function createOnlineOrder(OnlineOrderRequest $request): OnlineOrderResponse;
}

