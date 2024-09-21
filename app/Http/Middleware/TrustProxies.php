<?php

namespace App\Http\Middleware;

use Fruitcake\Cors\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\SubstituteBindings;

class TrustProxies
{
    protected $proxies;
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    public function handle(Request $request, \Closure $next)
    {
        // Configuración de proxies
        return $next($request);
    }
}
