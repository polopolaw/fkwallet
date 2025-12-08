<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Polopolaw\FKWallet\DTO\WithdrawalNotification;

class WithdrawalNotificationController
{
    /**
     * Handle withdrawal status notification from FKWallet.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $notification = WithdrawalNotification::fromArray($data);

            // Here you can add your custom logic to process the notification
            // For example: update withdrawal status in your database, send emails, etc.
            
            // Example: Log the notification
            // \Log::info('Withdrawal notification received', [
            //     'id' => $notification->getId(),
            //     'order_id' => $notification->getOrderId(),
            //     'status' => $notification->getStatus()->value,
            // ]);

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            return response()->json(
                ['status' => 'error', 'message' => $e->getMessage()],
                400
            );
        }
    }
}

