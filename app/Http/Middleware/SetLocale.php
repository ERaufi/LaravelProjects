<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // If the user is logged in, set the locale from the user's table
            App::setLocale(Auth::user()->lang);
        } elseif ($request->session()->has('lang')) {
            // If the language is set in the session, use it
            App::setLocale($request->session()->get('lang'));
        }

        return $next($request);
    }
}
