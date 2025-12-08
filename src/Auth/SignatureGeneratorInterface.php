<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Auth;

interface SignatureGeneratorInterface
{
    public function forGet(): string;

    /**
     * @param array<string, mixed> $payload
     */
    public function forPost(array $payload): string;
}


