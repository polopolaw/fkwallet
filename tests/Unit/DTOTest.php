<?php

declare(strict_types=1);

use Polopolaw\FKWallet\DTO\BalanceResponse;
use Polopolaw\FKWallet\DTO\CurrencyResponse;
use Polopolaw\FKWallet\DTO\PaymentSystemResponse;
use Polopolaw\FKWallet\ValueObjects\Balance;

test('balance response from array', function () {
    $data = [
        ['currency_code' => 'USD', 'value' => 100.0],
        ['currency_code' => 'EUR', 'value' => 50.0],
    ];
    
    $response = BalanceResponse::fromArray($data);
    $balances = $response->getBalances();
    
    expect($balances)->toHaveCount(2);
    expect($balances[0])->toBeInstanceOf(Balance::class);
    expect($balances[0]->getCurrencyCode())->toBe('USD');
    expect($balances[0]->getValue())->toBe(100.0);
});

test('currency response from array', function () {
    $data = [
        'id' => 1,
        'code' => 'USD',
        'course' => 1.0,
    ];
    
    $response = CurrencyResponse::fromArray($data);
    
    expect($response->getId())->toBe(1);
    expect($response->getCode())->toBe('USD');
    expect($response->getCourse())->toBe(1.0);
});

test('payment system response from array', function () {
    $data = [
        'id' => 5,
        'code' => 'SBP',
    ];
    
    $response = PaymentSystemResponse::fromArray($data);
    
    expect($response->getId())->toBe(5);
    expect($response->getCode())->toBe('SBP');
});

