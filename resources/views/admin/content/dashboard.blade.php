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
    // Order Statistics Chart
    // --------------------------------------------------------------------
    var labels = @json(['name', 'test']);
    var series = @json(['name', 'test']);
    var total = series.reduce((partialSum, a) => partialSum + a, 0);

    const chartOrderStatistics = document.querySelector('#orderStatisticsChart'),
      orderChartConfig = {
        chart: {
          height: 165,
          width: 130,
          type: 'donut'
        },
        labels: labels,
        series: series,
        colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success, config.colors
          .danger
        ],
        stroke: {
          width: 5,
          colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success, config
            .colors.danger
          ]
        },
        dataLabels: {
          enabled: false,
          formatter: function(val) {
            return parseInt(val) + '%';
          }
        },
        legend: {
          show: false
        },
        grid: {
          padding: {
            top: 0,
            bottom: 0,
            right: 15
          }
        },
        plotOptions: {
          pie: {
            donut: {
              size: '85%',
              labels: {
                show: true,
                value: {
                  fontSize: '1.5rem',
                  fontFamily: 'Public Sans',
                  color: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success,
                    config.colors.danger
                  ],
                  offsetY: -15,
                  formatter: function(val) {
                    return parseFloat((val / total) * 100).toFixed(1) + '%';
                  }
                },
                name: {
                  offsetY: 20,
                  fontFamily: 'Public Sans'
                },
                total: {
                  show: true,
                  fontSize: '0.8125rem',
                  color: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success,
                    config.colors.danger
                  ],
                  label: 'Total',
                  // formatter: function(w) {
                  //   return parseFloat((w/total) * 100).toFixed(1) + '%';
                  // }
                }
              }
            }
          }
        }
      };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
      const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
      statisticsChart.render();
    }
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

  <div class="row">
    <div class="col-md-8 col-sm-12 mb-4 order-0">
      <div class="row">
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <i class="bx bxs-purchase-tag p-2 rounded text-info bg-label-secondary"></i>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Users</span>
              <h3 class="card-title mb-2">{{ $totals['users'] }}</h3>
            </div>
          </div>
        </div>
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <i class="bx bxs-user p-2 rounded text-info bg-label-secondary"></i>
                </div>
              </div>
              <span class="d-block mb-1">Users</span>
              <h3 class="card-title text-nowrap mb-2">{{ $totals['users'] }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-12 mb-4 order-1">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Sold Products Stats</h5>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column align-items-center gap-1">
              <h2 class="mb-2">{{ $totals['sales'] }}</h2>
              <span>Total Sales</span>
            </div>
            <div id="orderStatisticsChart"></div>
          </div>
          <ul class="p-0 m-0">
            @foreach ($sold_products_stats['tags'] as $tag => $value)
              <li class="d-flex @if (!$loop->last) mb-4 @endif pb-0">
                <div class="avatar flex-shrink-0 me-3 ">
                  <span class="avatar-initial rounded bg-label-secondary">
                    <i class='bx bxs-purchase-tag text-info'></i>
                  </span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">{{ ucfirst($tag) }}</h6>
                    {{-- <small class="text-muted">Mobile, Earbuds, TV</small> --}}
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">{{ $value }}</small>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 mb-4 order-2">
      <div class="card">
        <h5 class="card-header">Pending Orders</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-borderless">
            <thead>
              <tr>
                <th>Order</th>
                <th>Client Name</th>
                <th>Client Phone</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pending_orders as $order)
                <tr data-id="{{ $order->id }}">
                  <td>
                    <span class="ms-2 fw-bold">{{ $order->id }}</span>
                  </td>
                  <td>{{ $order->client_name }}</td>
                  <td>{{ $order->client_phone }}</td>
                  <td>
                    @if ($order->status == 'pending')
                      <span class="badge bg-label-primary me-1">
                      @elseif ($order->status == 'accepted')
                        <span class="badge bg-label-success me-1">
                        @elseif ($order->status == 'cancelled')
                          <span class="badge bg-label-danger me-1">
                          @else
                            <span class="badge bg-label-primary me-1">
                    @endif
                    {{ ucfirst($order->status) }}
                    </span>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a data-action="accept" data-id="{{ $order->id }}" class="dropdown-item"
                          href="javascript:void(0);">
                          <i class="bx bx-check me-1"></i>
                          Accept
                        </a>
                        <a data-action="cancel" data-id="{{ $order->id }}" class="dropdown-item"
                          href="javascript:void(0);">
                          <i class="bx bx-trash me-1"></i>
                          Cancel
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
