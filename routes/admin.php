<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\EmailVerificationController;

/************
	Auth
 ************/
Route::group(
	['middleware' => ['guest']],
	function () {
		Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
		Route::post('/login', [AuthController::class, 'login']);
		Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
		Route::post('/register', [AuthController::class, 'register']);
	}
);

Route::group(
	['middleware' => ['auth', 'verified']],
	function () {
		Route::get('/register-second', [AuthController::class, 'showRegistrationSecondForm'])->name('register-second');
		Route::post('/register-second', [AuthController::class, 'registerSecond']);
	}
);

/************
	Email Verification
 ************/
Route::group(
	['prefix' => 'email'],
	function () {
		Route::get('/verify', [EmailVerificationController::class, 'notice'])
			->name('verification.notice');

		Route::get('/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
			->middleware(['signed'])
			->name('verification.verify');

		Route::post('/verification-notification', [EmailVerificationController::class, 'send'])
			->middleware(['auth', 'throttle:6,1'])
			->name('verification.resend');
	}
);

/************
	Logout
 ************/
Route::group(['middleware' => ['auth']], function () {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/************
	Reset Passwords
 ************/
Route::get('/forgot-password/email', function () {
	return view('auth.passwords.email');
})
	->middleware('guest')
	->name('password.request');

Route::post('/forgot-password/email', [AuthController::class, 'forgotPasswordByEmail'])
	->middleware('guest')
	->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
	return view('auth.passwords.reset', ['token' => $token]);
})
	->middleware('guest')
	->name('password.reset');

Route::post('/reset-password/email', [AuthController::class, 'resetPasswordByEmail'])
	->middleware('guest')
	->name('password.update');

Route::group(
	[
		'middleware' => ['auth', 'verified', 'register.second', 'role:admin'],
	],
	function () {
		Route::get('/', [DashboardController::class, 'index'])
			->name('dashboard');
		Route::get('/profile', [UserController::class, 'showProfile'])
			->name('users.profile');

		Route::resource('users', UserController::class);
	}
);
