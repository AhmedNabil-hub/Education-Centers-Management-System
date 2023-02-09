<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
	public function notice()
	{
		if (session('errors') || session('messages')) {
			return view('auth.verify')
				->with('errors', session('errors', null))
				->with('messages', session('messages', null));
		}

		return view('auth.verify');
	}

	public function verify(EmailVerificationRequest $request)
	{
		$request->fulfill();

		return redirect()->route('home');
	}

	public function send(Request $request)
	{
		$request->user()->sendEmailVerificationNotification();

		return back()->with('messages', ['Verification link sent!']);
	}
}
