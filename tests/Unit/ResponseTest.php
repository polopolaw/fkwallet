<?php

declare(strict_types=1);

use Polopolaw\FKWallet\Http\Response;

test('response can be created with status code and body', function () {
    $response = new Response(200, ['status' => 'ok', 'data' => []]);
    
    expect($response->getStatusCode())->toBe(200);
    expect($response->getBody())->toBe(['status' => 'ok', 'data' => []]);
});

test('response can include headers', function () {
    $headers = ['Content-Type' => 'application/json', 'X-Custom' => 'value'];
    $response = new Response(200, ['status' => 'ok'], $headers);
    
    expect($response->getHeaders())->toBe($headers);
});

test('response isSuccessful returns true for 2xx status codes', function () {
    expect((new Response(200, []))->isSuccessful())->toBeTrue();
    expect((new Response(201, []))->isSuccessful())->toBeTrue();
    expect((new Response(299, []))->isSuccessful())->toBeTrue();
});

test('response isSuccessful returns false for non-2xx status codes', function () {
    expect((new Response(199, []))->isSuccessful())->toBeFalse();
    expect((new Response(300, []))->isSuccessful())->toBeFalse();
    expect((new Response(400, []))->isSuccessful())->toBeFalse();
    expect((new Response(500, []))->isSuccessful())->toBeFalse();
});

test('response getData extracts data from body', function () {
    $response = new Response(200, [
        'status' => 'ok',
        'data' => ['key' => 'value'],
    ]);
    
    expect($response->getData())->toBe(['key' => 'value']);
});

test('response getData returns empty array when data key is missing', function () {
    $response = new Response(200, ['status' => 'ok']);
    
    expect($response->getData())->toBe([]);
});

