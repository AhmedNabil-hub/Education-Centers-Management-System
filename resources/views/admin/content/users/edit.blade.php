@extends('admin.layouts.main')

@section('title', 'Users')

@section('page-script')
  <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
  <script>
    function togglePassword() {
      let passwordIcon = $(this);
      let passwordInput = $(`input[id='password']`);

      passwordIcon.toggleClass('bx-show bx-hide');
			passwordInput.attr('type', (_, attr) => attr == 'text' ? 'password' : 'text');
    }

    $(document).ready(function() {
      $(document).on('click', `#password-icon`, togglePassword);
    });
  </script>
@endsection

@section('content')
  @include('admin.layouts.alert')

  <h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-muted fw-light">Users /</a> Edit
  </h4>

  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">User</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
				@method('PUT')

        <div class="mb-3">
          <label class="form-label" for="username">Username</label>
          <div class="input-group input-group-merge">
            <span id="username2" class="input-group-text"><i class="bx bx-user"></i></span>
            <input type="text" name="username" class="form-control" id="username" aria-describedby="username2"
              value="{{ $user->username ?? '' }}" placeholder="Username" aria-label="Username" autocomplete="off" autofill="off" />
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="full-name">Full Name</label>
          <div class="input-group input-group-merge">
            <span id="full-name2" class="input-group-text"><i class="bx bx-user"></i></span>
            <input type="text" name="full_name" class="form-control" id="full-name" aria-describedby="full-name2"
              value="{{ $user->full_name ?? '' }}" placeholder="Full Name" aria-label="Full Name" />
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="email">Email</label>
          <div class="input-group input-group-merge">
            <span id="email2" class="input-group-text"><i class="bx bx-envelope"></i></span>
            <input type="text" name="email" class="form-control" id="email" aria-describedby="email2"
              value="{{ $user->email ?? '' }}" placeholder="Email" aria-label="Email" autofill="off" />
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="phone">Phone</label>
          <div class="input-group input-group-merge">
            <span id="phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
            <input type="text" name="phone" class="form-control" id="phone" aria-describedby="phone2" pattern="^01[0125][0-9]{8}$"
              value="{{ $user->phone ?? '' }}" placeholder="Phone" aria-label="Phone" autofill="off" />
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="address">Address</label>
          <div class="input-group input-group-merge">
            <span id="address2" class="input-group-text"><i class="bx bx-current-location"></i></span>
            <input type="text" name="address" class="form-control" id="address" aria-describedby="address2"
              value="{{ $user->address ?? '' }}" placeholder="Address" aria-label="Address" />
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="status">Status</label>
          <div class="input-group input-group-merge">
            <span class="input-group-text"><i class='bx bx-cog'></i></span>
            <select id="status" class="form-select" name="status">
              <option value="">Select status</option>
              @foreach (\App\Models\User::STATUS as $key => $value)
                <option @selected($value == $user->status) value="{{ $key }}">{{ ucfirst($value) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="status">Gender</label>
          <div class="input-group input-group-merge">
            <span id="gender2" class="input-group-text"><i class="bx bx-male"></i></span>
            <select class="form-select" name="gender">
              <option value="">Select gender</option>
              @foreach (\App\Models\User::GENDER as $key => $value)
                <option @selected($value == $user->gender) value="{{ $key }}">{{ ucfirst($value) }}</option>
              @endforeach
            </select>
          </div>
        </div>
				<div class="mb-3">
          <label class="form-label" for="roles">User Role</label>
          <div class="input-group input-group-merge">
            @foreach (App\Models\User::ROLES as $key => $role)
                <div class="form-check form-check-inline mt-1">
                  <input class="form-check-input" type="checkbox" id="roles" name="roles[{{ $key }}]" value="{{ $key }}" @checked(in_array($role, $user->roles)) />
                  <label class="form-check-label" for="roles">
                    {{ ucfirst($role ?? '') }}
                  </label>
                </div>
              @endforeach
          </div>
        </div>

        <button type="submit" class="btn btn-success">Edit</button>
      </form>
    </div>
  </div>
@endsection
