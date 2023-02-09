@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Email Sent') }}</div>

          <div class="card-body">
            {{ __('An Email has been sent.') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
