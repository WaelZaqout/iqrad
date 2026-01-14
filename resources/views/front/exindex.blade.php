@extends('front.master')
@section('content')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-inner">
                <div class="hero-illustration" aria-hidden="true">
                    <!-- Composite inline SVG: coin + small bar chart to suggest an active investment system -->
                    <svg width="320" height="240" viewBox="0 0 320 240" fill="none" xmlns="http://www.w3.org/2000/svg"
                        role="img" aria-hidden="true">
                        <defs>
                            <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#0ea5e9" />
                                <stop offset="1" stop-color="#1e3a8a" />
                            </linearGradient>
                            <linearGradient id="g2" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#10b981" stop-opacity="0.95" />
                                <stop offset="1" stop-color="#059669" />
                            </linearGradient>
                        </defs>
                        <rect x="0" y="0" width="320" height="240" rx="20" fill="url(#g1)" opacity="0.06" />
                        <!-- coin -->
                        <circle cx="220" cy="70" r="34" fill="url(#g2)" />
                        <text x="220" y="78" font-size="18" font-weight="700" text-anchor="middle"
                            fill="white">ريال</text>

                        <!-- small bar chart to the left of the coin -->
                        <g transform="translate(60,80)">
                            <rect x="0" y="36" width="20" height="24" rx="4" fill="#c7ddf8" />
                            <rect x="30" y="18" width="20" height="42" rx="4" fill="#7fbcf6" />
                            <rect x="60" y="6" width="20" height="54" rx="4" fill="#1e3a8a" />
                            <rect x="90" y="28" width="20" height="32" rx="4" fill="#0ea5e9" />
                        </g>
                        <!-- gentle hand stroke under elements to add context -->
                        <path d="M40 170c28-32 78-42 118-32 32 8 56 26 86 32" stroke="url(#g1)" stroke-width="8"
                            stroke-linecap="round" fill="none" opacity="0.9" />
                    </svg>
                </div>
                <div class="hero-content">
                    <h1>استثمر في مشاريع حقيقية وحقق أرباحًا آمنة</h1>
                    <p class="hero-lead">منصة تمويل رقمية تربط المستثمرين بالمشاريع الواعدة بطريقة آمنة وشفافة.</p>
                    <p class="hero-subtitle">منصة إقراض جماعي تربط المستثمرين بأصحاب المشاريع المبتكرة لخلق فرص نمو مشتركة
                    </p>
                    <p class="hero-target"><i class="fas fa-briefcase" aria-hidden="true"
                            style="margin-inline-end:8px;"></i>ابدأ رحلتك الاستثمارية مع منصة إقراضك وتمتّع بعوائد مجزية
                        وآمنة.</p>
                    <div class="hero-buttons">
                        <a href="investor.html" class="btn btn-hero btn-primary">ابدأ الاستثمار</a>

                        <button class="btn btn-hero btn-outline" data-bs-toggle="modal" data-bs-target="#fundingModal">
                            قدّم مشروعك
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Stats Banner -->
    <div class="stats-banner">
        <div class="stat-item">
            <div class="stat-icon projects">
                <i class="fas fa-briefcase" aria-hidden="true"></i>
            </div>
            <div class="stat-number" id="projectsCount">1,200+</div>
            <div class="stat-label">مشاريع ممولة</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon users">
                <i class="fas fa-users" aria-hidden="true"></i>
            </div>
            <div class="stat-number" id="investorsCount">10,000+</div>
            <div class="stat-label">مستثمر نشط</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon money">
                <i class="fas fa-dollar-sign" aria-hidden="true"></i>
            </div>
            <div class="stat-number" id="fundingCount">50M+</div>
            <div class="stat-label">ريال تم تمويلها</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon success">
                <i class="fas fa-star" aria-hidden="true"></i>
            </div>
            <div class="stat-number" id="successRate">95%</div>
            <div class="stat-label">معدل النجاح</div>
        </div>
    </div>
    <!-- Search and Filter Section -->
    <section class="search-section">
        <div class="search-controls">
            <div class="search-input">
                <i class="fas fa-search" aria-hidden="true"></i>
                <input type="text" placeholder="ابحث عن مشروع..." id="searchInput">
            </div>
            <div class="filters">
                <button class="filter-btn active" data-id="all" onclick="filterByCategory(this)">
                    <i class="fas fa-fire"></i> الكل
                </button>

                @foreach ($categories as $cat)
                    <button class="filter-btn" data-id="{{ $cat->id }}" onclick="filterByCategory(this)">
                        <i class="fas fa-seedling"></i> {{ $cat->name }}
                    </button>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Active Projects Section -->
    <div id="projectsContainer" class="project-cards-container">
        @foreach ($projects as $project)
            <!-- Project 1 -->
            <div class="project-card">
                @if (!empty($project->image))
                    <div class="project-thumbnail">
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                    </div>
                @else
                    <div class="project-thumbnail">
                        <div class="placeholder">
                            <i class="fas fa-briefcase fa-2x" aria-hidden="true"></i>
                            <div style="font-weight:800;margin-top:6px;color:var(--primary)">{{ $project->category->name }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="project-card-header">
                    <div class="project-info">

                        <h4 class="project-title"> {{ $project->title }}</h4>
                        @php
                            $status = $statusStyles[$project->status] ?? [];
                        @endphp

                        <span class="status-badge-small status-{{ $project->status ?? 'default' }}"
                            style="margin-left:auto">
                            <i class="{{ $status['icon'] ?? 'fas fa-info-circle' }}"></i>
                            {{ $status['label'] ?? ucfirst($project->status ?? 'حالة') }}
                        </span>
                    </div>


                </div>
                <p class="project-date"><i class="fas fa-calendar me-2"></i> تاريخ التقديم:
                    {{ $project->created_at->format('d M Y') }}</p>
                <div class="quick-info">
                    <span class="pill"><i class="fas fa-clock"></i> ({{ $project->category->name }}) نوع القطاع</span>
                    <span class="pill"><i class="fas fa-clock"></i> {{ $project->term_months }} شهر</span>
                    <span class="pill"><i class="fas fa-money-bill-wave"></i> الحد الأدنى
                        {{ number_format($project->min_investment) }} ر.</span>
                    <span class="pill"><i class="fas fa-money-bill-wave"></i> المبلغ المطلوب
                        {{ number_format($project->funding_goal, 0, '.', ',') }}
                        ريال</span>

                </div>


                @php
                    $percentage =
                        $project->funding_goal > 0
                            ? round(($project->funded_amount / $project->funding_goal) * 100)
                            : 0;
                @endphp

                <div class="progress-wrapper">
                    <div class="progress-header">
                        <span class="progress-percentage">نسبة التمويل: {{ $percentage }}%</span>
                        <span class="progress-amount">{{ number_format($project->funded_amount) }} من
                            {{ number_format($project->funding_goal) }} ريال</span>
                    </div>

                    <div class="progress-bar-container" role="progressbar" aria-valuenow="{{ $percentage }}"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar-fill" data-percentage="{{ $percentage }}"></div>
                    </div>
                </div>


                <div class="project-card-footer" style="display:flex;gap:8px;align-items:center;">
                    <a href="{{ route('details', $project->id) }}" class="btn btn-outline-secondary px-3 py-2"
                        style="flex:1; text-align:center;">
                        <i class="fas fa-eye me-1"></i> تفاصيل
                    </a>

                    <button
                        onclick="openInvestModal({{ $project->id }}, {!! json_encode($project->title) !!}, {{ $project->min_investment }}, {{ $project->interest_rate }})"
                        class="btn-cta" style="flex:1; justify-content:center;">
                        <i class="fas fa-coins" aria-hidden="true"></i> استثمر الآن
                    </button>


                </div>
            </div>
        @endforeach

    </div>
    <!-- Mid CTA Section -->
    <section class="mid-cta">
        <div class="mid-cta-illustration" aria-hidden="true">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="mid-cta-content">
            <h2 class="mid-cta-title">ابدأ الاستثمار الآن</h2>
            <p class="mid-cta-subtitle">انضم إلى آلاف المستثمرين الذين يحققون أرباحًا من خلال دعم المشاريع المبتكرة</p>
            <a href="#" class="btn btn-primary mid-cta-btn">ابدأ الاستثمار الآن</a>
        </div>
    </section>
    <!-- Trust Section -->
    <section class="trust-section">
        <div class="container">
            <div class="trust-logos">
                <img src="https://placehold.co/120x40/1e3a8a/ffffff?text=SSL+Secured" alt="SSL Secured"
                    class="trust-logo">
                <img src="https://placehold.co/120x40/0ea5e9/ffffff?text=Encrypted" alt="Encrypted" class="trust-logo">
                <img src="https://placehold.co/120x40/10b981/ffffff?text=KYC+Verified" alt="KYC Verified"
                    class="trust-logo">
                <img src="https://placehold.co/120x40/f59e0b/ffffff?text=AML+Compliant" alt="AML Compliant"
                    class="trust-logo">
            </div>
        </div>
    </section>
    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">آراء المستثمرين</h2>
                <p class="section-subtitle">hear what our investors say about their experience with Tamkeen</p>
            </div>
            <div class="testimonials-container">
                <div class="testimonials-slider" id="testimonialsSlider">
                    <div class="testimonial-slide">
                        <div class="testimonial-avatar" aria-hidden="true">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="testimonial-rating" aria-hidden="true">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-content">استثماري في منصة إقراضك كان أفضل قرار اتخذته هذا العام. العوائد
                            ممتازة والمنصة آمنة جداً.</p>
                        <div class="testimonial-author">سارة عبدالله</div>
                        <div class="testimonial-project">مستثمر منذ 2023</div>
                    </div>
                    <div class="testimonial-slide">
                        <div class="testimonial-avatar" aria-hidden="true">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="testimonial-rating" aria-hidden="true">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-content">تجربتي مع التمويل الجماعي عبر إقراضك كانت رائعة. الدعم الفني
                            ممتاز
                            والمشاريع مختارة بعناية.</p>
                        <div class="testimonial-author">محمد أحمد</div>
                        <div class="testimonial-project">مستثمر منذ 2022</div>
                    </div>
                    <div class="testimonial-slide">
                        <div class="testimonial-avatar" aria-hidden="true">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="testimonial-rating" aria-hidden="true">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-content">كصاحب مشروع، وجدت في إقراضك الشريك المثالي لتمويل فكرتي. العملية
                            كانت سلسة والدعم مستمر.</p>
                        <div class="testimonial-author">ليلى خالد</div>
                        <div class="testimonial-project">صاحبة مشروع "مطعم صحي"</div>
                    </div>
                </div>
                <div class="carousel-nav">
                    <div class="carousel-dot active" data-slide="0"></div>
                    <div class="carousel-dot" data-slide="1"></div>
                    <div class="carousel-dot" data-slide="2"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Education Section -->
    <section class="education-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">التوعية المالية</h2>
                <p class="section-subtitle">تعلم المزيد عن التمويل الجماعي والاستثمار الآمن</p>
            </div>
            <div class="education-grid">
                <div class="education-card">
                    <div class="education-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="education-title">ما هو التمويل الجماعي؟</h3>
                    <p class="education-content">التمويل الجماعي هو طريقة لجمع الأموال من عدد كبير من الأشخاص لدعم مشروع
                        أو فكرة مبتكرة عبر الإنترنت.</p>
                </div>
                <div class="education-card">
                    <div class="education-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="education-title">الأمان والحماية</h3>
                    <p class="education-content">نستخدم تقنيات تشفير متقدمة ونعمل مع شركات دفع عالمية لضمان أمان
                        معاملاتك المالية.</p>
                </div>

                <div class="education-card">
                    <div class="education-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="education-title">إدارة المخاطر</h3>
                    <p class="education-content">تعلم كيفية تنويع استثماراتك وتقليل المخاطر لتحقيق أفضل العوائد على
                        المدى الطويل.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">الأسئلة الشائعة</h2>
                <p class="section-subtitle">إجابات على أكثر الأسئلة شيوعاً حول منصة إقراضك</p>
            </div>
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        كيف أبدأ الاستثمار في المشاريع؟
                        <i class="fas fa-chevron-down faq-toggle" aria-hidden="true"></i>
                    </div>
                    <div class="faq-answer">
                        للبدء في الاستثمار، ستحتاج أولاً إلى إنشاء حساب على منصة إقراضك والتحقق من هويتك. بعد ذلك، يمكنك
                        تصفح المشاريع المتاحة واختيار المشروع الذي يناسب معاييرك الاستثمارية. قم بتحديد المبلغ الذي ترغب
                        في استثماره واتبع خطوات الدفع الآمنة عبر Stripe.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        هل الأرباح مضمونة في منصة الإقراض الجماعي؟
                        <i class="fas fa-chevron-down faq-toggle" aria-hidden="true"></i>
                    </div>
                    <div class="faq-answer">
                        بينما نعمل على تقييم دقيق لجميع المشاريع قبل عرضها على المنصة، إلا أن الاستثمار ينطوي على مخاطر.
                        نوفر تقييمات مخاطر شفافة لكل مشروع وننصح المستثمرين بتنويع استثماراتهم لتقليل المخاطر. ومع ذلك،
                        لا يمكن ضمان الأرباح بنسبة 100%.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        كيف تتم عملية السداد للمستثمرين؟
                        <i class="fas fa-chevron-down faq-toggle" aria-hidden="true"></i>
                    </div>
                    <div class="faq-answer">
                        يتم سداد الأقساط تلقائياً من حساب المقترض إلى محفظة المستثمر وفقاً لجدول السداد المتفق عليه.
                        يمكن للمستثمرين سحب أرباحهم في أي وقت بعد تراكم مبلغ معين في محفظتهم، أو الاحتفاظ بها للاستثمار
                        في مشاريع جديدة.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        ما هي شروط تقديم مشروع للتمويل؟
                        <i class="fas fa-chevron-down faq-toggle" aria-hidden="true"></i>
                    </div>
                    <div class="faq-answer">
                        لتقديم مشروع للتمويل، يجب أن يكون لديك خطة عمل واضحة، سجل تجاري ساري المفعول، وضمانات كافية. كما
                        نطلب وثائق مالية وشرح مفصل عن المشروع والغرض من التمويل. يخضع كل مشروع لتقييم دقيق من قبل فريقنا
                        قبل الموافقة عليه.
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bottom CTA Section -->
    <section class="bottom-cta">
        <div class="container">
            <h2 class="bottom-cta-title">هل لديك فكرة مشروع؟</h2>
            <p class="bottom-cta-subtitle">ابدأ الآن بتقديم طلب تمويل لمشروعك.</p>
            <a href="#" class="btn btn-primary bottom-cta-btn" id="applyProjectBtn2">قدّم مشروعك الآن</a>
        </div>
    </section>

    <!-- Payment Modal -->
    <div id="investModal" class="modern-modal">
        <div class="modern-modal-content">
            <span class="close-btn" onclick="closeInvestModal()">&times;</span>

            <h2 class="modal-title">استثمار في المشروع</h2>

            <div class="modal-project-name d-flex align-items-center mb-4">
                <i class="fas fa-project-diagram me-3 text-primary fs-2"></i>
                <div>
                    <h5 class="mb-1 text-muted">اسم المشروع:</h5>
                    <h4 id="projectName" class="mb-0 text-primary fw-bold"
                        style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);"></h4>
                </div>
            </div>

            <div class="form-group">
                <label>مبلغ الاستثمار (الحد الأدنى <span id="minAmount"></span> ريال)</label>
                <input type="number" id="investAmount" min="1000" placeholder="1000" value="1000"
                    oninput="calculateReturn()">
            </div>

            <div class="form-group">
                <label>العائد المتوقع</label>
                <input type="text" id="expectedReturn" readonly>
            </div>

            <button class="primary-btn" onclick="redirectToStripe()">إكمال الدفع</button>
        </div>
    </div>

    <!-- Funding Modal -->
    <div class="modal fade" id="fundingModal" tabindex="-1" aria-labelledby="fundingModalLabel" aria-hidden="true">
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
                        <!-- title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">🏷️ اسم المشروع</label>
                            <input type="text"
                                class="form-control form-control-lg @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- category + funding_goal -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-bold">🏭 نوع القطاع</label>
                                <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                    <option value="">اختر القطاع</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="funding_goal" class="form-label fw-bold">💰 المبلغ المطلوب (ريال)</label>
                                <input type="number"
                                    class="form-control form-control-lg @error('funding_goal') is-invalid @enderror"
                                    id="funding_goal" name="funding_goal" min="1000"
                                    value="{{ old('funding_goal') }}" required>
                                @error('funding_goal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- term + interest -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="term_months" class="form-label fw-bold">⏳ مدة السداد (أشهر)</label>
                                <select class="form-select form-select-lg @error('term_months') is-invalid @enderror"
                                    id="term_months" name="term_months" required>
                                    <option value="">اختر المدة</option>
                                    <option value="6" {{ old('term_months') == 6 ? 'selected' : '' }}>6 أشهر</option>
                                    <option value="12" {{ old('term_months') == 12 ? 'selected' : '' }}>12 شهر
                                    </option>
                                    <option value="18" {{ old('term_months') == 18 ? 'selected' : '' }}>18 شهر
                                    </option>
                                    <option value="24" {{ old('term_months') == 24 ? 'selected' : '' }}>24 شهر
                                    </option>
                                    <option value="36" {{ old('term_months') == 36 ? 'selected' : '' }}>36 شهر
                                    </option>
                                </select>
                                @error('term_months')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label for="interest_rate" class="form-label fw-bold">📊 نسبة الفائدة (%)</label>
                                <input type="number" step="0.01"
                                    class="form-control form-control-lg @error('interest_rate') is-invalid @enderror"
                                    id="interest_rate" name="interest_rate" placeholder="مثال: 12" min="1"
                                    max="50" value="{{ old('interest_rate') }}" required>
                                @error('interest_rate')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="min_investment" class="form-label fw-bold">📊 الحد الادنى للاستثمار
                                    (ريال)</label>
                                <input type="number" step="0.01"
                                    class="form-control form-control-lg @error('min_investment') is-invalid @enderror"
                                    id="min_investment" name="min_investment" placeholder="مثال: 12" min="1000"
                                    max="5000000" value="{{ old('min_investment') }}" required>
                                @error('min_investment')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <!-- summary -->
                        <div class="mb-4">
                            <label for="summary" class="form-label fw-bold">🖋️ وصف مختصر للمشروع</label>
                            <textarea class="form-control form-control-lg @error('summary') is-invalid @enderror" id="summary" name="summary"
                                rows="3" required>{{ old('summary') }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">📄 وصف تفصيلي (اختياري)</label>
                            <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" id="description"
                                name="description" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label for="projectImage" class="form-label fw-bold">🖼️ رفع صورة المشروع (اختياري)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="projectImage" name="image" accept="image/jpeg,image/png">
                            <div class="form-text">صورة رئيسية (أنواع: JPEG, PNG). الحد الأقصى للحجم: 3MB.</div>
                            <div id="projectImagePreview" class="image-preview mt-2" aria-hidden="true"></div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gallery -->
                        <div class="mb-4">
                            <label for="projectGallery" class="form-label fw-bold">🖼️ رفع صور المشروع (اختياري)</label>
                            <input type="file" class="form-control @error('gallery') is-invalid @enderror"
                                id="projectGallery" name="gallery[]" multiple accept="image/jpeg,image/png">
                            <div class="form-text">يمكنك رفع عدة صور. كل صورة بحد أقصى 3MB (أنواع: JPEG, PNG).</div>
                            <div id="galleryPreview" class="gallery-preview mt-2" aria-hidden="true"></div>
                            @error('gallery.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">إرسال طلب
                            التمويل</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h3 class="mb-3">نجاح!</h3>
                    <p class="text-muted fs-5"></p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-primary btn-lg px-5" data-bs-dismiss="modal">حسنًا</button>
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



    <script>
        function createProject() {
            // إعادة ضبط الحقول
            const form = document.getElementById('projectForm');
            form.reset();
            form.action = "{{ route('projects.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('fundingModalLabel').innerText = 'نموذج طلب التمويل';
            document.getElementById('submitBtn').innerText = 'إرسال طلب التمويل';
            // focus first field for accessibility
            const titleEl = document.getElementById('title');
            if (titleEl) titleEl.focus();
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

            // focus title for quick edit
            const titleEl2 = document.getElementById('title');
            if (titleEl2) titleEl2.focus();

            // ضبط رسالة النجاح الخاصة بالتعديل
            document.getElementById('successModal').querySelector('h3').innerText = 'تم تعديل المشروع بنجاح!';
            document.getElementById('successModal').querySelector('p').innerText =
                'تم تعديل المشروع بنجاح! بانتظار الموافقة.';
        }

        // Image + gallery previews and lightweight client-side validation
        document.addEventListener('DOMContentLoaded', function() {
            const projectImage = document.getElementById('projectImage');
            const galleryInput = document.getElementById('projectGallery');
            const imagePreview = document.getElementById('projectImagePreview');
            const galleryPreview = document.getElementById('galleryPreview');
            const MAX_BYTES = 3 * 1024 * 1024; // 3MB

            // Handle decimal inputs to accept comma as decimal separator
            const decimalInputs = ['interest_rate', 'min_investment'];
            decimalInputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', function(e) {
                        // Replace comma with dot for decimal separator
                        let value = e.target.value;
                        if (value.includes(',')) {
                            e.target.value = value.replace(',', '.');
                        }
                    });
                }
            });

            // Handle number inputs to accept comma as thousands separator
            const numberInputs = ['funding_goal', 'min_investment'];
            numberInputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', function(e) {
                        // Remove commas for thousands separator
                        let value = e.target.value.replace(/,/g, '');
                        e.target.value = value;
                    });
                }
            });

            function clearPreview(container) {
                while (container && container.firstChild) container.removeChild(container.firstChild);
            }

            function createThumb(file) {
                const img = document.createElement('img');
                img.alt = file.name;
                img.title = file.name;
                img.loading = 'lazy';
                const url = URL.createObjectURL(file);
                img.src = url;
                img.addEventListener('load', () => URL.revokeObjectURL(url));
                return img;
            }

            if (projectImage) {
                projectImage.addEventListener('change', function(e) {
                    clearPreview(imagePreview);
                    const f = e.target.files && e.target.files[0];
                    if (!f) return;
                    if (f.size > MAX_BYTES) {
                        alert('حجم الصورة أكبر من 3MB، الرجاء اختيار ملف أصغر.');
                        projectImage.value = '';
                        return;
                    }
                    imagePreview.appendChild(createThumb(f));
                });
            }

            if (galleryInput) {
                galleryInput.addEventListener('change', function(e) {
                    clearPreview(galleryPreview);
                    const files = Array.from(e.target.files || []);
                    files.forEach(f => {
                        if (f.size > MAX_BYTES) {
                            const warn = document.createElement('div');
                            warn.className = 'form-text text-danger';
                            warn.innerText = `الملف ${f.name} أكبر من 3MB وتخطى العرض.`;
                            galleryPreview.appendChild(warn);
                            return;
                        }
                        galleryPreview.appendChild(createThumb(f));
                    });
                });
            }
        });
    </script>

    <script>
        let selectedProjectId = null;
        let projectReturn = 0;
        let minInvestment = 0;

        function openInvestModal(id, name, minAmount, annualReturn) {
            selectedProjectId = id;
            projectReturn = annualReturn;
            minInvestment = minAmount;

            document.getElementById("projectName").textContent = name;
            document.getElementById("minAmount").textContent = minAmount;

            document.getElementById("investAmount").min = minAmount;
            document.getElementById("investAmount").value = minAmount;

            calculateReturn();

            document.getElementById("investModal").style.display = "flex";
        }

        function closeInvestModal() {
            document.getElementById("investModal").style.display = "none";
        }

        function calculateReturn() {
            let amount = document.getElementById("investAmount").value;
            if (amount < minInvestment) {
                document.getElementById("investAmount").value = minInvestment;
                amount = minInvestment;
            }
            let annual = (amount * projectReturn) / 100;
            let monthly = annual / 12;

            document.getElementById("expectedReturn").value =
                monthly.toFixed(2) + " ريال شهرياً";
        }

        function redirectToStripe() {
            let amount = document.getElementById("investAmount").value;

            if (amount < minInvestment) {
                alert("مبلغ الاستثمار يجب أن يكون على الأقل " + minInvestment + " ريال");
                return;
            }

            // 1️⃣ تسجيل الاستثمار في قاعدة البيانات قبل الدفع
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

                        let investmentId = response.investment_id;

                        // 2️⃣ تحويل المستخدم لصفحة الدفع في Stripe
                        window.location.href = "/checkout-stripe/" + investmentId;

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
        // safe attach if .btn-invest exists
        var btnInvest = document.querySelector('.btn-invest');
        if (btnInvest) {
            btnInvest.addEventListener('click', function(e) {
                e.target.disabled = true;
            });
        }

        // initialize progress bars from data-percentage and apply gradient
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.progress-bar-fill').forEach(function(el) {
                var pct = parseInt(el.getAttribute('data-percentage')) || 0;
                pct = Math.max(0, Math.min(100, pct));
                // small delay so CSS transition is visible
                setTimeout(function() {
                    el.style.width = pct + '%';
                }, 100);

                // adjust gradient based on percentage
                if (pct < 40) {
                    el.style.background = 'linear-gradient(90deg,#ff6b6b,#ff8a3d)';
                } else if (pct < 80) {
                    el.style.background = 'linear-gradient(90deg,#ff8a3d,#ffd76b)';
                } else {
                    el.style.background = 'linear-gradient(90deg,#2ea44f,#7bd389)';
                }
            });
        });
    </script>

    <script>
        function filterByCategory(button) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const categoryId = button.dataset.id;

            // Use absolute base URL to avoid issues when app is served from a subfolder
            const base = "{{ url('') }}";

            let url = categoryId === 'all' ?
                `${base}/filter-projects` :
                `${base}/filter-projects/${categoryId}`;

            console.log('Filtering by categoryId=', categoryId, ' -> URL=', url);

            fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    console.log('Response status:', res.status);
                    return res.json();
                })
                .then(projects => {
                    if (!projects || (Array.isArray(projects) && projects.length === 0)) {
                        console.log('No projects returned for category', categoryId, projects);
                    }
                    renderProjectsFromServer(projects);
                })
                .catch(err => {
                    console.error('Error fetching filtered projects:', err);
                    alert('تعذر جلب المشاريع المصفاة. افتح Console للمزيد من التفاصيل.');
                });
        }


        function renderProjectsFromServer(projects) {
            const container = document.getElementById('projectsContainer');
            if (!container) {
                console.error('renderProjects: #projectsContainer not found in DOM');
                alert('خطأ داخلي: عنصر عرض المشاريع غير موجود. تحقق من أن الصفحة تحتوي على قسم المشاريع.');
                return;
            }
            container.innerHTML = '';

            if (projects.length === 0) {
                container.innerHTML = '<p class="text-center">لا توجد مشاريع</p>';
                return;
            }

            projects.forEach(project => {
                const imageHtml = project.image ?
                    `<div class="project-thumbnail"><img src="${project.image}" alt="${project.title}" loading="lazy"></div>` :
                    `<div class="project-thumbnail" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display:flex; align-items:center; justify-content:center; height:160px;"><i class="fas fa-briefcase" style="font-size:40px; color:white;"></i></div>`;

                const formatDate = (dateString) => {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('ar-SA', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                };

                const formatNumber = (num) => {
                    if (num === null || typeof num === 'undefined') return '';
                    return new Intl.NumberFormat('ar-SA').format(num);
                };

                const safeTitle = (project.title || '').replace(/'/g, "\\'");

                const cardHtml = `
                    <div class="project-card">
                        ${imageHtml}
                        <div class="project-card-header">
                            <span class="status-badge-small status-${project.status || 'default'}">${project.status_label || (project.status || '')}</span>
                            <div class="project-info">
                                <h3 style="margin: 12px 0 8px; font-weight: 600; color: #333;">${project.title || ''}</h3>
                                <p class="project-summary" style="margin: 0; color: #666; font-size: 14px;">${project.summary || ''}</p>
                            </div>
                        </div>
                        <p class="project-date" style="margin: 12px 0; font-size: 13px; color: #999;"><i class="fas fa-calendar me-2"></i> تاريخ التقديم: ${formatDate(project.created_at)}</p>
                        <div class="quick-info" style="display: flex; flex-wrap: wrap; gap: 8px; margin: 12px 0;">
                            <span class="pill" style="background: #f0f0f0; padding: 6px 12px; border-radius: 4px; font-size: 12px; color: #555;"><i class="fas fa-tag"></i> ${project.category ? project.category.name : ''}</span>
                            <span class="pill" style="background: #f0f0f0; padding: 6px 12px; border-radius: 4px; font-size: 12px; color: #555;"><i class="fas fa-clock"></i> ${project.term_months || ''} شهر</span>
                            <span class="pill" style="background: #f0f0f0; padding: 6px 12px; border-radius: 4px; font-size: 12px; color: #555;"><i class="fas fa-money-bill-wave"></i> الحد الأدنى ${formatNumber(project.min_investment)} ر.</span>
                            <span class="pill" style="background: #f0f0f0; padding: 6px 12px; border-radius: 4px; font-size: 12px; color: #555;"><i class="fas fa-money-bill-wave"></i> المبلغ ${formatNumber(project.funding_goal)} ر.</span>
                        </div>
                        <div class="progress-wrapper" style="margin: 16px 0;">
                            <div class="progress-bar-container" role="progressbar" aria-valuenow="${project.percentage || 0}" aria-valuemin="0" aria-valuemax="100" style="height: 8px; background: #e0e0e0; border-radius: 4px; overflow: hidden;">
                                <div class="progress-bar-fill" style="height: 100%; width: 0%; background: linear-gradient(90deg,#667eea,#764ba2); transition: width 0.3s ease;" data-percentage="${project.percentage || 0}"></div>
                            </div>
                            <small style="margin-top:8px; display:block; color:#666; font-size: 12px;">${project.percentage || 0}% تم تمويله</small>
                        </div>
                        <div class="project-card-footer" style="display: flex; gap: 8px; margin-top: 16px; align-items:center;">
                            <a href="/details/${project.id}" class="btn btn-outline-secondary" style="flex: 1; padding: 8px 12px; font-size: 14px; border: 1px solid #ddd; background: white; color: #333; text-decoration: none; border-radius: 4px; text-align: center; cursor: pointer;">اعرف أكثر</a>
                            <button onclick="openInvestModal(${project.id}, '${safeTitle}', ${project.min_investment}, ${project.interest_rate})" class="btn-cta btn-invest" style="flex: 1; padding: 8px 12px; font-size: 14px;"> <i class="fas fa-coins"></i> استثمر الآن</button>
                        </div>
                    </div>
                `;

                container.innerHTML += cardHtml;
            });
        }
    </script>
@endsection
