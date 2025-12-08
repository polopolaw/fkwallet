<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Polopolaw\FKWallet\FKWalletServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            FKWalletServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('fkwallet.api_url', 'https://api.fkwallet.io/v1/');
        $app['config']->set('fkwallet.public_key', 'test_public_key');
        $app['config']->set('fkwallet.private_key', 'test_private_key');
        $app['config']->set('fkwallet.timeout', 30);
        $app['config']->set('fkwallet.retry_attempts', 3);
    }
}

