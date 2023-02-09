@extends('admin.layouts.main')

@section('title', 'Users')

@section('css')
@endsection

@section('page-script')
  <script>
    function tableActionDelete() {
      var user_id = $(this).data("id");
      var row = $(`tr[data-id=${user_id}]`);

      let url = "{{ route('admin.users.destroy', ':user') }}";
      url = url.replace(':user', user_id);

      $.ajax({
        url: url,
        type: "DELETE",
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(data) {
          row.fadeOut('slow', function() {
            row.remove();
          });

          data.messages.forEach(message => {
            $('#alert').append(`
							<div class="alert fade show bs-toast toast bg-info alert-dismissible" role="alert">
								${message}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
								</button>
							</div>
						`);
          });
        },
        error: function(data) {
          data.errors.forEach(error => {
            $('#alert').append(`
							<div class="alert fade show bs-toast toast bg-danger alert-dismissible" role="alert">
								${error}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
								</button>
							</div>
						`);
          });
        }
      });
    }

    $(document).ready(function() {
      $(document).on('click', `[data-action='delete']`, tableActionDelete);
    });
  </script>

  <script>
    function tableUpdateStatus() {
      var user = $(this);
      var user_id = $(this).data("id");
      var status = user.data("status");

      if (status == 'active') {
        var new_status = 1;
      } else if (status == 'inactive') {
        var new_status = 2;
      }

      if (new_status != null) {
        let url = "{{ route('admin.users.update', ':user') }}";
        url = url.replace(':user', user_id);

        $.ajax({
          url: url,
          type: "POST",
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: {
            "_method": "PUT",
            "status": new_status,
          },
          success: function(data) {
            if (user.data("status") == 'active') {
              user.html(`
								<span class="badge bg-label-danger me-1">
									Inactive
								</span>
							`);

              user.data("status", "inactive");
            } else if (user.data("status") == 'inactive') {
              user.html(`
								<span class="badge bg-label-primary me-1">
									Active
								</span>
							`);

              user.data("status", "active");
            }
          },
          error: function(data) {
            data.errors.forEach(error => {
              $('#alert').append(`
								<div class="alert fade show bs-toast toast bg-danger alert-dismissible" role="alert">
									${error}
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
									</button>
								</div>
							`);
            });
          }
        });
      }
    }

    $(document).ready(function() {
      $(document).on('click', `[data-status]`, tableUpdateStatus);
    });
  </script>

  <script>
    $('.table-responsive').on('show.bs.dropdown', function() {
      $('.table-responsive').css("overflow", "inherit");
    });

    $('.table-responsive').on('hide.bs.dropdown', function() {
      $('.table-responsive').css("overflow", "auto");
    })
  </script>
@endsection

