<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Main\HomeController;
use App\Http\Controllers\Main\UserController;
use App\Http\Controllers\Main\NotificationController;
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
  ['middleware' => ['auth', 'verified', 'not.register.second']],
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
  if (session('errors') || session('messages')) {
    return view('auth.passwords.email')
      ->with('errors', session('errors', null))
      ->with('messages', session('messages', null));
  }

  return view('auth.passwords.email');
})
  ->middleware('guest')
  ->name('password.request');

Route::post('/forgot-password/email', [AuthController::class, 'forgotPasswordByEmail'])
  ->middleware('guest')
  ->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
  if (session('errors') || session('messages')) {
    return view('auth.passwords.reset')
      ->with('token', $token)
      ->with('errors', session('errors', null))
      ->with('messages', session('messages', null));
  }

  return view('auth.passwords.reset')
    ->with('token', $token);
})
  ->middleware('guest')
  ->name('password.reset');

Route::post('/reset-password/email', [AuthController::class, 'resetPasswordByEmail'])
  ->middleware('guest')
  ->name('password.update');

/************
	Notifications
 ************/
Route::group(
  [
    'middleware' => ['auth', 'verified', 'register.second'],
    'prefix' => 'notifications',
    'controller' => NotificationController::class,
    'as' => 'notifications.'
  ],
  function () {
    Route::get('/', 'index')
      ->name('index');
    Route::post('/show', 'show')
      ->name('show');
    Route::post('/read', 'read')
      ->name('read');
    Route::post('/read-all', 'readAll')
      ->name('read-all');
    Route::delete('/destroy', 'destroy')
      ->name('destroy');
    Route::delete('/destroy-all', 'destroyAll')
      ->name('destroy-all');
  }
);

Route::redirect('/home', '/', 301);
Route::get('/', [HomeController::class, 'index'])
  ->name('home');
Route::get('/about', [HomeController::class, 'about'])
  ->name('about');
Route::get('/contact', [HomeController::class, 'contact'])
  ->name('contact');

Route::group(
  [
    'middleware' => ['auth', 'verified']
  ],
  function () {
    Route::get('/profile', [UserController::class, 'showProfile'])
      ->name('users.profile');
    Route::put('/users/{user}', [UserController::class, 'update'])
      ->name('users.update');
  }
);
