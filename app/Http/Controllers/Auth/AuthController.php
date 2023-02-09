<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRegisterSecondRequest;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{
  public function showRegistrationForm()
  {
    if (!session()->has('url.intended')) {
      session(['url.intended' => url()->previous()]);
    }

    if (session('errors') || session('messages')) {
      return view('auth.register')
        ->with('errors', session('errors', null))
        ->with('messages', session('messages', null));
    }

    return view('auth.register');
  }

  public function register(UserRegisterRequest $request)
  {
    try {
      $validator = Validator::make(
        $request->all(),
        $request->rules(),
        $request->messages(),
        $request->attributes()
      );

      if ($validator->fails()) {
        return redirect()->back()
          ->with('errors', $validator->getMessageBag()->all());
      }

      $data = $validator->validated();

      $data['password'] = Hash::make($data['password']);

      $user = User::create($data);

      auth()->login($user);

      $user->assignRole('main');

      defaultUserProfileMediafileCreate($user->id);

      event(new Registered($user));

      return redirect()->intended(back());
    } catch (\Exception $e) {
      dd($e->getMessage());
      return abort(Response::HTTP_NOT_FOUND);
    }
  }

  public function showRegistrationSecondForm()
  {
    if (!session()->has('url.intended')) {
      session(['url.intended' => url()->previous()]);
    }

    if (session('errors') || session('messages')) {
      return view('auth.register-second')
        ->with('errors', session('errors', null))
        ->with('messages', session('messages', null));
    }

    return view('auth.register-second');
  }

  public function registerSecond(UserRegisterSecondRequest $request)
  {
    try {
      $validator = Validator::make(
        $request->all(),
        $request->rules(),
        $request->messages(),
        $request->attributes()
      );

      if ($validator->fails()) {
        return redirect()->back()
          ->with('errors', $validator->getMessageBag()->all());
      }

      $data = $validator->validated();

      $data['first_time_login'] = 0;

      auth()->user()->update($data);

      return redirect()->intended(back());
    } catch (\Exception $e) {
      dd($e->getMessage());
      return abort(Response::HTTP_NOT_FOUND);
    }
  }

  public function showLoginForm()
  {
    if (!session()->has('url.intended')) {
      session(['url.intended' => url()->previous()]);
    }

    if (session('errors') || session('messages')) {
      return view('auth.login')
        ->with('errors', session('errors', null))
        ->with('messages', session('messages', null));
    }

    return view('auth.login');
  }

  public function login(UserLoginRequest $request)
  {
    try {
      $validator = Validator::make(
        $request->all(),
        $request->rules(),
        $request->messages(),
        $request->attributes()
      );

      if ($validator->fails()) {
        return redirect()->back()
          ->with('errors', $validator->getMessageBag()->all());
      }

      $validated_data = $validator->validated();

      $user = User::query()
        ->where([
          ['email', $validated_data['email']],
        ])
        ?->first();

      if (!$user || !Hash::check($request['password'], $user->password)) {
        $errors = ['Your cridentials are not correct'];

        return redirect()->back()
          ->with('errors', $errors);
      }

      $remember = $request->has('remember') ? true : false;
      auth()->login($user, $remember);
      $request->session()->regenerate();

      return redirect()->intended(back());
    } catch (\Exception $e) {
      dd($e->getMessage());
      return abort(Response::HTTP_NOT_FOUND);
    }
  }

  public function logout()
  {
    try {
      auth()->logout();
      request()->session()->invalidate();
      request()->session()->regenerateToken();

      return redirect()->route('login');
    } catch (\Exception $e) {
      dd($e->getMessage());
      return abort(Response::HTTP_NOT_FOUND);
    }
  }

  public function forgotPasswordByEmail(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'email' => 'required',
      ],
      [
        'required'   => ':attribute is required',
        'exists'     => 'This :attribute does not exists',
        'email'      => ':attribute is not valid email',
      ],
      [
        'email' => 'Email',
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()
        ->with('errors', $validator->getMessageBag()->all());
    }

    $status = Password::sendResetLink(
      $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
      ? back()->with('messages', [__($status)])
      : back()->with('errors', [__($status)]);
  }

  public function resetPasswordByEmail(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'token' => 'required',
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6',
      ],
      [
        'required'   => ':attribute is required',
        'exists'     => 'This :attribute does not exists',
        'email'      => ':attribute is not valid email',
        'min'        => ':attribute must be more then :min',
      ],
      [
        'email' => 'Email',
        'password' => 'Password',
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()
        ->with('errors', $validator->getMessageBag()->all());
    }

    $status = Password::reset(
      $request->only('email', 'password', 'token'),
      function ($user, $password) {
        $user->forceFill([
          'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
      }
    );

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('login')->with('messages', [__($status)])
      : back()->with('errors', [__($status)]);
  }

  private function sendResetEmail($email, $token)
  {
    $user = User::where([
      ['email', $email],
    ])->first();

    $url = config('app.url') . "/reset-password/email?token={$token}";

    try {
      $user->notify(new ResetPasswordNotification($url));

      return true;
    } catch (\Exception $e) {
      return false;
    }
  }
}
