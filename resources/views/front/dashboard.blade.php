<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ auth()->user()->role === 'investor' || auth()->user()->hasRole('investor') ? 'صفحة المستثمر' : 'صفحة المقترض' }}
        - إقراضك</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/front/css/dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
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
                        <div class="icon-btn position-relative" data-bs-toggle="dropdown" title="الإشعارات"
                            style="cursor:pointer;">
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
                    <div class="icon-btn" data-bs-toggle="dropdown" style="cursor: pointer;" title="{{ __('auth.language') }} / {{ __('auth.arabic') }}">
                        <i class="fas fa-globe fa-lg"></i>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/lang/ar') }}"><i class="fas fa-language me-2"></i>
                                {{ __('auth.arabic') }}</a></li>
                        <li><a class="dropdown-item" href="{{ url('/lang/en') }}"><i
                                    class="fas fa-language me-2"></i>
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
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                        class="fas fa-user me-2"></i>
                                    {{ __('auth.profile') }}
                                    </a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-lock me-2"></i>
                                    {{ __('auth.change_password') }}</a></li>
                            @if (auth()->user()->role === 'investor' || auth()->user()->hasRole('investor'))
                                <li><a class="dropdown-item" href="#"><i class="fas fa-landmark me-2"></i>
                                        {{ __('auth.link_bank_account') }}</a></li>
                            @else
                                <li><a class="dropdown-item" href="#"><i class="fas fa-landmark me-2"></i> {{ __('auth.update_bank_account') }}</a></li>
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
        <!-- Welcome Section -->
        <div class="welcome-section text-center">
            @if (auth()->user()->role === 'investor' || auth()->user()->hasRole('investor'))
                <h2 class="text-primary mb-2">{{ __('auth.welcome') }} {{ auth()->user()->name }} 👋</h2>
                <p class="text-muted fs-5 mb-3">{{ __('auth.you_can_now_track_your_investments') }}</p>
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <button class="btn btn-primary btn-lg px-4 pulse">
                        <i class="fas fa-invest me-2"></i> {{ __('auth.invest_now') }}
                    </button>
                    <button class="btn btn-outline-secondary btn-lg px-4">
                        <i class="fas fa-chart-line me-2"></i> {{ __('auth.track_profits') }}
                    </button>
                </div>
            @else
                <h2 class="text-primary mb-2">{{ __('auth.welcome') }} {{ auth()->user()->name }} 👋</h2>
                <p class="text-muted fs-5 mb-3">{{ __('auth.you_can_now_track_your_projects') }}</p>
                </p>
                <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#helpModal">
                    <i class="fas fa-book me-2"></i> {{ __('auth.instructions') }}
                </button>
            @endif
            <p class="text-muted small mb-0">{{ __('auth.last_update') }}: 15 نوفمبر 2025</p>
        </div>

        <!-- Dashboard Overview -->
        <div class="dashboard-cards-container">
            @if (auth()->user()->role === 'investor' || auth()->user()->hasRole('investor'))
                <!-- Investor Cards -->
                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(30, 58, 138, 0.1), rgba(30, 58, 138, 0.2)); color: #1e3a8a;">
                        <i class="fas fa-sack-dollar"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.total_invested_capital') }} </div>
                        <div class="card-value counter" data-count="{{ $totalCapital }}">0</div>
                        <div class="card-unit">{{__('auth.sar')}}</div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(4, 120, 87, 0.1)); color: #10b981;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.total_profits_received') }}</div>
                        <div class="card-value counter" data-count="{{ $receivedProfits }}">0</div>
                        <div class="card-unit">{{ __('auth.sar') }}</div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(2, 132, 199, 0.1)); color: #06b6d4;">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.active_projects') }}</div>
                        <div class="card-value counter" data-count="{{ $activeProjects }}">0</div>
                        <div class="card-unit">{{ __('auth.projects') }}</div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(148, 163, 184, 0.1), rgba(100, 116, 139, 0.1)); color: #94a3b8;">
                        <i class="fas fa-circle-check"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.completed_projects') }}</div>
                        <div class="card-value counter" data-count="{{ $completedProjects }}">0</div>
                        <div class="card-unit">{{ __('auth.project') }}</div>
                    </div>
                </div>
            @else
                <!-- Borrower Cards -->
                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 64, 175, 0.1)); color: #3b82f6;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.upcoming_payments') }}</div>
                        <div class="card-value counter">0</div>
                        <div class="card-unit">{{ __('auth.payment') }}</div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1)); color: #f59e0b;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.projects_under_review') }}</div>
                        <div class="card-value counter" data-count="{{ $pendingProjects }}">0</div>
                        <div class="card-unit">{{ __('auth.project') }}</div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(4, 120, 87, 0.1)); color: #10b981;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.funded_projects') }}</div>
                        <div class="card-value counter" data-count="{{ $fundedProjects }}">0</div>
                        <div class="card-unit">{{ __('auth.project') }}</div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon"
                        style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 64, 175, 0.1)); color: #3b82f6;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ __('auth.total_required_funding') }}</div>
                        <div class="card-value counter"data-count="{{ $requiredFunding }}">0</div>
                        <div class="card-unit">{{ __('auth.sar') }}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Filters -->
        <div class="quick-filters">
            <button class="filter-btn active">{{ __('auth.all') }}</button>
            @if (auth()->user()->role === 'investor' || auth()->user()->hasRole('investor'))
                @foreach ($categories as $category)
                    <button class="filter-btn">{{ $category->name }}</button>
                @endforeach
            @else
                <button class="filter-btn">{{ __('auth.under_review') }}</button>
                <button class="filter-btn">{{ __('auth.under_funding') }}</button>
                <button class="filter-btn">{{ __('auth.fully_funded') }}</button>
            @endif
        </div>
        <!-- Primary CTA Button -->
        @if (auth()->user()->role !== 'investor' && !auth()->user()->hasRole('investor'))
            <div class="text-center mb-4">
                <button class="btn btn-primary-gradient" data-bs-toggle="modal" data-bs-target="#fundingModal">
                    <i class="fas fa-plus-circle me-2"></i> {{ __('auth.submit_new_project') }}
                </button>
            </div>
        @endif

        @if (auth()->user()->role === 'investor' || auth()->user()->hasRole('investor'))
            @include('front.partials.investor-section')
        @else
            @include('front.partials.borrower-section')
        @endif
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
                    <p style="font-size: 1rem; line-height: 1.8; opacity: 0.8; margin-bottom: 2rem;">{{ __('auth.p_description') }}</p>
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
                        <li><a href="#">{{ __('auth.available_investment_opportunities') }}</a></li>
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
                    <p style="margin-bottom: 1rem; opacity: 0.7;">{{ __('auth.subscribe_to_newsletter_description') }}</p>
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
                © 2025 {{ __('auth.platform_name') }}. {{ __('auth.all_rights_reserved') }}.
            </div>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Animated counters
        function animateCounters() {
            document.querySelectorAll('.counter').forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target.toLocaleString('ar-SA');
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.ceil(current).toLocaleString('ar-SA');
                    }
                }, 16);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            animateCounters();

            // Toggle notifications panel
            document.getElementById('notificationsBtn').addEventListener('click', function() {
                document.getElementById('notificationsPanel').classList.add('show');
            });

            document.getElementById('closeNotifications').addEventListener('click', function() {
                document.getElementById('notificationsPanel').classList.remove('show');
            });

            // Close notifications panel when clicking outside
            document.addEventListener('click', function(event) {
                const notificationsPanel = document.getElementById('notificationsPanel');
                const notificationsBtn = document.getElementById('notificationsBtn');

                if (!notificationsPanel.contains(event.target) &&
                    !notificationsBtn.contains(event.target) &&
                    notificationsPanel.classList.contains('show')) {
                    notificationsPanel.classList.remove('show');
                }
            });

            // Filter buttons functionality
            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        });
    </script>

    <script>
        // Form submission handling with better UX
        let isSubmitting = false;

        document.getElementById('projectForm')?.addEventListener('submit', function(e) {
            if (isSubmitting) return; // Prevent double submission

            isSubmitting = true;
            e.preventDefault(); // Prevent default form submission

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> جاري الإرسال...';
            submitBtn.disabled = true;

            // Submit the form after showing loading state
            setTimeout(() => {
                this.submit();
            }, 500);
        });
    </script>

    <script>
        // If server-side validation failed, open the funding modal so user sees errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                var fundingModalEl = document.getElementById('fundingModal');
                if (fundingModalEl) {
                    var fundingModal = new bootstrap.Modal(fundingModalEl);
                    fundingModal.show();
                }
            });
        @endif

        // Show success modal if controller set a success toast (after redirect)
        @if (session('toast.type') === 'success')
            document.addEventListener('DOMContentLoaded', function() {
                var successModalEl = document.getElementById('successModal');
                if (successModalEl) {
                    var successModal = new bootstrap.Modal(successModalEl);
                    successModal.show();
                }
            });
        @endif
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.progress-bar-fill').forEach(bar => {
                let percentage = bar.getAttribute('data-percentage');
                setTimeout(() => {
                    bar.style.width = percentage + '%';
                }, 200); // تأخير خفيف لظهور الحركة
            });
        });
    </script>

</body>

</html>
