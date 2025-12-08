<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Http;

interface ClientInterface
{
    public function get(string $url, array $headers = [], ?string $proxy = null): Response;

    public function post(string $url, array $data = [], array $headers = [], ?string $proxy = null): Response;

    public function setProxy(?string $proxy): void;

    public function getProxy(): ?string;
}

