<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class CheckLocal
{
    /**
     * @param  Request  $request
     * @param  Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('Accept-Language');

        if (isset($lang) && $lang !== App::currentLocale()) {
            App::setLocale($lang);
        }

        return $next($request);
    }
}
