<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasCookie('lang')) {
            $lang = $request->cookie('lang');
            if (in_array($lang, config('app.allowed_locales'))) {
                App::setlocale($lang);
            }
        }
        return $next($request);
    }
}
