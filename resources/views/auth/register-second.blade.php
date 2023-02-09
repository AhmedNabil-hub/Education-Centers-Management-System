@extends('admin.layouts.blank')

@section('title', 'Regsiter Step-2')

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
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">

                </span>
                <span class="app-brand-text demo text-body fw-bolder">
                  {{ ucfirst(config('app.name')) }}
                </span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Adventure starts here 🚀</h4>
            <p class="mb-4">Make your app management easy and fun!</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('register-second') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="full-name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full-name" name="full_name"
                  placeholder="Enter your Full Name" value="{{ old('full_name') }}" autofocus required />
              </div>
              <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" class="js-select2 form-select" name="gender">
                  <option selected>Choose Your Gender</option>
                  @foreach (\App\Models\User::GENDER as $key => $gender)
                    <option @selected(old('gender') == $key) value="{{ $key }}">{{ ucfirst($gender) }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="phone-number" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone-number" name="phone"
                  placeholder="Enter your Phone Number" value="{{ old('phone') }}" pattern="^01[0125][0-9]{8}$" autofocus
                  required />
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your Address"
                  value="{{ old('address') }}" autofocus required />
              </div>

              <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
            </form>
          </div>
        </div>
        <!-- Register Card -->
      </div>
    </div>
  </div>
@endsection
