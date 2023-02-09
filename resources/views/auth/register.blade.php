@extends('admin.layouts.blank')

@section('title', 'Register')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
	@include('admin.layouts.alert')

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register Card -->
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
            <h4 class="mb-2">Welcome to {{ config('app.name') }}</h4>
            <p class="mb-4">Please sign-in to your account and start the adventure</p>

            <form class="mb-3" action="{{ route('register') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                  value="{{ '' }}" autofocus required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ '' }}"
                  placeholder="Email" required />
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder="Password"
                    aria-describedby="password" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>

              <button class="btn btn-primary d-grid w-100" type="submit">Sign up</button>
            </form>

            <p class="text-center">
              <span>Already have an account?</span>
              <a href="{{ route('login') }}">
                <span>Sign in instead</span>
              </a>
            </p>
          </div>
        </div>
        <!-- Register Card -->
      </div>
    </div>
  </div>
@endsection
