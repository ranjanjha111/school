<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = request()->route('locale');
        if (in_array($locale, config('translatable.locales')) === false) {
            return redirect('/');
        }
        app()->setLocale($locale);

        return $next($request);
    }
}
