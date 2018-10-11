<?php

namespace App\Http\Middleware;

use Closure;
use App\Menu;

class MenuMiddleware
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
        if(!$request->session()->has('menu')) {
            $menu   = Menu::getAdminMenu();
            $request->session()->put('menu', $menu);
        }

        return $next($request);
    }
}
