<?php

declare(strict_types=1);

use Polopolaw\FKWallet\ValueObjects\Amount;
use Polopolaw\FKWallet\ValueObjects\CurrencyId;
use Polopolaw\FKWallet\ValueObjects\PaymentSystemId;
use Polopolaw\FKWallet\ValueObjects\PublicKey;
use Polopolaw\FKWallet\ValueObjects\PrivateKey;
use Polopolaw\FKWallet\ValueObjects\Balance;
use Polopolaw\FKWallet\Exceptions\InvalidPublicKeyException;
use Polopolaw\FKWallet\Exceptions\InvalidSignatureException;

test('amount must be greater than zero', function () {
    expect(fn() => new Amount(-100))
        ->toThrow(InvalidArgumentException::class);
    
    expect(fn() => new Amount(0))
        ->toThrow(InvalidArgumentException::class);
});

test('amount can be created with positive value', function () {
    $amount = new Amount(100.5);
    expect($amount->getValue())->toBe(100.5);
    expect((string) $amount)->toBe('100.5');
});

test('currency id must be greater than zero', function () {
    expect(fn() => new CurrencyId(-1))
        ->toThrow(InvalidArgumentException::class);
    
    expect(fn() => new CurrencyId(0))
        ->toThrow(InvalidArgumentException::class);
});

test('currency id can be created with positive value', function () {
    $currencyId = new CurrencyId(1);
    expect($currencyId->getValue())->toBe(1);
});

test('payment system id must be greater than zero', function () {
    expect(fn() => new PaymentSystemId(-1))
        ->toThrow(InvalidArgumentException::class);
});

test('public key cannot be empty', function () {
    expect(fn() => new PublicKey(''))
        ->toThrow(InvalidPublicKeyException::class);
});

test('public key can be created with valid value', function () {
    $publicKey = new PublicKey('test_key');
    expect($publicKey->getValue())->toBe('test_key');
    expect((string) $publicKey)->toBe('test_key');
});

test('private key cannot be empty', function () {
    expect(fn() => new PrivateKey(''))
        ->toThrow(InvalidSignatureException::class);
});

test('private key can be created with valid value', function () {
    $privateKey = new PrivateKey('test_key');
    expect($privateKey->getValue())->toBe('test_key');
});

test('balance can be created and converted to array', function () {
    $balance = new Balance('USD', 100.5);
    expect($balance->getCurrencyCode())->toBe('USD');
    expect($balance->getValue())->toBe(100.5);
    expect($balance->toArray())->toBe([
        'currency_code' => 'USD',
        'value' => 100.5,
    ]);
});

