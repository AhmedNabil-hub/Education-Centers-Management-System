@extends('admin.layouts.main')

@section('title', 'Info')

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
@endsection


@section('content')
  @include('admin.layouts.alert')

  <!-- Error -->
  <div class="container-xxl container-p-y">
    <div class="misc-wrapper">
      <h2 class="mb-2 mx-2">{{ 'Something went wrong!' }}</h2>
      <p class="mb-4 mx-2">{{ $errors[0] }}</p>
      {{-- <a href="{{url('/')}}" class="btn btn-primary">Back to home</a> --}}
      <div class="mt-3">
        <img src="{{ asset('assets/img/message.svg') }}" alt="page-misc-error-light" width="500" class="img-fluid">
      </div>
    </div>
  </div>
  <!-- /Error -->
@endsection
