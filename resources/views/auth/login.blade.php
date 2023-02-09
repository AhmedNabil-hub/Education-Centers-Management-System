@extends('admin.layouts.blank')

@section('title', 'Login')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
  @include('admin.layouts.alert')

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{ route('home') }}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">

                </span>
                <span class="app-brand-text demo text-body fw-bolder">
                  {{ ucfirst(config('app.name') ?? '') }}
                </span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Welcome to {{ ucfirst(config('app.name') ?? '') }}! 👋</h4>
            <p class="mb-4">Please sign-in to your account and start the adventure</p>

            <form class="mb-3" action="{{ route('login') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                  value="{{ '' }}" required autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                      <small>Forgot Password?</small>
                    </a>
                  @endif
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="Password"
                    aria-describedby="password" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" name="remember"
                    {{ old('remember') ? 'checked' : '' }} />
                  <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
              </div>

              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>

            <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{ route('register') }}">
                <span>Create an account</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
@endsection