@section('content')
  @include('admin.layouts.alert')

  <h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-muted fw-light">Users /</a> Index
  </h4>

  <!-- Hoverable Table rows -->
  <div class="card">
    <div class="card-header d-flex align-items-center">
      <span class="me-auto h5 mb-0">Users</span>
      <div class="d-flex align-items-center justify-end">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
          data-bs-target="#filter-sort-modal">
          Filter & Sort
        </button>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm px-1 py-1">
          <i class='bx bx-plus'></i>
        </a>
      </div>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Roles</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($users->data as $user)
            <tr data-id="{{ $user->id }}">
              <td>
                <span class="fw-bold">{{ $user->id }}</span>
              </td>
              <td>{{ $user->username }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->phone }}</td>
              <td data-status="{{ $user->status }}" data-id="{{ $user->id }}" class="cursor-pointer">
                @if ($user->status == 'active')
                  <span class="badge bg-label-primary me-1">
                  @elseif ($user->status == 'inactive')
                    <span class="badge bg-label-danger me-1">
                    @else
                      <span class="badge bg-label-primary me-1">
                @endif
                {{ ucfirst($user->status) }}
                </span>
              </td>
              <td>
                @foreach ($user->roles as $role)
                  <span class="badge bg-label-info">
                    {{ ucfirst($role) }}
                  </span>
                @endforeach
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                      <i class="bx bx-show me-1"></i>
                      View
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">
                      <i class="bx bx-edit me-1"></i>
                      Edit
                    </a>
                    <a data-action="delete" data-id="{{ $user->id }}" class="dropdown-item"
                      href="javascript:void(0);">
                      <i class="bx bx-trash me-1"></i>
                      Delete
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if ($users->pagination != null)
      <div class="row d-flex align-items-center justify-space-between mx-2 mt-3">
        @include('admin.layouts.pagination', [
            'pagination' => $users->pagination,
        ])
      </div>
    @endif

  </div>
  <!--/ Hoverable Table rows -->

  <!-- Filter & Sort Modal -->
  <div class="modal fade" id="filter-sort-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('admin.users.index') }}" method="GET" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Filter & Sort</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <h6>Sort</h6>
            <div class="col mb-3">
              <label for="sort-field" class="form-label">Field</label>
              <select id="sort-field" class="form-select" name="sort_field">
                <option value="">Select field</option>
                @foreach (\App\Models\User::SORT_FIELDS as $key => $value)
                  <option @selected(old('sort_field')==$key) value="{{ $key }}">{{ ucfirst($value) }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col mb-3">
              <label for="sort-order" class="form-label">Order</label>
              <select id="sort-order" class="form-select" name="sort_order">
                <option value="">Select order</option>
                @foreach (\App\Models\User::SORT_ORDERS as $key => $value)
                  <option @selected(old('sort_order')==$key) value="{{ $key }}">{{ ucfirst($value) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <h6>Filter</h6>
            <div class="col-6 mb-3">
              <label for="filter-id" class="form-label">Id</label>
              <input type="text" id="filter-id" name="filter_id" class="form-control" placeholder="Id"
                value="{{ old('filter_id') ?? '' }}">
            </div>
            <div class="col-6 mb-3">
              <label for="filter-username" class="form-label">Username</label>
              <input type="text" id="filter-username" name="filter_username" class="form-control" placeholder="Username"
                value="{{ old('filter_username') ?? '' }}">
            </div>
            <div class="col-6 mb-3">
              <label for="filter-full-name" class="form-label">Full Name</label>
              <input type="text" id="filter-full-name" name="filter_full_name" class="form-control"
                placeholder="Full Name" value="{{ old('filter_full_name') ?? '' }}">
            </div>
            <div class="col-6 mb-3">
              <label for="filter-status" class="form-label">Status</label>
              <select id="filter-status" class="form-select" name="filter_status">
                <option value="">Select status</option>
                @foreach (\App\Models\User::STATUS as $key => $value)
                  <option @selected(old('filter_status')==$key) value="{{ $key }}">{{ ucfirst($value) }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-6 mb-3">
              <label for="filter-gender" class="form-label">Gender</label>
              <select id="filter-gender" class="form-select" name="filter_gender">
                <option value="">Select gender</option>
                @foreach (\App\Models\User::GENDER as $key => $value)
                  <option @selected(old('filter_gender')==$key) value="{{ $key }}">{{ ucfirst($value) }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-6 mb-3">
              <label for="filter-email" class="form-label">Email</label>
              <input type="email" id="filter-email" name="filter_email" class="form-control" placeholder="Email"
                value="{{ old('filter_email') ?? '' }}">
            </div>
            <div class="col-6 mb-3">
              <label for="filter-phone" class="form-label">Phone</label>
              <input type="text" id="filter-phone" name="filter_phone" class="form-control" placeholder="Phone"
                value="{{ old('filter_phone') ?? '' }}">
            </div>
            <div class="col-6 mb-3">
              <label for="filter-address" class="form-label">Adress</label>
              <input type="text" id="filter-address" name="filter_address" class="form-control" placeholder="Adress"
                value="{{ old('filter_address') ?? '' }}">
            </div>
						<div class="col-12 mb-3">
              <label for="filter-role" class="form-label d-block">Roles</label>
              @foreach (\App\Models\User::ROLES as $key => $role)
                <div class="form-check form-check-inline mt-1">
                  <input class="form-check-input" type="checkbox" id="filter-role" name="filter_role[{{ $key }}]" value="{{ $role }}" @checked(isset(old("filter_role")[$key]) && old("filter_role")[$key] == $role) />
                  <label class="form-check-label" for="filter-role">
                    {{ ucfirst($role) }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="filter-modal-submit">
            <i class="bx bx-check"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
  <!--/ Filter & Sort Modal -->
@endsection
