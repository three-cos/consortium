<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequireApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return new Response([
                'error' => 'Token required',
            ], 401);
        }

        if ($this->token_is_valid()) {
            return $next($request);
        }

        return new Response([
            'Token is invalid',
        ], 401);
    }

    /**
     * Проверка токена
     *
     * @return bool
     */
    public function token_is_valid(): bool
    {
        return true;
    }
}
