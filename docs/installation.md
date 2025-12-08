# Installation

## Requirements

- PHP 8.1 or higher
- Laravel 9.0+ | 10.0+ | 11.0+
- Composer

## Step 1: Install Package

```bash
composer require polopolaw/fkwallet
```

## Step 2: Publish Configuration

```bash
php artisan vendor:publish --provider="Polopolaw\FKWallet\FKWalletServiceProvider" --tag="config"
```

This will create `config/fkwallet.php` in your Laravel application.

## Step 3: Configure Environment

Add the following variables to your `.env` file:

```env
FKWALLET_API_URL=https://api.fkwallet.io/v1/
FKWALLET_PUBLIC_KEY=your_public_key_here
FKWALLET_PRIVATE_KEY=your_private_key_here
FKWALLET_TIMEOUT=30
FKWALLET_RETRY_ATTEMPTS=3
```

## Step 4: Verify Installation

The package is now ready to use. You can access it via:

- Facade: `Polopolaw\FKWallet\Facades\FKWallet`
- Service: `app(FKWalletServiceInterface::class)`

## Configuration Options

| Option | Description | Default |
|--------|-------------|---------|
| `api_url` | Base URL for FKWallet API | `https://api.fkwallet.io/v1/` |
| `public_key` | Your public API key | - |
| `private_key` | Your private API key | - |
| `timeout` | Request timeout in seconds | `30` |
| `retry_attempts` | Number of retry attempts | `3` |

## Next Steps

- Read [Configuration Guide](configuration.md) for advanced configuration
- Check [Quick Start](quickstart.md) for usage examples

