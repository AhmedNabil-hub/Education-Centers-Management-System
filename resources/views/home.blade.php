@extends('admin.layouts.main')

@section('title', 'Home')

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
@endsection


@section('content')
  @include('admin.layouts.alert')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            {{ __('You are logged in!') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
