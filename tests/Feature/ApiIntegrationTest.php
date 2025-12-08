<?php

declare(strict_types=1);

use Polopolaw\FKWallet\Contracts\FKWalletServiceInterface;
use Polopolaw\FKWallet\Http\ClientInterface;
use Polopolaw\FKWallet\Http\Response;
use Polopolaw\FKWallet\Services\FKWalletService;
use Mockery;

test('service can be resolved from container', function () {
    $service = app(FKWalletServiceInterface::class);
    
    expect($service)->toBeInstanceOf(FKWalletServiceInterface::class);
});

test('get balance makes correct API call', function () {
    $mockClient = Mockery::mock(ClientInterface::class);
    $mockClient->shouldReceive('get')
        ->once()
        ->with(
            'https://api.fkwallet.io/v1/test_public_key/balance',
            Mockery::on(function ($headers) {
                return is_array($headers) 
                    && isset($headers['Authorization']) 
                    && isset($headers['Accept'])
                    && str_starts_with($headers['Authorization'], 'Bearer ');
            }),
            null
        )
        ->andReturn(new Response(200, [
            'status' => 'ok',
            'data' => [
                ['currency_code' => 'USD', 'value' => 100.0],
            ],
        ]));
    
    $service = new FKWalletService(
        $mockClient,
        'https://api.fkwallet.io/v1/',
        'test_public_key',
        'test_private_key'
    );
    
    $balance = $service->getBalance();
    expect($balance->getBalances())->toHaveCount(1);
    expect($balance->getBalances()[0]->getCurrencyCode())->toBe('USD');
    expect($balance->getBalances()[0]->getValue())->toBe(100.0);
});

