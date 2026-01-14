<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.project') }} {{ __('auth.details') }} - {{ __('auth.p') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/front/css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>{{--  --}}
    <!-- Header -->
    <!-- Header -->
    <header>
        <div class="container header-inner">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <span class="logo-text">{{ __('auth.p') }}</span>
            </div>

            <div class="header-actions">
                <!-- Notifications -->
                @if (auth()->check())
                    <div class="dropdown">
                        <div class="icon-btn position-relative" data-bs-toggle="dropdown"
                            title="{{ __('auth.notifications') }}" style="cursor:pointer;">
                            <i class="fas fa-bell fa-lg"></i>

                            @if ($unreadNotifications->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                            @endif
                        </div>

                        <ul class="dropdown-menu" style="min-width: 320px; padding: 0;">
                            <li class="p-3 border-bottom bg-light">
                                <strong>{{ __('auth.notifications') }}</strong>
                            </li>

                            @forelse($notifications as $notification)
                                <li>
                                    <a class="dropdown-item d-flex align-items-start gap-2"
                                        href="{{ $notification->data['url'] ?? '#' }}"
                                        style="padding: 0.75rem 1rem; border-bottom: 1px solid #f1f1f1;
                               background: {{ $notification->read_at ? '#f3f4f6' : '#d1e7ff' }};">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                                            style="width: 40px; height: 40px; background: {{ $notification->read_at ? '#f3f4f6' : '#2563eb' }}; color: #fff;">
                                            <i class="fas fa-bell"></i>
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="fw-medium {{ $notification->read_at ? '' : 'text-dark' }}">
                                                {{ $notification->data['title'] }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.85rem;">
                                                {{ $notification->data['message'] }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.75rem;">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="text-center p-3 text-muted">{{ __('auth.no_notifications') }}</li>
                            @endforelse

                            <li class="text-center p-3">
                                <a href="{{ route('notification') }}" class="text-primary fw-medium"
                                    style="text-decoration: none;">
                                    {{ __('auth.view_all_notifications') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif


                <!-- <p>{{ __('auth.locale') }}: {{ app()->getLocale() }}</p> -->

                <!-- Language Toggle -->
                <div class="dropdown">
                    <div class="icon-btn" data-bs-toggle="dropdown" style="cursor: pointer;"
                        title="{{ __('auth.language') }} / {{ __('auth.arabic') }}">
                        <i class="fas fa-globe fa-lg"></i>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/lang/ar') }}"><i class="fas fa-language me-2"></i>
                                {{ __('auth.arabic') }}</a></li>
                        <li><a class="dropdown-item" href="{{ url('/lang/en') }}"><i class="fas fa-language me-2"></i>
                                {{ __('auth.english') }}</a></li>
                    </ul>
                </div>

                <div style="width: 1px; height: 32px; background: rgba(255,255,255,0.1); margin: 0 0.25rem;"></div>

                <!-- Profile / Login -->
                @auth
                    <div class="dropdown">
                        <div class="user-profile" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <div class="hidden-mobile" style="text-align: left;">
                                <div style="font-weight: 700; font-size: 0.95rem; line-height: 1.2;">
                                    {{ auth()->user()->name }}
                                </div>
                                <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 500;">
                                    {{ auth()->user()->role === 'investor' || auth()->user()->hasRole('investor') ? __('auth.active_investor') : __('auth.active_borrower') }}
                                </div>
                            </div>
                            <div class="user-avatar-circle">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down hidden-mobile" style="font-size: 0.75rem; color: #64748b;"></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-user me-2"></i>
                                    {{ __('auth.profile') }}
                                </a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-lock me-2"></i>
                                    {{ __('auth.change_password') }}</a></li>
                            @if (auth()->user()->role === 'investor' || auth()->user()->hasRole('investor'))
                                <li><a class="dropdown-item" href="#"><i class="fas fa-landmark me-2"></i>
                                        {{ __('auth.link_bank_account') }}</a></li>
                            @else
                                <li><a class="dropdown-item" href="#"><i class="fas fa-landmark me-2"></i>
                                        {{ __('auth.update_bank_account') }}</a></li>
                                </a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <li><button type="submit" class="dropdown-item text-danger"><i
                                            class="fas fa-sign-out-alt me-2"></i> {{ __('auth.logout') }}</button></li>
                            </form>
                        </ul>
                    </div>
                @else
                    <button class="btn btn-primary open-auth" data-tab="login"
                        style="font-size: 0.9rem; padding: 0.5rem 1rem;">{{ __('auth.login') }}</button>
                @endauth
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Project Header -->
        <div class="project-header">
            <div class="d-flex flex-wrap align-items-start gap-4 mb-3">
                <div class="sector-icon sector-education">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="flex-grow-1">
                    <h2 class="mb-2">{{ $project->title }}</h2>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="status-badge {{ $project->status_badge['class'] }}">
                            {{ $project->status_badge['label'] }}
                        </span>

                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @auth
                        <button class="btn btn-outline-primary add-to-favorite" data-project="{{ $project->id }}">
                            <i class="fas fa-heart me-1"></i>
                            {{ __('auth.add_to_favorite') }}
                        </button>
                    @else
                        <button class="btn btn-outline-secondary open-auth">
                            <i class="fas fa-heart me-1"></i> {{ __('auth.login_to_add') }}
                        </button>
                    @endauth


                    {{-- <button class="btn btn-primary px-4 py-2">
                        <i class="fas fa-invest me-1"></i> {{ __('auth.invest_now') }}
                    </button> --}}
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <!-- Card 1: {{ __('auth.expected_annual_return') }} -->
            <div class="summary-card">
                <div class="summary-icon icon-return">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="summary-value">+{{ $project->interest_rate }}%</div>
                <div class="summary-label">{{ __('auth.expected_annual_return') }}</div>
            </div>

            <!-- Card 2: {{ __('auth.investment_duration') }} -->
            <div class="summary-card">
                <div class="summary-icon icon-duration">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="summary-value">{{ $project->term_months }} {{ __('auth.month') }}</div>
                <div class="summary-label">{{ __('auth.investment_duration') }}</div>
            </div>

            <!-- Card 3: {{ __('auth.minimum_investment') }} -->
            <div class="summary-card">
                <div class="summary-icon icon-minimum">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="summary-value">{{ $project->min_investment }} {{ __('auth.sar') }}</div>
                <div class="summary-label">{{ __('auth.minimum_investment') }}</div>
            </div>

            <!-- Card 4: {{ __('auth.current_funding_percentage') }} -->
            <div class="summary-card">
                <div class="summary-icon icon-progress">
                    <i class="fas fa-chart-bar"></i>
                </div>

                <div class="summary-value">{{ $percentage }}%</div>
                <div class="summary-label">{{ __('auth.current_funding_percentage') }}</div>
            </div>
        </div>

        <!-- Fund Progress Section -->
        <div class="progress-section">
            <h4 class="mb-3">{{ __('auth.funding_bar') }}</h4>
            <div class="d-flex justify-content-between mb-1">
                <span>{{ __('auth.required') }}: {{ number_format($project->funding_goal) }}
                    {{ __('auth.sar') }}</span>
                <span>{{ __('auth.collected') }}: {{ number_format($project->funded_amount) }}
                    {{ __('auth.sar') }}</span>
            </div>
            <div class="progress-container">
                <div class="progress-fill" style="width: {{ $percentage }}%"></div>
            </div>
            <div class="progress-stats">
                <div class="progress-stat">
                    <div class="progress-stat-value">{{ number_format($project->funded_amount) }}
                        {{ __('auth.sar') }}</div>
                    <div class="progress-stat-label">{{ __('auth.collected_amount') }}</div>
                </div>
                <div class="progress-stat">
                    <div class="progress-stat-value">{{ $project->investments()->count() }}
                    </div>
                    <div class="progress-stat-label">{{ __('auth.investors_count') }}</div>
                </div>
                <div class="progress-stat">
                    <div class="progress-stat-value">{{ number_format($remaining) }} {{ __('auth.sar') }}</div>
                    <div class="progress-stat-label">{{ __('auth.remaining') }}</div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs-section">
            <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about"
                        type="button" role="tab" aria-controls="about" aria-selected="true">
                        <i class="fas fa-info-circle me-2"></i> {{ __('auth.about_project') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial"
                        type="button" role="tab" aria-controls="financial" aria-selected="false">
                        <i class="fas fa-chart-line me-2"></i> {{ __('auth.financial_plan') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="owner-tab" data-bs-toggle="tab" data-bs-target="#owner"
                        type="button" role="tab" aria-controls="owner" aria-selected="false">
                        <i class="fas fa-user-tie me-2"></i> {{ __('auth.project_owner') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="risks-tab" data-bs-toggle="tab" data-bs-target="#risks"
                        type="button" role="tab" aria-controls="risks" aria-selected="false">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ __('auth.investment_risks') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="projectTabContent">
                <!-- Tab 1: {{ __('auth.about_project') }} -->
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <h5 class="mb-3">{{ __('auth.project_description') }}</h5>
                    <p class="text-muted mb-4">{{ $project->description }}</p>

                    <h5 class="mb-3">{{ __('auth.project_summary') }}</h5>
                    <p class="text-muted mb-4">{{ $project->summary }}</p>

                    <h5 class="mb-3">{{ __('auth.project_category') }}</h5>
                    <p class="text-muted mb-4">{{ $project->category->name ?? __('auth.not_specified') }}</p>
                </div>


                <!-- Tab 2: {{ __('auth.financial_plan') }} -->
                <div class="tab-pane fade" id="financial" role="tabpanel" aria-labelledby="financial-tab">
                    <h5 class="mb-3">{{ __('auth.total_project_cost') }}</h5>
                    <p class="text-muted mb-4">{{ __('auth.total_cost') }}:
                        <strong>{{ number_format($project->funding_goal) }} {{ __('auth.sar') }}</strong>
                    </p>

                    <h5 class="mb-3">{{ __('auth.funding_distribution') }}</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <ul class="text-muted">
                                <li class="mb-2">{{ __('auth.total_cost') }}:
                                    <strong>{{ number_format($project->funding_goal) }} {{ __('auth.sar') }}</strong>
                                </li>
                                <li class="mb-2">{{ __('auth.funded_amount_so_far') }}:
                                    <strong>{{ number_format($project->funded_amount) }} {{ __('auth.sar') }}</strong>
                                </li>
                                <li class="mb-2">{{ __('auth.minimum_investment_amount') }}:
                                    <strong>{{ number_format($project->min_investment) }}
                                        {{ __('auth.sar') }}</strong>
                                </li>
                                <li class="mb-2">{{ __('auth.funding_duration') }}:
                                    <strong>{{ $project->term_months }} {{ __('auth.months') }}</strong>
                                </li>
                                <li class="mb-2">{{ __('auth.interest_rate') }}:
                                    <strong>{{ $project->interest_rate }}%</strong>
                                </li>
                            </ul>

                        </div>
                        <div class="col-md-6">
                            <div class="chart-container" style="height: 200px;">
                                <canvas id="fundingChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3">{{ __('auth.revenue_and_profit_forecast') }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('auth.year') }}</th>
                                    <th>{{ __('auth.revenue') }}</th>
                                    <th>{{ __('auth.cost') }}</th>
                                    <th>{{ __('auth.net_profit') }}</th>
                                    <th>{{ __('auth.profit_percentage') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($financialPlan as $item)
                                    <tr>
                                        <td>{{ $item['year'] }}</td>
                                        <td>{{ number_format($item['revenue']) }} {{ __('auth.sar') }}</td>
                                        <td>{{ number_format($item['cost']) }} {{ __('auth.sar') }}</td>
                                        <td>{{ number_format($item['profit']) }} {{ __('auth.sar') }}</td>
                                        <td>{{ $item['profit_percent'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mb-3">{{ __('auth.break_even_point') }}</h5>
                    <p class="text-muted">
                        {{ __('auth.break_even_description') }}
                    </p>
                </div>

                <!-- Tab 3: {{ __('auth.project_owner') }} -->
                <div class="tab-pane fade" id="owner" role="tabpanel" aria-labelledby="owner-tab">
                    <div class="d-flex align-items-start gap-4 mb-4">
                        <div class="avatar">
                            {{ $borrower->avatar ?? substr($borrower->name, 0, 1) }}
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $borrower->name }}</h5>
                            @if (!empty($borrower->verified_documents))
                                <div class="verified-badge">
                                    <i class="fas fa-check-circle"></i> {{ __('auth.verified') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <h5 class="mb-3">{{ __('auth.experience_summary') }}</h5>
                    <p class="text-muted mb-4">
                        {{ $borrower->bio }}
                    </p>

                    @if (!empty($borrower->verified_documents))
                        <h5 class="mb-3">{{ __('auth.verification') }}</h5>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($borrower->verified_documents as $document)
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>{{ $document }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>


                <!-- Tab 4: {{ __('auth.investment_risks') }} -->
                <div class="tab-pane fade" id="risks" role="tabpanel" aria-labelledby="risks-tab">
                    <div class="risk-item">
                        <div class="risk-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ __('auth.project_delay_title') }}</h6>
                            <p class="text-muted mb-0">
                                {{ __('auth.project_delay') }}
                            </p>
                        </div>
                    </div>

                    <div class="risk-item">
                        <div class="risk-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ __('auth.market_competition_title') }}</h6>
                            <p class="text-muted mb-0">
                                {{ __('auth.market_competition') }}
                            </p>
                        </div>
                    </div>

                    <div class="risk-item">
                        <div class="risk-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ __('auth.technical_changes_title') }}</h6>
                            <p class="text-muted mb-0">
                                {{ __('auth.technical_changes') }}
                            </p>
                        </div>
                    </div>

                    <div class="risk-item">
                        <div class="risk-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ __('auth.relying_on_continued_funding_title') }}</h6>
                            <p class="text-muted mb-0">
                                {{ __('auth.relying_on_continued_funding') }}
                            </p>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4">
                        <h6 class="mb-2"><i class="fas fa-exclamation-triangle me-2"></i>
                            {{ __('auth.regulatory_notice') }}</h6>
                        <p class="mb-0">
                            {{ __('auth.expected_returns_not_guaranteed') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>



        <div class="timeline-container"
            style="background:white; border-radius:24px; padding:2rem; box-shadow:var(--card-shadow); border:1px solid #f1f5f9;">
            <h4 class="mb-4">{{ __('auth.project_stages') }}</h4>
            <div class="timeline">
                @foreach ($project->stages() as $field => $label)
                    <div class="timeline-item d-flex justify-content-between align-items-center mb-4">
                        <div class="timeline-content">
                            <h6 class="fw-bold mb-2">{{ $label }}</h6>
                            <small class="text-muted">
                                @if ($project->$field)
                                    <i class="fas fa-calendar-check me-1 text-success"></i>
                                    {{ $project->$field->format('d F Y') }}
                                    <span class="badge bg-success ms-2">{{ __('auth.completed') }}</span>
                                @else
                                    <i class="fas fa-clock me-1 text-muted"></i>
                                    <span class="text-muted">{{ __('auth.not_reached_yet') }}</span>
                                @endif
                            </small>
                        </div>
                        <div class="timeline-dot {{ $project->$field ? 'completed' : 'pending' }}">
                            @if ($project->$field)
                                <i class="fas fa-check text-white"></i>
                            @else
                                <i class="fas fa-circle text-muted"></i>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Repayment Section -->
        <h3 class="section-title mt-5">{{ __('auth.installment_table') }}</h3>
        <div class="repayment-alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle text-danger me-2"></i>
            </div>
        </div>
        <div
            style="background: white; border-radius: 24px; padding: 2rem; box-shadow: var(--card-shadow); border: 1px solid #f1f5f9;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-1" style="color: #0f172a;">{{ $project->title }}</h4>
                    <p class="text-muted mb-0">{{ __('auth.total_amount') }}:{{ $project->funding_goal }}
                        {{ __('auth.sar') }}</p>
                </div>
                <div class="text-end">
                    <div class="fw-bold fs-5">💳 {{ __('auth.paid') }}: {{ $project->funded_amount }}
                        {{ __('auth.sar') }}</div>
                    <div class="text-success fw-bold fs-5">💰 {{ __('auth.remaining_amount') }}:
                        {{ $project->funding_goal - $project->funded_amount }} {{ __('auth.sar') }}</div>
                </div>
            </div>
            <div
                style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); height: 8px; border-radius: 4px; margin-bottom: 1.5rem; overflow: hidden;">
                <div
                    style="height: 100%; background: linear-gradient(90deg, #1e40af, #10b981); width: {{ $percentage }}%;">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('auth.installment_number') }}</th>
                            <th>{{ __('auth.amount') }}</th>
                            <th>{{ __('auth.status') }}</th>
                            <th>{{ __('auth.actual_payment_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->investments as $index => $ins)
                            @php
                                $paidDate = $ins->paid_at;
                                $daysRemaining = $paidDate
                                    ? $paidDate->startOfDay()->diffInDays(\Carbon\Carbon::now()->startOfDay(), false)
                                    : '--';
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $index + 1 }}</td>
                                <td>{{ number_format($ins->amount) }} {{ __('auth.sar') }}</td>

                                <td>
                                    @if ($ins->status === 'paid')
                                        <span
                                            style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; padding: 0.35rem 0.8rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; display: inline-block;">{{ __('auth.paid_status') }}</span>
                                    @elseif ($ins->status === 'pending')
                                        <span
                                            style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; padding: 0.35rem 0.8rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; display: inline-block;">{{ __('auth.pending_status') }}</span>
                                    @else
                                        <span
                                            style="background: linear-gradient(135deg, #fee2e2, #fca5a5); color: #b91c1c; padding: 0.35rem 0.8rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; display: inline-block;">{{ __('auth.defaulted_status') }}</span>
                                    @endif
                                </td>

                                <td>{{ $paidDate ? $paidDate->format('d / m / Y') : '--' }}</td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
        <!-- Investment Form -->
        <div class="investment-form">
            <h4 class="mb-3">{{ __('auth.quick_investment_form') }}</h4>

            <div class="mb-4">
                <label>{{ __('auth.investment_amount') }} ({{ __('auth.minimum_investment') }} <span
                        id="minAmount"></span> {{ __('auth.sar') }})</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ __('auth.sar') }}</span>

                    <input type="number" class="form-control form-control-lg" id="investAmount" min="1000"
                        placeholder="1000" value="1000" oninput="calculateReturn()">
                </div>

                <div class="quick-amounts">
                    <div class="quick-amount active" data-amount="1000">1,000</div>
                    <div class="quick-amount" data-amount="5000">5,000</div>
                    <div class="quick-amount" data-amount="10000">10,000</div>
                    <div class="quick-amount" data-amount="25000">25,000</div>
                </div>
            </div>

            <div class="summary-box">
                <div class="summary-item">
                    <span class="summary-label">{{ __('auth.expected_share') }}</span>
                    <span class="summary-value" id="sharePercentage">
                        {{-- Use a passed $percentage, otherwise compute from funded_amount / funding_goal --}}
                        {{ isset($percentage) ? number_format($percentage, 2) : ($project->funding_goal ? number_format(($project->funded_amount / $project->funding_goal) * 100, 2) : '0.00') }}%
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">{{ __('auth.expected_return') }}</span>
                    <span class="summary-value" id="expectedReturn">0.00 {{ __('auth.sar') }}
                        {{ __('auth.monthly') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">{{ __('auth.investment_term') }}</span>
                    <span class="summary-value" id="investmentTerm">{{ $project->term_months }}
                        {{ __('auth.month') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">{{ __('auth.total_return') }}</span>
                    <span class="summary-value text-success" id="totalReturn">+{{ $project->interest_rate }}%</span>
                </div>
            </div>

            <button class="btn btn-invest" onclick="redirectToStripe()">
                <i class="fas fa-check-circle me-2"></i> {{ __('auth.confirm_investment') }}
            </button>

            <p class="disclaimer text-center mb-0">
                <i class="fas fa-info-circle me-1"></i> {{ __('auth.agreement_disclaimer') }}.
            </p>
        </div>
        <!-- Reviews Display -->
        <div class="review-section"
            style="background:white; border-radius:24px; padding:2rem; box-shadow:var(--card-shadow); border:1px solid #f1f5f9; margin-bottom:2rem;">

            <h4 class="mb-3">⭐ {{ __('auth.investor_reviews') }}</h4>

            <!-- Average Rating -->
            <div class="d-flex align-items-center mb-4">
                <span class="fs-4 fw-bold me-2">{{ $averageRating ?: '0.0' }}</span>

                <div class="text-warning fs-5">
                    @for ($i = 1; $i <= 5; $i++)
                        {{ $i <= round($averageRating) ? '★' : '☆' }}
                    @endfor
                </div>

                <span class="text-muted ms-3">({{ $reviewsCount }} {{ __('auth.reviews_count') }})</span>
            </div>

            <!-- Reviews List -->
            @forelse ($reviews as $review)
                <div class="mb-4 pb-3 border-bottom">
                    <div class="mb-4 text-center">
                        <div class="star-rating" style="direction:ltr;">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating"
                                    value="{{ $i }}" required style="display:none;">
                                <label for="star{{ $i }}" class="star">★</label>
                            @endfor
                        </div>
                    </div>


                    @if ($review->comment)
                        <p class="text-muted mt-2 mb-0">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <p class="text-muted">{{ __('auth.no_reviews_yet') }}.</p>
            @endforelse
            @auth
                @if (!$userReview)
                    <div class="review-section"
                        style="background:#f8fafc; border-radius:24px; padding:2rem; box-shadow:var(--card-shadow); border:1px dashed #cbd5e1;">

                        <h3 class="mb-4 text-center">✍️ {{ __('auth.rate_your_experience') }}</h3>

                        <form action="{{ route('review.store') }}" method="POST"
                            style="max-width:600px; margin:0 auto;">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <!-- Stars -->
                            <div class="mb-4 text-center">
                                <div class="star-rating" style="direction:ltr;">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating"
                                            value="{{ $i }}" required style="display:none;">
                                        <label for="star{{ $i }}" class="star">★</label>
                                    @endfor
                                </div>
                            </div>

                            <!-- Comment -->
                            <div class="mb-4">
                                <textarea name="comment" class="form-control" rows="4"
                                    placeholder="{{ __('auth.share_your_experience') }}..." style="border-radius:12px;"></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-5 py-2">
                                    <i class="fas fa-paper-plane me-2"></i> {{ __('auth.submit_review') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="alert alert-success text-center mt-4">
                        <i class="fas fa-check-circle me-1"></i>
                        {{ __('auth.thank_you_reviewed') }} ⭐
                    </div>
                @endif
            @endauth

        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="logo" style="color: white; margin-bottom: 1.5rem;">
                        <div class="logo-icon" style="background: white; color: var(--primary);">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <span class="logo-text">{{ __('auth.p') }}</span>
                    </div>
                    <p style="font-size: 1rem; line-height: 1.8; opacity: 0.8; margin-bottom: 2rem;">
                        {{ __('auth.platform_description') }}</p>
                    <div style="display: flex; gap: 1rem; font-size: 1.4rem;">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div>
                    <h5 class="footer-title">{{ __('auth.quick_links') }}</h5>
                    <ul class="footer-links" style="font-size: 1rem;">
                        <li><a href="#">{{ __('auth.investment_opportunities') }}</a></li>
                        <li><a href="#">{{ __('auth.active_projects') }}</a></li>
                        <li><a href="#">{{ __('auth.how_it_works') }}</a></li>
                        <li><a href="#">{{ __('auth.success_stories') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="footer-title">{{ __('auth.support_and_help') }}</h5>
                    <ul class="footer-links" style="font-size: 1rem;">
                        <li><a href="#">{{ __('auth.support_center') }}</a></li>
                        <li><a href="#">{{ __('auth.privacy_policy') }}</a></li>
                        <li><a href="#">{{ __('auth.terms_of_use') }}</a></li>
                        <li><a href="#">{{ __('auth.contact_us') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="footer-title">{{ __('auth.subscribe_to_newsletter') }}</h5>
                    <p style="margin-bottom: 1rem; opacity: 0.7;">
                        {{ __('auth.subscribe_to_newsletter_description') }}</p>
                    <div style="position: relative; margin-bottom: 1rem;">
                        <input type="email" placeholder="{{ __('auth.email') }}"
                            style="width: 100%; padding: 1rem; border-radius: 0.75rem; border: none; background: rgba(255,255,255,0.1); color: white; backdrop-filter: blur(5px);">
                        <button
                            style="position: absolute; left: 6px; top: 6px; bottom: 6px; background: var(--primary); border: none; border-radius: 0.5rem; color: white; padding: 0 16px; cursor: pointer; transition: 0.3s;"><i
                                class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <div
                style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2.5rem; text-align: center; font-size: 0.95rem; opacity: 0.6;">
                © 2025 {{ __('auth.p') }}. {{ __('auth.all_rights_reserved') }}.
            </div>
        </div>
    </footer>
    <script>
        let selectedProjectId = {{ $project->id }};
        let projectReturn = {{ $project->interest_rate }};
        let minInvestment = {{ $project->min_investment }};

        function openInvestModal(id, name, minAmount, annualReturn) {
            selectedProjectId = id;
            projectReturn = Number(annualReturn); // Convert number
            minInvestment = Number(minAmount);

            document.getElementById("projectName").textContent = name;
            document.getElementById("minAmount").textContent = minInvestment;

            document.getElementById("investAmount").min = minInvestment;
            document.getElementById("investAmount").value = minInvestment;

            calculateReturn();

            document.getElementById("investModal").style.display = "flex";
        }


        function closeInvestModal() {
            document.getElementById("investModal").style.display = "none";
        }

        function calculateReturn() {
            let amount = Number(document.getElementById("investAmount").value);

            if (amount < minInvestment) {
                document.getElementById("investAmount").value = minInvestment;
                amount = minInvestment;
            }

            let annual = (amount * projectReturn) / 100;
            let monthly = annual / 12;

            document.getElementById("expectedReturn").textContent =
                monthly.toFixed(2) + " {{ __('auth.sar') }} {{ __('auth.monthly') }}";

            // Update summary box
            updateSummaryBox(amount);
        }

        function updateSummaryBox(amount) {
            const totalProject = {{ $project->funding_goal }};
            const termMonths = {{ $project->term_months }};
            const sharePercentage = (amount / totalProject) * 100;

            // Update by IDs to avoid brittle selectors
            const shareEl = document.getElementById('sharePercentage');
            if (shareEl) shareEl.textContent = sharePercentage.toFixed(2) + '%';

            const termEl = document.getElementById('investmentTerm');
            if (termEl) termEl.textContent = termMonths + ' {{ __('auth.month') }}';

            const totalReturnEl = document.getElementById('totalReturn');
            if (totalReturnEl) totalReturnEl.textContent = '+' + projectReturn + '%';
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateReturn();
        });

        function redirectToStripe() {
            let amount = Number(document.getElementById("investAmount").value);

            if (amount < minInvestment) {
                alert("{{ __('auth.investment_amount') }} {{ __('auth.must_be_at_least') }} " + minInvestment +
                    " {{ __('auth.sar') }}");
                return;
            }

            fetch("/investments/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        project_id: selectedProjectId,
                        amount: amount
                    })
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        window.location.href = "/checkout-stripe/" + response.investment_id;
                    } else {
                        alert("{{ __('auth.investment_save_error') }}");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("{{ __('auth.server_connection_error') }}");
                });
        }
    </script>

    <script>
        document.querySelectorAll('.quick-amount').forEach(btn => {
            btn.addEventListener('click', function() {
                let amount = parseInt(this.dataset.amount);
                document.getElementById('investAmount').value = amount;
                calculateReturn();

                document.querySelectorAll('.quick-amount')
                    .forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize funding distribution chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('fundingChart').getContext('2d');
            const fundingChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __('auth.platform_development') }}',
                        '{{ __('auth.educational_content') }}', '{{ __('auth.marketing') }}',
                        '{{ __('auth.training') }}', '{{ __('auth.administrative_costs') }}'
                    ],
                    datasets: [{
                        data: [40, 25, 15, 10, 10],
                        backgroundColor: [
                            '#059669',
                            '#0891b2',
                            '#7c3aed',
                            '#ea580c',
                            '#6b7280'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
    <script>
        document.querySelector('.btn-invest').addEventListener('click', function(e) {
            e.target.disabled = true;
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on('click', '.add-to-favorite', function() {

            let btn = $(this);
            let projectId = btn.data('project');

            $.ajax({
                url: "{{ route('favorites.toggle') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    project_id: projectId
                },
                success: function(res) {
                    if (res.status === 'added') {
                        btn.removeClass('btn-outline-primary')
                            .addClass('btn-danger');
                    } else {
                        btn.removeClass('btn-danger')
                            .addClass('btn-outline-primary');
                    }
                }
            });

        });
    </script>

</body>

</html>
