@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

  <script>
    $('.table-responsive').on('show.bs.dropdown', function() {
      $('.table-responsive').css("overflow", "inherit");
    });

    $('.table-responsive').on('hide.bs.dropdown', function() {
      $('.table-responsive').css("overflow", "auto");
    })
  </script>

  <script>
    // Users Chart - Area chart
    const usersChartMonths = @json(array_keys($users_area_chart_data));
    const usersChartDataPerMonth = @json(array_values($users_area_chart_data));

    const usersChartEl = document.querySelector('#usersChart');
    const usersChartConfig = {
      series: [{
        data: usersChartDataPerMonth
      }],
      chart: {
        height: 162,
        parentHeightOffset: 0,
        parentWidthOffset: 0,
        toolbar: {
          show: false
        },
        type: 'area'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      legend: {
        show: false
      },
      markers: {
        size: 6,
        colors: 'transparent',
        strokeColors: 'transparent',
        strokeWidth: 4,
        discrete: [{
          fillColor: '#ffffff',
          seriesIndex: 0,
          dataPointIndex: (new Date()).getMonth(),
          strokeColor: '#696cff',
          strokeWidth: 2,
          size: 6,
          radius: 8
        }],
        hover: {
          size: 7
        }
      },
      colors: ['#696cff'],
      fill: {
        type: 'gradient',
        gradient: {
          shade: '#eceef1',
          shadeIntensity: 0.6,
          opacityFrom: 0.5,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        borderColor: '#eceef1',
        strokeDashArray: 3,
        padding: {
          top: -20,
          bottom: -8,
          left: 8,
          right: 8
        }
      },
      xaxis: {
        categories: usersChartMonths,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          show: true,
          style: {
            fontSize: '13px',
            colors: '#a1acb8'
          }
        }
      },
      yaxis: {
        labels: {
          show: false
        },
        min: 0,
        // max: Math.max(usersChartDataPerMonth),
        tickAmount: 5
      }
    };

    if (typeof usersChartEl !== undefined && usersChartEl !== null) {
      const usersChart = new ApexCharts(usersChartEl, usersChartConfig);
      usersChart.render();
    }
  </script>

  <script>
    // Students Chart - Area chart
    const studentsChartMonths = @json(array_keys($students_area_chart_data));
    const studentsChartDataPerMonth = @json(array_values($students_area_chart_data));

    const studentsChartEl = document.querySelector('#studentsChart');
    const studentsChartConfig = {
      series: [{
        data: studentsChartDataPerMonth
      }],
      chart: {
        height: 162,
        parentHeightOffset: 0,
        parentWidthOffset: 0,
        toolbar: {
          show: false
        },
        type: 'area'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      legend: {
        show: false
      },
      markers: {
        size: 6,
        colors: 'transparent',
        strokeColors: 'transparent',
        strokeWidth: 4,
        discrete: [{
          fillColor: '#ffffff',
          seriesIndex: 0,
          dataPointIndex: (new Date()).getMonth(),
          strokeColor: '#696cff',
          strokeWidth: 2,
          size: 6,
          radius: 8
        }],
        hover: {
          size: 7
        }
      },
      colors: ['#696cff'],
      fill: {
        type: 'gradient',
        gradient: {
          shade: '#eceef1',
          shadeIntensity: 0.6,
          opacityFrom: 0.5,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        borderColor: '#eceef1',
        strokeDashArray: 3,
        padding: {
          top: -20,
          bottom: -8,
          left: 8,
          right: 8
        }
      },
      xaxis: {
        categories: studentsChartMonths,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          show: true,
          style: {
            fontSize: '13px',
            colors: '#a1acb8'
          }
        }
      },
      yaxis: {
        labels: {
          show: false
        },
        min: 0,
        // max: Math.max(studentsChartDataPerMonth),
        tickAmount: 5
      }
    };

    if (typeof studentsChartEl !== undefined && studentsChartEl !== null) {
      const studentsChart = new ApexCharts(studentsChartEl, studentsChartConfig);
      studentsChart.render();
    }
  </script>
@endsection

@section('content')
  @include('admin.layouts.alert')

  <div class="row">
    <div class="col-lg-8 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Welcome back {{ auth()->user()->username }}! 🎉</h5>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 order-1">
      <div class="row">
        @foreach ($totals_cards as $card_title => $card_data)
          @if ($loop->index > 1)
            @break
          @endif
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success"
                      class="rounded">
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">{{ ucfirst($card_title) }}</span>
                <h3 class="card-title mb-2">{{ $card_data }}</h3>
              </div>
            </div>
          </div>
        @endforeach
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-4 order-2 order-lg-3">
    <div class="row">
      @foreach ($totals_cards as $card_title => $card_data)
        @if ($loop->index <= 1)
          @continue
        @endif
        <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success"
                    class="rounded">
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">{{ ucfirst($card_title) }}</span>
              <h3 class="card-title mb-2">{{ $card_data }}</h3>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <!-- Expense Overview -->
  <div class="col-12 col-lg-8 order-3 order-lg-2 mb-4">
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-tabs-line-card-users" aria-controls="navs-tabs-line-card-users"
              aria-selected="true">Users</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-tabs-line-card-students" aria-controls="navs-tabs-line-card-students"
              aria-selected="true">Students</button>
          </li>
        </ul>
      </div>
      <div class="card-body px-0">
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-tabs-line-card-users" role="tabpanel">
            <div class="d-flex p-4 pt-3">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}" alt="User">
              </div>
              <div>
                <small class="text-muted d-block">Total Users</small>
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">{{ $totals_cards['users'] }}</h6>
                </div>
              </div>
            </div>
            <div id="usersChart"></div>
          </div>
          <div class="tab-pane fade" id="navs-tabs-line-card-students" role="tabpanel">
            <div class="d-flex p-4 pt-3">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}" alt="User">
              </div>
              <div>
                <small class="text-muted d-block">Total Students</small>
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">{{ $totals_cards['students'] }}</h6>
                </div>
              </div>
            </div>
            <div id="studentsChart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Expense Overview -->
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 mb-4">
    <div class="card">
      <h5 class="card-header">Recent Users</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-borderless">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Created</th>
              {{-- <th>Actions</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($recent_users as $user)
              <tr data-id="{{ $user->id }}">
                <td>
                  <span class="fw-bold">{{ $user->id }}</span>
                </td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->created_at->diffForHumans() }}</td>
                {{-- <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a data-action="accept" data-id="{{ $user->id }}" class="dropdown-item"
                          href="javascript:void(0);">
                          <i class="bx bx-check me-1"></i>
                          Accept
                        </a>
                        <a data-action="cancel" data-id="{{ $user->id }}" class="dropdown-item"
                          href="javascript:void(0);">
                          <i class="bx bx-trash me-1"></i>
                          Cancel
                        </a>
                      </div>
                    </div>
                  </td> --}}
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
