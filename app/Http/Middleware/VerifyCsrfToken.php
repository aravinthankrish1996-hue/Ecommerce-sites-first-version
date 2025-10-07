<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * These routes are for external services (like payment gateways)
     * that post back to our application and don't have a CSRF token.
     *
     * @var array<int, string>
     */
    protected $except = [
        'pay-u-response',
        'pay-u-cancel'
    ];
}
