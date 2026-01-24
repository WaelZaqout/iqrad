@extends('admin.master')

@section('content')
    <div class="dashboard-container container" dir="rtl">

        <!-- Header Section -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ __('admin.financial_dashboard') }}</h1>
                <p class="text-muted small mb-0">{{ __('admin.last_update') }}: {{ now()->format('Y-m-d H:i') }}</p>
            </div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-download fa-sm text-white-50 ms-2"></i> {{ __('admin.download_full_report') }}
            </a>
        </div>

        <!-- KPI Cards (Key Performance Indicators) -->
        <div class="row mb-4">
            <!-- إجمالي المحفظة المستثمرة -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-primary-g">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-uppercase mb-1" style="opacity: 0.8">{{ __('admin.total_active_portfolio') }}
                                </div>
                                <div class="h3 mb-0 fw-bold">{{ number_format($totalInvestmentAmount ?? 0, 0) }} <small
                                        style="font-size: 0.6em">{{ $currency ?? __('admin.sar') }}</small></div>
                            </div>
                        </div>
                        <i class="fas fa-wallet icon-bg"></i>
                    </div>
                </div>
            </div>

            <!-- الأرباح المتوقعة -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-success-g">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-uppercase mb-1" style="opacity: 0.8">{{ __('admin.expected_profits') }}
                                </div>
                                <div class="h3 mb-0 fw-bold">
                                    {{ number_format($expectedProfits, 0) }} <small
                                        style="font-size: 0.6em">{{ $currency ?? __('admin.sar') }}</small>
                                </div>
                            </div>
                        </div>
                        <i class="fas fa-chart-line icon-bg"></i>
                    </div>
                </div>
            </div>

            <!-- طلبات قيد المراجعة -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-warning-g">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-uppercase mb-1" style="opacity: 0.8">{{ __('admin.pending_loans') }}</div>
                                <div class="h3 mb-0 fw-bold">{{ $pendingProjects }}</div>
                            </div>
                        </div>
                        <i class="fas fa-clipboard-list icon-bg"></i>
                    </div>
                </div>
            </div>

            <!-- القروض المتعثرة (مهم جداً لنظام القروض) -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-danger-g">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs fw-bold text-uppercase mb-1" style="opacity: 0.8">{{ __('admin.defaulted_loans') }}
                                </div>
                                <div class="h3 mb-0 fw-bold">{{ $defaultedProjects }}</div>
                            </div>
                        </div>
                        <i class="fas fa-exclamation-triangle icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column: Charts & Analysis (8 cols) -->
            <div class="col-xl-8 col-lg-7">

                <!-- Cash Flow Chart -->
                <div class="card modern-card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 fw-bold text-primary">
                            <i class="fas fa-wave-square ms-2"></i> {{ __('admin.cash_flow') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="height: 320px;">
                            <canvas id="cashFlowChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions Table -->
                <div class="card modern-card">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">{{ __('admin.recent_transactions') }}</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">{{ __('admin.project_borrower') }}</th>
                                        <th class="ps-4"> {{ __('admin.borrower') }}</th>
                                        <th>{{ __('admin.amount') }}</th>
                                        <th>{{ __('admin.status') }}</th>
                                        <th>{{ __('admin.date') }}</th>
                                        <th>{{ __('admin.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- مثال على البيانات --}}
                                    @forelse($recentProjects ?? [] as $project)
                                        <tr>
                                            <td class="ps-4 fw-bold">{{ $project->title }}</td>
                                            <td class="ps-4 fw-bold">{{ $project->borrower->name ?? 'غير محدد' }}</td>
                                            <td>{{ number_format($project->amount) }}</td>
                                            <td>
                                                @if ($project->status == 'pending')
                                                    <span class="badge bg-warning text-dark">{{ __('admin.pending') }}</span>
                                                @elseif($project->status == 'active')
                                                    <span class="badge bg-success">{{ __('admin.active') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ __('admin.other') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary rounded-circle"><i
                                                        class="fas fa-eye"></i></a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">{{ __('admin.no_recent_transactions') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Actions & Status (4 cols) -->
            <div class="col-xl-4 col-lg-5">

                <!-- Project Status Pie Chart -->
                <div class="card modern-card">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-primary">{{ __('admin.portfolio_distribution') }}</h6>
                    </div>
                    <div class="card-body">
                        <div style="height: 250px;">
                            <canvas id="statusChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mx-2"><i class="fas fa-circle text-success"></i> {{ __('admin.accepted') }}</span>
                            <span class="mx-2"><i class="fas fa-circle text-warning"></i> {{ __('admin.under_review') }}</span>
                            <span class="mx-2"><i class="fas fa-circle text-danger"></i> {{ __('admin.rejected') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Actions List -->
                <div class="card modern-card">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary">{{ __('admin.urgent_alerts') }}</h6>
                        <span class="badge bg-danger rounded-pill">0</span>
                    </div>
                    <div class="list-group list-group-flush">
                        {{-- @if ($pendingProjects > 0) --}}
                        <div class="list-group-item loan-item pending p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">{{ __('admin.new_loan_requests') }}</h6>
                                <small class="text-muted">{{ __('admin.now') }}</small>
                            </div>
                            <p class="mb-1 text-muted small">{{ __('admin.pending_approval_msg') }}</p>
                            <a href="{{ route('projects.index') }}" class="btn btn-sm btn-warning mt-2 text-dark">{{ __('admin.review_requests') }}</a>
                        </div>
                        {{-- @endif --}}

                        {{-- @if ($rejectedProjects > 0) --}}
                        <div class="list-group-item loan-item overdue p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold text-danger">{{ __('admin.default_rejected_cases') }}</h6>
                                <small class="text-muted">{{ __('admin.today') }}</small>
                            </div>
                            <p class="mb-1 text-muted small">{{ __('admin.critical_cases_msg') }}
                            </p>
                        </div>
                        {{-- @endif --}}

                        <!-- مثال ثابت لاستحقاق قسط -->
                        <div class="list-group-item loan-item p-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">{{ __('admin.upcoming_due') }}</h6>
                                <small class="text-muted">{{ __('admin.in_3_days') }}</small>
                            </div>
                            <p class="mb-1 text-muted small">{{ __('admin.collection_amount') }} 50,000 {{ $currency ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Summary Stats Mini -->
                <div class="row">
                    <div class="col-6">
                        <div class="card modern-card p-3 text-center bg-light">
                            <div class="text-primary mb-2"><i class="fas fa-users fa-2x"></i></div>
                            <div class="h5 mb-0 fw-bold">{{ $totalInvestors ?? 0 }}</div>
                            <small class="text-muted">{{ __('admin.investor') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card modern-card p-3 text-center bg-light">
                            <div class="text-info mb-2"><i class="fas fa-hand-holding-usd fa-2x"></i></div>
                            <div class="h5 mb-0 fw-bold">{{ $totalBorrowers ?? 0 }}</div>
                            <small class="text-muted">{{ __('admin.borrower_short') }}</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // الإعدادات العامة للخط
                Chart.defaults.font.family = "'Cairo', sans-serif";
                Chart.defaults.color = '#858796';

                const projectsData = {!! json_encode($projectsLast30 ?? array_fill(0, 30, 0)) !!};
                const cashFlowData = {!! json_encode($cashFlowLast30 ?? array_fill(0, 30, 0)) !!};

                // Pie Chart
                const statusChartCanvas = document.getElementById('statusChart');
                if (statusChartCanvas) {
                    const ctxPie = statusChartCanvas.getContext('2d');
                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: ['{{ __('admin.accepted_label') }}', '{{ __('admin.pending_label') }}', '{{ __('admin.rejected_label') }}'],
                            datasets: [{
                                data: [{{ $acceptedProjects ?? 0 }}, {{ $pendingProjects ?? 0 }},
                                    {{ $rejectedProjects ?? 0 }}
                                ],
                                backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                                hoverBackgroundColor: ['#17a673', '#dda20a', '#be2617'],
                                hoverBorderColor: "rgba(234, 236, 244, 1)",
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        },
                    });
                }

                // Cash Flow Chart (Line Chart)
                const cashFlowChartCanvas = document.getElementById('cashFlowChart');
                if (cashFlowChartCanvas) {
                    const ctxLine = cashFlowChartCanvas.getContext('2d');
                    new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode(
                                array_map(function ($i) {
                                    return now()->subDays($i)->format('m/d');
                                }, range(29, 0)),
                            ) !!},
                            datasets: [{
                                label: '{{ __('admin.net_cash_flow') }}',
                                data: cashFlowData,
                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                },
                                y: {
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                        callback: function(value) {
                                            return value + ' ' + '{{ $currency ?? '' }}';
                                        }
                                    },
                                    grid: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: "rgb(255,255,255)",
                                    bodyColor: "#858796",
                                    titleMarginBottom: 10,
                                    titleColor: '#6e707e',
                                    titleFont: {
                                        size: 14
                                    },
                                    borderColor: '#dddfeb',
                                    borderWidth: 1,
                                    xPadding: 15,
                                    yPadding: 15,
                                    displayColors: false,
                                    intersect: false,
                                    mode: 'index',
                                    caretPadding: 10,
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
