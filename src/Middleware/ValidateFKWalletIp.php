<?php

declare(strict_types=1);

namespace Polopolaw\FKWallet\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateFKWalletIp
{
    private const ALLOWED_IPS = [
        '168.119.157.136',
        '168.119.60.227',
        '178.154.197.79',
        '51.250.54.238',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();

        if (!in_array($clientIp, self::ALLOWED_IPS, true)) {
            abort(403, 'Access denied. IP address not allowed.');
        }

        return $next($request);
    }
}

