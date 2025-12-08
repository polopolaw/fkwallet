<?php

declare(strict_types=1);

use Polopolaw\FKWallet\Auth\SignatureGenerator;

test('signature generator creates signature for GET request', function () {
    $generator = new SignatureGenerator('public_key', 'private_key');
    $signature = $generator->forGet();
    
    expect($signature)->toBeString();
    expect(strlen($signature))->toBe(64);
    expect($signature)->toBe(hash('sha256', 'private_key'));
});

test('signature generator creates signature for POST request', function () {
    $generator = new SignatureGenerator('public_key', 'private_key');
    $payload = ['amount' => 100, 'currency_id' => 1];
    $signature = $generator->forPost($payload);
    
    $expectedBody = json_encode($payload, JSON_THROW_ON_ERROR);
    $expectedSignature = hash('sha256', $expectedBody . 'private_key');
    
    expect($signature)->toBe($expectedSignature);
    expect(strlen($signature))->toBe(64);
});

test('signature generator returns public key', function () {
    $generator = new SignatureGenerator('test_public_key', 'private_key');
    expect($generator->publicKey())->toBe('test_public_key');
});

