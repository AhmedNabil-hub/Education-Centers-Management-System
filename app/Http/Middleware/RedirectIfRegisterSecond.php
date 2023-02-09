<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfRegisterSecond
{
	public function handle(Request $request, Closure $next)
	{
		if (auth()->user() && auth()->user()->first_time_login == 0) {
			// return redirect(RouteServiceProvider::HOME);
			return redirect()->intended(RouteServiceProvider::HOME);
		}

		return $next($request);
	}
}
