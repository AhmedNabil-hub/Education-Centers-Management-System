@extends('admin.layouts.main')

@section('title', 'Users')

@section('page-script')
@endsection

@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-muted fw-light">Users /</a> Show
  </h4>

  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">User</h5>
    </div>
    <div class="card-body">
      <form>
        <div class="mb-3">
          <label class="form-label" for="product-id">Id</label>
          <div class="input-group input-group-merge">
            <span id="id2" class="input-group-text"><i class='bx bx-hash'></i></span>
            <span class="form-control" id="id" aria-describedby="id2">
              {{ $user->id ?? '' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="username">Username</label>
          <div class="input-group input-group-merge">
            <span id="username2" class="input-group-text"><i class='bx bx-user'></i></span>
            <span class="form-control" id="username" aria-describedby="username2">
              {{ $user->username ?? '' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="full-name">Full Name</label>
          <div class="input-group input-group-merge">
            <span id="full-name2" class="input-group-text"><i class='bx bx-user'></i></span>
            <span class="form-control" id="full-name" aria-describedby="full-name2">
              {{ $user->full_name ?? '' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="status">Status</label>
          <div class="input-group input-group-merge">
            <span id="status2" class="input-group-text"><i class='bx bx-cog'></i></span>
            <span class="form-control" id="status" aria-describedby="status2">
              {{ ucfirst($user->status ?? '') }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="roles">Roles</label>
          <div class="input-group input-group-merge">
            <span id="roles2" class="input-group-text"><i class='bx bx-cog'></i></span>
            <span class="form-control" id="roles" aria-describedby="roles2">
              @foreach ($user->roles as $role)
                <span class="badge bg-label-info">
                  {{ ucfirst($role) }}
                </span>
              @endforeach
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="gender">Gender</label>
          <div class="input-group input-group-merge">
            <span id="gender2" class="input-group-text"><i class='bx bx-{{ $user->gender ?? 'male' }}'></i></span>
            <span class="form-control" id="gender" aria-describedby="gender2">
              {{ ucfirst($user->gender ?? '') }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="email">Email</label>
          <div class="input-group input-group-merge">
            <span id="email2" class="input-group-text"><i class='bx bx-envelope'></i></span>
            <span class="form-control" id="email" aria-describedby="email2">
              {{ $user->email ?? '' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="phone">Phone</label>
          <div class="input-group input-group-merge">
            <span id="phone2" class="input-group-text"><i class='bx bx-phone'></i></span>
            <span class="form-control" id="phone" aria-describedby="phone2">
              {{ $user->phone ?? '' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="address">Address</label>
          <div class="input-group input-group-merge">
            <span id="address2" class="input-group-text"><i class='bx bx-current-location'></i></span>
            <span class="form-control" id="address" aria-describedby="address2">
              {{ $user->address ?? '' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="first-time-login">First Time Login</label>
          <div class="input-group input-group-merge">
            <span id="first-time-login2" class="input-group-text"><i class='bx bx-question-mark'></i></span>
            <span class="form-control" id="first-time-login" aria-describedby="first-time-login2">
              {{ ucfirst($user->first_time_login ?? '') }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="created-at">Created At</label>
          <div class="input-group input-group-merge">
            <span id="created-at2" class="input-group-text"><i class='bx bxs-calendar-plus'></i></span>
            <span class="form-control" id="created-at" aria-describedby="created-at2">
              {{ $user->created_at ?? '' }}
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="updated-at">Updated At</label>
          <div class="input-group input-group-merge">
            <span id="updated-at2" class="input-group-text"><i class='bx bxs-calendar-edit'></i></span>
            <span class="form-control" id="updated-at" aria-describedby="updated-at2">
              {{ $user->updated_at ?? '' }}
            </span>
          </div>
        </div>

        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-success">Edit</a>
      </form>
    </div>
  </div>
@endsection
