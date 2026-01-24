<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="منصة إقراضك للإقراض الجماعي تربط المستثمرين بأصحاب المشاريع المبتكرة لخلق فرص نمو مشتركة.">
    <meta name="keywords" content="تمويل جماعي, استثمار, إقراض, مشاريع, أرباح آمنة, إقراضك">
    <meta name="author" content="إقراضك">
    <meta property="og:title" content="إقراضك | استثمر في مشاريع حقيقية بأرباح آمنة">
    <meta property="og:description"
        content="منصة إقراضك للإقراض الجماعي تربط المستثمرين بأصحاب المشاريع المبتكرة لخلق فرص نمو مشتركة.">
    <meta property="og:image" content="https://tamkeen.com/og-image.jpg">
    <meta property="og:url" content="https://tamkeen.com">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="إقراضك | استثمر في مشاريع حقيقية بأرباح آمنة">
    <meta name="twitter:description"
        content="منصة إقراضك للإقراض الجماعي تربط المستثمرين بأصحاب المشاريع المبتكرة لخلق فرص نمو مشتركة.">
    <meta name="twitter:image" content="https://tamkeen.com/og-image.jpg">
    <link rel="icon" type="image/x-icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💰</text></svg>">
    <title>إقراضك - منصة التمويل الجماعي الذكي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/styles.media.css') }}">
    @if (App::getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('assets/front/css/en.css') }}">
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-content">
            <div class="preloader-icon">
                <i class="fas fa-hand-holding-usd" aria-hidden="true"></i>
            </div>
            <h3>{{ __('auth.loading_platform') }}</h3>
        </div>
    </div>
    <!-- Notification Bar -->
    <div class="notification-bar" id="notificationBar">
        <i class="fas fa-bullhorn" aria-hidden="true"></i> <span
            class="scrolling-text">{{ __('auth.new_project_approved') }}</span>
        </span>
    </div>
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
                    <div class="icon-btn" data-bs-toggle="dropdown" style="cursor: pointer;"
                        title="{{ __('auth.language') }} / {{ __('auth.arabic') }}">
                        <i class="fas fa-globe fa-lg"></i>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/lang/ar') }}"><i
                                    class="fas fa-language me-2"></i>
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

    @yield('content')
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
                    <p style="margin-bottom: 1rem; opacity: 0.7;">{{ __('auth.subscribe_to_newsletter_description') }}
                    </p>
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
    <!-- Project Detail Modal -->
    <div id="projectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeProjectModal()" aria-label="إغلاق">&times;</span>
            <div id="projectDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content payment-modal">
            <span class="close" onclick="closePaymentModal()" aria-label="{{ __('auth.close') }}">&times;</span>
            <div class="modal-header">{{ __('auth.invest_project') }}</div>
            <div class="modal-body">
                <div class="payment-form">
                    <div class="form-group">
                        <label for="investAmount">{{ __('auth.investment_amount_min') }}</label>
                        <input type="number" id="investAmount" min="1000" value="5000" aria-required="true">
                    </div>
                    <div class="form-group">
                        <label for="expectedReturn">{{ __('auth.expected_return') }}</label>
                        <input type="text" id="expectedReturn" value="400{{ __('auth.sar_month') }} (8% سنوياً)"
                            readonly>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cardNumber">{{ __('auth.card_number') }}</label>
                            <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456"
                                aria-required="true">
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">{{ __('auth.expiry_date') }}</label>
                            <input type="text" id="expiryDate" placeholder="MM/YY" aria-required="true">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cvv">{{ __('auth.card_cvv') }}</label>
                            <input type="text" id="cvv" placeholder="123" aria-required="true">
                        </div>
                        <div class="form-group">
                            <label for="cardName">{{ __('auth.card_holder_name') }}</label>
                            <input type="text" id="cardName" aria-required="true">
                        </div>
                    </div>
                    <button class="btn btn-primary" style="width: 100%; margin-top: 20px;"
                        onclick="processPayment()">{{ __('auth.complete_payment') }}</button>
                </div>
                <div class="stripe-notice" aria-label="{{ __('auth.payment_security') }}">
                    <i class="fab fa-cc-stripe" aria-hidden="true"></i> {{ __('auth.secure_payment_stripe') }}
                </div>
            </div>
        </div>
    </div>
    <!-- Apply Project Modal -->
    <div id="applyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeApplyModal()" aria-label="{{ __('auth.close') }}">&times;</span>
            <div class="modal-header">{{ __('auth.apply_project_funding') }}</div>
            <div class="modal-body">
                <form class="apply-form">
                    <div class="form-group">
                        <label for="projectName">{{ __('auth.project_name_placeholder') }}</label>
                        <input type="text" id="projectName"
                            placeholder="{{ __('auth.project_name_placeholder') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="sector">{{ __('auth.sector') }}</label>
                        <select id="sector" required>
                            <option value="">{{ __('auth.select_sector') }}</option>
                            <option value="agriculture">{{ __('auth.sector_agriculture') }}</option>
                            <option value="health">{{ __('auth.sector_health') }}</option>
                            <option value="education">{{ __('auth.sector_education') }}</option>
                            <option value="technology">{{ __('auth.sector_technology') }}</option>
                            <option value="food">{{ __('auth.sector_food') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">{{ __('auth.required_amount') }}</label>
                        <input type="number" id="amount" placeholder="50000" min="10000" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">{{ __('auth.select_duration') }}</label>
                        <select id="duration" required>
                            <option value="">{{ __('auth.select_duration') }}</option>
                            <option value="12">12 شهر</option>
                            <option value="24">24 شهر</option>
                            <option value="36">36 شهر</option>
                            <option value="48">48 شهر</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="guarantee">{{ __('auth.guarantee') }}</label>
                        <input type="text" id="guarantee" placeholder="{{ __('auth.guarantee_placeholder') }}"
                            required>
                    </div>
                    <div class="form-group full">
                        <label for="description">{{ __('auth.short_description') }}</label>
                        <textarea id="description" placeholder="{{ __('auth.project_description_placeholder') }}" required></textarea>
                    </div>
                    <div class="form-group full">
                        <label for="attachments">{{ __('auth.attachments') }}</label>
                        <div class="form-file" onclick="document.getElementById('fileInput').click()" role="button">
                            <i class="fas fa-cloud-upload-alt"
                                style="font-size: 24px; margin-bottom: 8px; color: var(--gray-500);"
                                aria-hidden="true"></i>
                            <p>{{ __('auth.upload_files') }}</p>
                            <input type="file" id="fileInput" style="display: none;" multiple>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label for="contact">{{ __('auth.contact_method') }}</label>
                        <input type="text" id="contact" placeholder="{{ __('auth.contact_placeholder') }}"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; margin-top: 20px;">{{ __('auth.send_request') }}</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Auth Modal (Login / Register) -->
    <div id="authModal" class="modal" role="dialog" aria-hidden="true" aria-labelledby="authModalLabel">
        <div class="modal-content auth-modal">

            <span class="close" onclick="closeAuthModal()" aria-label="{{ __('auth.close') }}">&times;</span>

            <div class="auth-tabs" style="display:flex; gap:8px; justify-content:center; margin-bottom:12px;">
                <button type="button" class="tab-btn active" data-tab="login"
                    id="authTabLogin">{{ __('auth.login') }}</button>
                <button type="button" class="tab-btn" data-tab="register"
                    id="authTabRegister">{{ __('auth.register') }}</button>
            </div>

            <div class="auth-body">

                <!-- تسجيل الدخول -->
                <form id="loginForm" class="auth-form" method="POST" action="{{ route('login') }}">

                    @csrf

                    <div class="form-group">
                        <label for="loginEmail">{{ __('auth.email') }}</label>
                        <input id="loginEmail" name="email" type="email" required>
                    </div>

                    <div class="form-group">
                        <label for="loginPassword">{{ __('auth.password') }}</label>
                        <input id="loginPassword" name="password" type="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; margin-top:12px;">
                        {{ __('auth.login') }}
                    </button>

                    <div style="text-align:center; margin-top:8px; font-size:0.95rem;">
                        <a href="#" id="toRegister"
                            style="text-decoration:underline;">{{ __('auth.new_account') }}</a>
                    </div>
                </form>

                <!-- إنشاء حساب -->
                <form id="registerForm" class="auth-form" method="POST" action="{{ route('register') }}"
                    style="display:none;">
                    @csrf

                    <div class="form-group">
                        <label for="regName">{{ __('auth.full_name') }}</label>
                        <input id="regName" name="name" type="text" required>
                    </div>

                    <div class="form-group">
                        <label for="regEmail">{{ __('auth.email') }}</label>
                        <input id="regEmail" name="email" type="email" required>
                    </div>

                    <div class="form-group">
                        <label for="regPhone">{{ __('auth.phone') }}</label>
                        <input id="regPhone" name="phone" type="tel" placeholder="05xxxxxxxx" required>
                    </div>

                    <div class="form-group">
                        <label for="regPassword">{{ __('auth.password') }}</label>
                        <input id="regPassword" name="password" type="password" required>
                    </div>

                    <div class="form-group">
                        <label for="regPassword2">{{ __('auth.confirm_password') }}</label>
                        <input id="regPassword2" name="password_confirmation" type="password" required>
                    </div>

                    <div class="form-group">
                        <label for="regRole">{{ __('auth.account_type') }}</label>
                        <select id="regRole" name="role" required>
                            <option value="">{{ __('auth.select_account_type') }}</option>
                            <option value="investor">{{ __('auth.investor') }}</option>
                            <option value="borrower">{{ __('auth.borrower') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; margin-top:12px;">
                        {{ __('auth.register') }}
                    </button>

                    <div style="text-align:center; margin-top:8px; font-size:0.95rem;">
                        <a href="#" id="toLogin"
                            style="text-decoration:underline;">{{ __('auth.have_account') }}</a>
                    </div>
                </form>

            </div> <!-- نهاية auth-body -->

        </div> <!-- نهاية modal-content -->
    </div> <!-- نهاية modal -->


    <!-- Funding Modal -->
    <div class="modal fade" id="fundingModal" tabindex="-1" aria-labelledby="fundingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fundingModalLabel">نموذج طلب التمويل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>خطأ في النموذج:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form id="projectForm" method="post" action="{{ route('projects.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <!-- ========================== Title EN / AR ========================== -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title_en" class="form-label fw-bold">🏷️
                                    {{ __('auth.project_name_en') }}</label>
                                <input type="text"
                                    class="form-control form-control-lg @error('title_en') is-invalid @enderror"
                                    id="title_en" name="title_en" value="{{ old('title_en') }}" required>
                                @error('title_en')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="title_ar" class="form-label fw-bold">🏷️
                                    {{ __('auth.project_name_ar') }}</label>
                                <input type="text"
                                    class="form-control form-control-lg @error('title_ar') is-invalid @enderror"
                                    id="title_ar" name="title_ar" value="{{ old('title_ar') }}" required>
                                @error('title_ar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ========================== Summary EN / AR ========================== -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="summary_en" class="form-label fw-bold">🖋️
                                    {{ __('auth.summary_en') }}</label>
                                <textarea class="form-control @error('summary_en') is-invalid @enderror" id="summary_en" name="summary_en"
                                    rows="3" required>{{ old('summary_en') }}</textarea>
                                @error('summary_en')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="summary_ar" class="form-label fw-bold">🖋️
                                    {{ __('auth.summary_ar') }}</label>
                                <textarea class="form-control @error('summary_ar') is-invalid @enderror" id="summary_ar" name="summary_ar"
                                    rows="3" required>{{ old('summary_ar') }}</textarea>
                                @error('summary_ar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ========================== Description EN / AR ========================== -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="description_en" class="form-label fw-bold">📄
                                    {{ __('auth.description_en') }}</label>
                                <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en"
                                    name="description_en" rows="5">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="description_ar" class="form-label fw-bold">📄
                                    {{ __('auth.description_ar') }}</label>
                                <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar"
                                    name="description_ar" rows="5">{{ old('description_ar') }}</textarea>
                                @error('description_ar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ========================== Category + Funding Goal ========================== -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category_id"
                                    class="form-label fw-bold">{{ __('auth.sector_label') }}</label>
                                <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                    <option value="">{{ __('auth.select_sector') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="funding_goal"
                                    class="form-label fw-bold">{{ __('auth.funding_amount') }}</label>
                                <input type="number"
                                    class="form-control form-control-lg @error('funding_goal') is-invalid @enderror"
                                    id="funding_goal" name="funding_goal" min="1000"
                                    value="{{ old('funding_goal') }}" required>
                                @error('funding_goal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ========================== Term + Interest + Min Investment ========================== -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="term_months"
                                    class="form-label fw-bold">{{ __('auth.repayment_term') }}</label>
                                <select class="form-select form-select-lg @error('term_months') is-invalid @enderror"
                                    id="term_months" name="term_months" required>
                                    <option value="">{{ __('auth.select_term') }}</option>
                                    @for ($i = 6; $i <= 36; $i += 6)
                                        <option value="{{ $i }}"
                                            {{ old('term_months') == $i ? 'selected' : '' }}>{{ $i }}
                                            {{ __('auth.month') }}</option>
                                    @endfor
                                </select>
                                @error('term_months')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="interest_rate" class="form-label fw-bold">📊
                                    {{ __('auth.interest_rate') }}
                                    (%)</label>
                                <input type="number" step="0.01"
                                    class="form-control form-control-lg @error('interest_rate') is-invalid @enderror"
                                    id="interest_rate" name="interest_rate"
                                    placeholder="{{ __('auth.example') }}: 12" min="1" max="50"
                                    value="{{ old('interest_rate') }}" required>
                                @error('interest_rate')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="min_investment" class="form-label fw-bold">📊
                                    {{ __('auth.minimum_investment') }} ({{ __('auth.sar') }})</label>
                                <input type="number" step="0.01"
                                    class="form-control form-control-lg @error('min_investment') is-invalid @enderror"
                                    id="min_investment" name="min_investment" min="1000" max="5000000"
                                    value="{{ old('min_investment') }}" required>
                                @error('min_investment')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ========================== Image + Gallery ========================== -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="projectImage" class="form-label fw-bold">🖼️
                                    {{ __('auth.project_image') }}</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="projectImage" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="projectGallery" class="form-label fw-bold">🖼️
                                    {{ __('auth.project_gallery') }}</label>
                                <input type="file" class="form-control @error('gallery') is-invalid @enderror"
                                    id="projectGallery" name="gallery[]" multiple accept="image/*">
                                @error('gallery.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">
                            {{ __('auth.submit_funding_request') }}
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>


    <!-- Invest Modal -->
    <div id="investModal" class="modal-overlay">
        <div class="modal-box" style="max-width: 500px;">
            <div class="modal-header">
                <h3 style="font-weight: 800; font-size: 1.5rem; color: var(--gray-900);">
                    {{ __('auth.invest_project') }}</h3>
                <button class="close-modal" onclick="closeModal('investModal')"><i class="fas fa-times"></i></button>
            </div>
            <div
                style="background: var(--bg-light); padding: 1.25rem; border-radius: 1rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; border: 1px solid var(--border);">
                <div
                    style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--gray-500); font-weight: 600;">
                        {{ __('auth.project_name') }}</div>
                    <div id="modalProjectName" style="font-weight: 800; font-size: 1.1rem; color: var(--gray-900);">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('auth.investment_amount') }} <span id="modalMinInvest"
                        style="color:var(--primary)"></span> {{ __('auth.riyal') }})</label>
                <div style="position: relative;">
                    <input type="number" id="investAmountModal" class="form-control" oninput="calculateReturn()"
                        style="padding-left: 3rem; font-weight: bold; font-size: 1.2rem;">
                    <span
                        style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-weight: bold;">SAR</span>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('auth.expected_monthly_return') }}</label>
                <input type="text" id="expectedReturnModal" class="form-control" readonly
                    style="background: var(--gray-100); color: var(--primary-dark); font-weight: 800;">
            </div>
            <button onclick="redirectToStripe()" class="btn btn-primary" style="width: 100%; padding: 1.25rem;">
                <i class="fas fa-lock"></i> {{ __('auth.secure_payment') }}
            </button>
            <p style="text-align: center; font-size: 0.8rem; color: var(--gray-400); margin-top: 1rem;"><i
                    class="fas fa-shield-alt"></i> {{ __('auth.transactions_secure') }}</p>
        </div>
    </div>

    <!-- AI Image Generator Modal -->
    <div id="imageModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3
                    style="font-weight: 800; font-size: 1.5rem; color: #7c3aed; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-wand-magic-sparkles"></i> مصمم المشاريع الذكي
                </h3>
                <button class="close-modal" onclick="closeModal('imageModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="form-group">
                <label class="form-label">وصف فكرة المشروع</label>
                <textarea id="imagePrompt" class="form-control" rows="4"
                    placeholder="مثال: مقهى حديث واجهة زجاجية، إضاءة دافئة، نباتات داخلية، تصميم عصري..."></textarea>
                <p style="font-size: 0.85rem; color: var(--gray-500); margin-top: 0.5rem;">كلما كان الوصف دقيقاً، كانت
                    النتيجة أفضل.</p>
            </div>

            <div id="aiImagePreview"
                style="height: 280px; background: var(--bg-light); border-radius: 1rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px dashed var(--border); transition: 0.3s;">
                <div style="text-align: center; color: var(--gray-400);">
                    <i class="fas fa-image"
                        style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                    <span>ستظهر الصورة المولدة هنا</span>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button onclick="generateImage()" id="btnGenerate" class="btn btn-purple"
                    style="flex: 1; padding: 1rem;">
                    <i class="fas fa-bolt"></i> توليد الصورة
                </button>
                <button onclick="confirmImage()" id="btnConfirm" class="btn btn-primary"
                    style="flex: 1; display: none; padding: 1rem;">
                    <i class="fas fa-check"></i> اعتماد وإضافة للمشروع
                </button>
            </div>
        </div>
    </div>

    <div id="userTypeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUserTypeModal()" aria-label="{{ __('auth.close') }}">&times;</span>
            <div class="modal-header">
                <h2>{{ __('auth.welcome_platform') }}</h2>
            </div>
            <div class="modal-body">
                <p style="text-align: center; margin-bottom: 24px; font-size: 18px;">
                    {{ __('auth.how_use_platform') }}</p>
                <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                    <button class="btn btn-primary" onclick="selectUserType('investor')"
                        aria-label="{{ __('auth.i_am_investor') }}">{{ __('auth.i_am_investor') }}</button>
                    <button class="btn btn-outline" onclick="selectUserType('borrower')"
                        aria-label="{{ __('auth.i_am_borrower') }}">{{ __('auth.i_am_borrower') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top -->
    <div class="scroll-to-top" id="scrollTop" aria-label="العودة للأعلى">
        <i class="fas fa-arrow-up" aria-hidden="true"></i>
    </div>
    <!-- Chat Widget -->
    <div class="chat-widget">
        <div id="chatWindow" class="chat-window">
            <div
                style="background: linear-gradient(135deg, var(--secondary), #1e293b); color: white; padding: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div
                        style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 1rem;">المساعد المالي</div>
                        <div style="font-size: 0.75rem; opacity: 0.8; display: flex; align-items: center; gap: 4px;">
                            <span style="width: 6px; height: 6px; background: #4ade80; border-radius: 50%;"></span>
                            متصل (Gemini Pro)
                        </div>
                    </div>
                </div>
                <button onclick="toggleChat()"
                    style="background: none; border: none; color: white; cursor: pointer; opacity: 0.7; transition: 0.2s;"><i
                        class="fas fa-times fa-lg"></i></button>
            </div>
            <div id="chatMessages" class="chat-msgs">
                <div class="chat-msg msg-bot">{{ __('auth.assistant_welcome') }}</div>
            </div>
            <div
                style="padding: 1rem; background: white; border-top: 1px solid var(--border); display: flex; gap: 0.75rem;">
                <input type="text" id="chatInput"
                    style="flex: 1; border: 1px solid var(--border); border-radius: 0.75rem; padding: 0.75rem 1rem; font-size: 0.95rem;"
                    placeholder="{{ __('auth.type_question') }}" onkeydown="if(event.key==='Enter') sendMessage()">
                <button onclick="sendMessage()" class="btn btn-primary"
                    style="padding: 0 1.25rem; border-radius: 0.75rem;"><i
                        class="fas fa-paper-plane rtl:rotate-180"></i></button>
            </div>
        </div>
        <button onclick="toggleChat()" class="chat-toggle-btn">
            <i class="fas fa-headset"></i>
        </button>
    </div>
    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h3 class="mb-3">{{ __('auth.success') }}</h3>
                    <p class="text-muted fs-5"></p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-primary btn-lg px-5"
                        data-bs-dismiss="modal">{{ __('auth.ok') }}</button>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // وضع الرسالة من الـ session
                document.getElementById('successModal').querySelector('h3').innerText = 'نجاح!';
                document.getElementById('successModal').querySelector('p').innerText = '{{ session('success') }}';
            });
        </script>
    @endif
    @if (session('toast'))
        <script>
            const toast = document.createElement('div');
            toast.innerText = "{{ session('toast.message') }}";
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.background = '#2563eb';
            toast.style.color = '#fff';
            toast.style.padding = '10px 20px';
            toast.style.borderRadius = '8px';
            toast.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
            toast.style.zIndex = 9999;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        </script>
    @endif

    <script>
        function createProject() {
            // إعادة ضبط الحقول
            const form = document.getElementById('projectForm');
            form.reset();
            form.action = "{{ route('projects.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('fundingModalLabel').innerText = 'نموذج طلب التمويل';
            document.getElementById('submitBtn').innerText = 'إرسال طلب التمويل';
            // ضبط رسالة النجاح
            document.getElementById('successModal').querySelector('h3').innerText = 'تم إرسال مشروعك بنجاح!';
            document.getElementById('successModal').querySelector('p').innerText =
                'سيتم مراجعة طلبك خلال 48 ساعة، وستصلك إشعارات بالتحديثات.';
        }

        function editProject(button) {
            const form = document.getElementById('projectForm');
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const category_id = button.getAttribute('data-category_id');
            const funding_goal = button.getAttribute('data-funding_goal');
            const term_months = button.getAttribute('data-term_months');
            const interest_rate = button.getAttribute('data-interest_rate');
            const min_investment = button.getAttribute('data-min_investment');
            const summary = button.getAttribute('data-summary');
            const description = button.getAttribute('data-description');

            // ملء الحقول
            document.getElementById('title').value = title;
            document.getElementById('category_id').value = category_id;
            document.getElementById('funding_goal').value = funding_goal;
            document.getElementById('term_months').value = term_months;
            document.getElementById('interest_rate').value = interest_rate;
            document.getElementById('min_investment').value = min_investment;
            document.getElementById('summary').value = summary;
            document.getElementById('description').value = description;

            // تغيير action للفورم ليصبح PUT
            form.action = `/projects/${id}`;
            document.getElementById('formMethod').value = 'PUT';

            // تغيير نصوص المودال
            document.getElementById('fundingModalLabel').innerText = 'تعديل طلب التمويل';
            document.getElementById('submitBtn').innerText = 'تعديل المشروع';

            // ضبط رسالة النجاح الخاصة بالتعديل
            document.getElementById('successModal').querySelector('h3').innerText = 'تم تعديل المشروع بنجاح!';
            document.getElementById('successModal').querySelector('p').innerText =
                'تم تعديل المشروع بنجاح! بانتظار الموافقة.';
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationDropdown = document.querySelector('.icon-btn[data-bs-toggle="dropdown"]');

            if (notificationDropdown) {
                notificationDropdown.addEventListener('show.bs.dropdown', function() {
                    fetch("{{ route('notifications.markRead') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        }).then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // إزالة النقطة الحمراء مباشرة
                                const badge = notificationDropdown.querySelector('span');
                                if (badge) badge.remove();
                            }
                        });
                });
            }
        });
    </script>

    <script>
        function closeAuthModal() {
            const authModal = document.getElementById("authModal");
            if (!authModal) return;

            authModal.style.display = "none";
            authModal.setAttribute("aria-hidden", "true");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const authModal = document.getElementById("authModal");
            const modalContent = authModal.querySelector(".modal-content"); // ✅ هذا كان ناقص
            const loginForm = document.getElementById("loginForm");
            const registerForm = document.getElementById("registerForm");
            const tabLogin = document.getElementById("authTabLogin");
            const tabRegister = document.getElementById("authTabRegister");

            // إغلاق عند الضغط خارج المودال
            authModal.addEventListener("click", function(e) {
                if (!modalContent.contains(e.target)) {
                    closeAuthModal();
                }
            });

            function showTab(tab) {
                if (tab === "login") {
                    loginForm.style.display = "block";
                    registerForm.style.display = "none";
                    tabLogin.classList.add("active");
                    tabRegister.classList.remove("active");
                } else {
                    loginForm.style.display = "none";
                    registerForm.style.display = "block";
                    tabLogin.classList.remove("active");
                    tabRegister.classList.add("active");
                }
            }

            document.querySelectorAll(".open-auth").forEach(btn => {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();
                    const tab = this.dataset.tab || "register";
                    authModal.style.display = "flex";
                    authModal.setAttribute("aria-hidden", "false");
                    showTab(tab);
                });
            });

            tabLogin.addEventListener("click", () => showTab("login"));
            tabRegister.addEventListener("click", () => showTab("register"));

            document.getElementById("toLogin").addEventListener("click", e => {
                e.preventDefault();
                showTab("login");
            });
            document.getElementById("toRegister").addEventListener("click", e => {
                e.preventDefault();
                showTab("register");
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fills = document.querySelectorAll(".progress-bar-fill");
            fills.forEach(fill => {
                const percentage = fill.getAttribute("data-percentage");
                setTimeout(() => {
                    fill.style.width = percentage + "%";
                }, 100); // تأخير بسيط ليظهر الانيميشن
            });
        });
    </script>
    <script src="{{ asset('assets/front/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="importmap">
{
  "imports": {
    "@google/genai": "https://esm.sh/@google/genai@^1.33.0",
    "react": "https://esm.sh/react@^19.2.3",
    "react/": "https://esm.sh/react@^19.2.3/"
  }
}
</script>
    <!-- Scripts -->
    <script>
        let selectedProjectId = null;
        let minInvestment = 0;
        let annualRate = 0;

        function openInvestModal(button) {

            // قراءة بيانات المشروع من الزر
            selectedProjectId = button.dataset.id;
            minInvestment = parseFloat(button.dataset.min);
            annualRate = parseFloat(button.dataset.rate);
            const projectName = button.dataset.title;

            // اسم المشروع
            document.getElementById('modalProjectName').textContent = projectName;

            // كتابة الحد الأدنى في النص
            document.getElementById('modalMinInvest').textContent =
                minInvestment.toLocaleString();

            // كتابة الحد الأدنى داخل الحقل
            const input = document.getElementById('investAmountModal');
            input.min = minInvestment;
            input.value = minInvestment;

            // حساب أولي
            calculateReturn();

            // فتح المودال
            openModal('investModal');
        }

        function calculateReturn() {
            const input = document.getElementById('investAmountModal');
            let amount = parseFloat(input.value);

            // لو فاضي أو أقل من الحد الأدنى
            if (!amount || amount < minInvestment) {
                amount = minInvestment;
                input.value = minInvestment;
            }

            // حساب العائد الشهري
            const monthlyReturn = (amount * (annualRate / 100)) / 12;


            document.getElementById('expectedReturnModal').value =
                monthlyReturn.toFixed(2) + ' {{ __('auth.sar_month') }} ';
        }

        function openModal(id) {
            const modal = document.getElementById(id);
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('open'), 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('open');
            setTimeout(() => modal.style.display = 'none', 300);
        }
    </script>

    <script>
        function redirectToStripe() {

            // جلب المبلغ من نفس input في المودال
            let amount = parseFloat(
                document.getElementById("investAmountModal").value
            );

            // حماية إضافية
            if (!amount || amount < minInvestment) {
                alert("مبلغ الاستثمار يجب أن يكون على الأقل " + minInvestment + " ريال");
                return;
            }

            // 1️⃣ حفظ الاستثمار
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

                        // 2️⃣ تحويل إلى Stripe
                        window.location.href = "/checkout-stripe/" + response.investment_id;

                    } else {
                        alert("حدث خطأ أثناء حفظ الاستثمار، حاول مرة أخرى.");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("مشكلة في الاتصال بالسيرفر.");
                });
        }
    </script>
    <script>
        function toggleChat() {
            const chatWindow = document.getElementById('chatWindow');
            if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
                chatWindow.style.display = 'block';
            } else {
                chatWindow.style.display = 'none';
            }
        }

        let canSend = true;

        async function sendMessage() {
            if (!canSend) return;
            canSend = false;

            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            if (!message) {
                canSend = true;
                return;
            }

            const chatMessages = document.getElementById('chatMessages');
            chatMessages.innerHTML += `<div class="chat-msg msg-user">${message}</div>`;
            input.value = '';

            try {
                const response = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message
                    })
                });
                const data = await response.json();
                chatMessages.innerHTML += `<div class="chat-msg msg-bot">${data.response}</div>`;
            } catch (error) {
                chatMessages.innerHTML +=
                    `<div class="chat-msg msg-bot">تم الوصول للحد الأقصى من الطلبات، يرجى الانتظار قليلاً.</div>`;
            }

            chatMessages.scrollTop = chatMessages.scrollHeight;

            // السماح بإرسال رسالة جديدة بعد 2 ثانية
            setTimeout(() => {
                canSend = true;
            }, 2000);
        }
    </script>

</body>

</html>
