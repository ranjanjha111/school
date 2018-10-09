<?php

namespace App\Http\Middleware;

use Closure;
use App\Language;
use Illuminate\Support\Facades\Lang;

class SetAllLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!$request->session()->has('languages')) {
            $languages  = Language::getAllActiveLanguage();
            $request->session()->put('languages', $languages);
        }

        return $next($request);
    }
}
