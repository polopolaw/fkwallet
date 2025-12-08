<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Polopolaw\FKWallet\Auth\SignatureGenerator;
use Polopolaw\FKWallet\Auth\SignatureGeneratorInterface;
use Polopolaw\FKWallet\Contracts\FKWalletServiceInterface;
use Polopolaw\FKWallet\Http\ClientInterface;
use Polopolaw\FKWallet\Http\GuzzleClient;
use Polopolaw\FKWallet\Services\FKWalletService;

class FKWalletServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fkwallet.php', 'fkwallet');

        $this->app->singleton(SignatureGeneratorInterface::class, function (): SignatureGeneratorInterface {
            return new SignatureGenerator(
                config('fkwallet.public_key'),
                config('fkwallet.private_key')
            );
        });

        $this->app->singleton(ClientInterface::class, function ($app): ClientInterface {
            $guzzleClient = new \GuzzleHttp\Client([
                'base_uri' => config('fkwallet.api_url'),
            ]);

            return new GuzzleClient(
                $guzzleClient,
                (int) config('fkwallet.timeout', 30),
                (int) config('fkwallet.retry_attempts', 3)
            );
        });

        $this->app->singleton(FKWalletServiceInterface::class, function ($app): FKWalletServiceInterface {
            return new FKWalletService(
                $app->make(ClientInterface::class),
                config('fkwallet.api_url'),
                config('fkwallet.public_key'),
                config('fkwallet.private_key')
            );
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole() === false) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/fkwallet.php' => config_path('fkwallet.php'),
        ], 'config');
    }

    /**
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            SignatureGeneratorInterface::class,
            ClientInterface::class,
            FKWalletServiceInterface::class,
        ];
    }
}


