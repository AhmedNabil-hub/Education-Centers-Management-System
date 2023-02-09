@extends('admin.layouts.blank')

@section('title', 'Reset Password')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
  @include('admin.layouts.alert')

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Reset Password -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">

                </span>
                <span class="app-brand-text demo text-body fw-bolder">
                  {{ ucfirst(config('app.name')) }}
                </span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Reset Password 🔒</h4>
            <p class="mb-4">Enter your email and new password</p>
            <form class="mb-3" action="{{ route('password.update') }}" method="POST">
              @csrf

              <input type="hidden" name="token" value="{{ $token }}">

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                  value="{{ $email ?? old('email') }}" autofocus />
              </div>

              <div class="mb-3 form-password-toggle">
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-merge">
                  <input type="text" class="form-control" id="password" name="password" placeholder="Password"
                    value="{{ '' }}" autofocus />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>

              <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
            </form>
          </div>
        </div>
        <!-- /Reset Password -->
      </div>
    </div>
  </div>
@endsection
