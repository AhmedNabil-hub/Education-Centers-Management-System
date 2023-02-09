<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class EnsureUserIsVerified
{
	public function handle($request, Closure $next, $redirectToRoute = null)
	{
		if (!$request->user()) {
			return $request->expectsJson()
				? abort(403, 'You are not authenticated')
				: Redirect::guest(URL::route($redirectToRoute ?: 'login'));
		}

		if (!$request->user()->hasVerifiedEmail()) {
			return $request->expectsJson()
				? abort(403, 'Your email address is not verified.')
				: Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
		}

		return $next($request);
	}
}
