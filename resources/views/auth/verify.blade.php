@extends('admin.layouts.blank')

@section('title', 'Info')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
@endsection

@section('content')
  @include('admin.layouts.alert')

  <!-- Error -->
  <div class="container-xxl container-p-y">
    <div class="misc-wrapper">
      <h2 class="mb-2 mx-2">Verify Your Email Address</h2>
      <p class="mb-4 mx-2">Before proceeding, please check your email for a verification link.</p>
      <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-info align-baseline">{{ __('click here to request another') }}</button>
      </form>
      {{-- <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a> --}}
      <div class="mt-3">
        <img src="{{ asset('assets/img/message.svg') }}" alt="page-misc-error-light" width="500" class="img-fluid">
      </div>
    </div>
  </div>
  <!-- /Error -->
@endsection
