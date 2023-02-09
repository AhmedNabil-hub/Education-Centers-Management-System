@extends('admin.layouts.main')

@section('title', 'Profile')

@section('page-script')
  <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection

@section('content')
  @include('admin.layouts.alert')

  <h4 class="fw-bold py-3 mb-4">
    Profile
  </h4>

  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <h5 class="card-header">Profile Details</h5>
        <!-- Account -->
        {{-- <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ $user->profile_image }}" alt="user-avatar" class="d-block rounded" height="100" width="100"
              id="uploadedAvatar" />
            <div class="button-wrapper">
              <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                <span class="d-none d-sm-block">Upload new photo</span>
                <i class="bx bx-upload d-block d-sm-none"></i>
                <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
              </label>
              <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                <i class="bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Reset</span>
              </button>

              <p class="text-muted mb-0">Allowed JPG or PNG.</p>
            </div>
          </div>
        </div>
        <hr class="my-0"> --}}
        <div class="card-body">
          <form id="formAccountSettings" action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="username" class="form-label">Username</label>
                <input class="form-control" type="text" id="username" name="username"
                  value="{{ $user->username ?? '' }}" autofocus />
              </div>
              <div class="mb-3 col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input class="form-control" type="text" name="full_name" id="full_name"
                  value="{{ $user->full_name ?? '' }}" />
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ $user->email ?? '' }}"
                  placeholder="user@example.com" />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="phone">Phone</label>
                <div class="input-group input-group-merge">
                  <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone"
                    pattern="^01[0125][0-9]{8}$" value="{{ $user->phone ?? '' }}" />
                </div>
              </div>
              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address"
                  value="{{ $user->address ?? '' }}" />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="gender">Gender</label>
                <select id="gender" class="select2 form-select" name="gender">
                  <option value="">Select Gender</option>
                  @foreach (\App\Models\User::GENDER as $key => $value)
                    <option @selected($value==$user->gender) value="{{ $key }}">{{ ucfirst($value) }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Status</label>
                <input disabled class="form-control" value="{{ ucfirst($user->status ?? '') }}" />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Roles</label>
                <span class="form-control" id="roles">
                  @foreach ($user->roles as $role)
                    <span class="badge bg-label-info">
                      {{ ucfirst($role) }}
                    </span>
                  @endforeach
                </span>
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Save changes</button>
              <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div>
          </form>
        </div>
        <!-- /Account -->
      </div>
    </div>
  </div>
@endsection
