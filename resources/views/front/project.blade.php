<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة عرض المشاريع</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/dashboard.css') }}">
    @if (App::getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('assets/front/css/en.css') }}">
    @endif

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
    <!-- Main Content -->
    <main class="container" style="padding-top: 2rem; padding-bottom: 2rem; flex: 1;">

        <!-- Intro -->
        <div style="margin-bottom: 2.5rem;">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <h1 style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.5rem;">
                        {{ __('auth.Investment_Panel') }} </h1>
                    <p style="color: var(--text-light);">{{ __('auth.promising_projects') }}</p>
                </div>
                <button onclick="openImageModal()" class="btn btn-purple">
                    <i class="fas fa-magic"></i> {{ __('auth.new_project') }} (AI)
                </button>
            </div>

            <!-- Filters -->
            <div class="flex gap-2" style="overflow-x: auto; padding-bottom: 0.5rem;">
                <button onclick="filterProjects('all')" class="filter-btn active"
                    id="btn-all">{{ __('auth.all') }} </button>
                <button onclick="filterProjects('active')" class="filter-btn"
                    id="btn-active">{{ __('auth.active_now') }}</button>
                <button onclick="filterProjects('completed')" class="filter-btn"
                    id="btn-completed">{{ __('auth.completed') }}</button>
            </div>
        </div>

        <!-- Projects Grid (Static HTML Cards) -->
        <!-- Projects Grid -->
        <div id="projects-container" class="project-cards-container">
            <!-- Project 1 -->
            @include('front.partials.projects-cards', ['projects' => $projects])

        </div>

    </main>

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


    <!-- Image Generator Modal -->
    <div id="image-modal" class="modal-overlay">
        <div class="modal-content">
            <div
                style="padding: 1.25rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-magic" style="color: #9333ea;"></i> مصمم المشاريع الذكي
                </h3>
                <button onclick="closeImageModal()"
                    style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #9ca3af;"><i
                        class="fas fa-times"></i></button>
            </div>

            <div style="padding: 1.5rem;">
                <label style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 0.5rem;">وصف صورة
                    المشروع</label>
                <textarea id="image-prompt" placeholder="مثال: مصنع حديث للطاقة الشمسية في الصحراء..."></textarea>

                <div id="generated-image-container" class="hidden" style="margin-bottom: 1.5rem;">
                    <img id="generated-image-preview" src=""
                        style="width: 100%; height: 200px; object-fit: cover; border-radius: 0.75rem; border: 1px solid var(--border);">
                </div>

                <div id="image-loading" class="hidden"
                    style="height: 200px; background: var(--bg-light); border-radius: 0.75rem; display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 1.5rem; color: #9333ea;">
                    <i class="fas fa-circle-notch fa-spin" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    <span style="font-weight: bold; font-size: 0.9rem;">جاري التصميم بواسطة Gemini...</span>
                </div>

                <div class="flex gap-2">
                    <button id="btn-generate" onclick="generateImage()" class="btn btn-purple" style="width: 100%;">
                        <i class="fas fa-wand-magic-sparkles"></i> توليد الصورة
                    </button>
                    <button id="btn-confirm" onclick="confirmImage()" class="btn btn-primary hidden"
                        style="width: 100%;">
                        <i class="fas fa-check"></i> اعتماد وإضافة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/front/js/script.js') }}"></script>
    <script src="{{ asset('assets/front/js/project-form.js') }}"></script>
    <script src="{{ asset('assets/front/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/front/js/auth-modal.js') }}"></script>
    <script src="{{ asset('assets/front/js/stripe.js') }}"></script>
    <script src="{{ asset('assets/front/js/chat.js') }}"></script>
    <script src="{{ asset('assets/front/js/faq.js') }}"></script>
    <script src="{{ asset('assets/front/js/profit-chart.js') }}"></script>
    <script>
        function filterProjects(status) {
            // Active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById('btn-' + status).classList.add('active');

            // Fetch projects
            fetch(`{{ route('projects.filter') }}?status=${status}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('projects-container').innerHTML = html;
                });
        }
    </script>
</body>

</html>
