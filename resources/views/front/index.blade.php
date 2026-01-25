@extends('front.master')
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-inner">
            <div class="hero-content">
                <div
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; background: rgba(255,255,255,0.08); border-radius: 30px; font-size: 0.9rem; margin-bottom: 1.5rem; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(4px);">
                    <span
                        style="width: 8px; height: 8px; background: var(--primary); border-radius: 50%; box-shadow: 0 0 10px var(--primary);"></span>
                    {{ __('auth.hero_platform_badge') }}
                </div>
                <h1>{!! __('auth.hero_title') !!}</h1>

                <p class="hero-lead">{{ __('auth.description') }}</p>
                <div class="hero-buttons">
                    @guest
                        {{-- مستخدم غير مسجل دخول --}}
                        <button data-tab="login" class="invest-btn open-auth">
                            <i class="fas fa-coins"></i>
                            {{ __('auth.login_to_invest') }}
                        </button>
                    @else
                        @can('make_investment')
                            <button onclick="document.getElementById('projects-section').scrollIntoView({behavior: 'smooth'})"
                                class="btn btn-primary">
                                <i class="fas fa-rocket"></i> {{ __('auth.start_investing') }}
                            </button>
                        @endcan
                        @can('add_project')
                            <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#fundingModal">
                                <i class="fas fa-plus-circle me-2"></i> {{ __('auth.submit_project') }}
                            </button>
                        @endcan

                        <button onclick="openModal('imageModal')" class="btn btn-purple">
                            <i class="fas fa-magic"></i> {{ __('auth.ai_intelligence') }}
                        </button>
                    @endguest

                </div>
            </div>
            <div class="hero-illustration">
                <!-- SVG Provided in Prompt -->
                <svg width="420" height="320" viewBox="0 0 320 240" fill="none" xmlns="http://www.w3.org/2000/svg"
                    role="img" aria-hidden="true">
                    <defs>
                        <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#3b82f6" />
                            <stop offset="1" stop-color="#1e3a8a" />
                        </linearGradient>
                        <linearGradient id="g2" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#10b981" stop-opacity="0.95" />
                            <stop offset="1" stop-color="#059669" />
                        </linearGradient>
                        <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                            <feGaussianBlur stdDeviation="10" result="blur" />
                            <feComposite in="SourceGraphic" in2="blur" operator="over" />
                        </filter>
                    </defs>
                    <rect x="0" y="0" width="320" height="240" rx="20" fill="url(#g1)" opacity="0.08" />
                    <circle cx="220" cy="70" r="34" fill="url(#g2)" filter="url(#glow)" />
                    <text x="220" y="78" font-size="18" font-weight="800" text-anchor="middle" fill="white"
                        font-family="Tajawal">{{ __('auth.sar') }}</text>
                    <g transform="translate(60,80)">
                        <rect x="0" y="36" width="20" height="24" rx="4" fill="#93c5fd" />
                        <rect x="30" y="18" width="20" height="42" rx="4" fill="#60a5fa" />
                        <rect x="60" y="6" width="20" height="54" rx="4" fill="#2563eb" />
                        <rect x="90" y="28" width="20" height="32" rx="4" fill="#3b82f6" />
                    </g>
                    <path d="M40 170c28-32 78-42 118-32 32 8 56 26 86 32" stroke="url(#g1)" stroke-width="8"
                        stroke-linecap="round" fill="none" opacity="0.9" />
                </svg>
            </div>
        </div>
    </section>

    <!-- Stats Banner -->
    <div class="container">
        <div class="stats-banner">
            <div class="stat-item">
                <i class="fas fa-briefcase"></i>
                <div class="stat-number">1,200+</div>
                <div class="stat-label">{{ __('auth.funded_projects') }}</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-users"></i>
                <div class="stat-number">10K+</div>
                <div class="stat-label">{{ __('auth.active_investors') }}</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-coins"></i>
                <div class="stat-number">50M+</div>
                <div class="stat-label">{{ __('auth.funded_amount') }}</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-star"></i>
                <div class="stat-number">95%</div>
                <div class="stat-label">{{ __('auth.success_rate') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container" id="projects-section">
        <!-- Search & Filter -->
        <div class="search-section">
            <div class="filters">
                <button onclick="filterProjects('all')" class="filter-btn active" id="btn-all">
                    <i class="fas fa-layer-group"></i> {{ __('auth.all') }}
                </button>
                <button onclick="filterProjects('active')" class="filter-btn" id="btn-active">
                    <i class="fas fa-bolt"></i> {{ __('auth.active') }}
                </button>
                <button onclick="filterProjects('completed')" class="filter-btn" id="btn-completed">
                    <i class="fas fa-check-circle"></i> {{ __('auth.completed') }}
                </button>
            </div>
        </div>
        <!-- Projects Grid -->
        <div id="projects-container" class="project-cards-container">
            @forelse ($projects as $project)
                <div class="project-card">
                    <div class="project-thumbnail">
                        @if (!empty($project->image))
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                        @else
                            <div class="placeholder">
                                <i class="fas fa-briefcase fa-2x"></i>
                                <div style="font-weight:800;margin-top:6px;color:var(--primary)">
                                    {{ $project->category->name }}
                                </div>
                            </div>
                        @endif

                        <span class="status-badge {{ $project->status_badge['class'] }}">
                            {{ $project->status_badge['label'] }}
                        </span>
                    </div>

                    <div class="project-header">
                        <h4 class="project-title">{{ $project->title }}</h4>
                        <div class="project-purpose">
                            <i class="fas fa-tag text-primary"></i>
                            {{ $project->category->name }}
                        </div>
                    </div>

                    <div class="project-details">
                        <div class="project-info">
                            <div class="info-item">
                                <div class="info-label">{{ __('auth.interest_rate') }}</div>
                                <div class="info-value" style="color: var(--primary)">
                                    {{ $project->interest_rate }}%
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">{{ __('auth.duration') }}</div>
                                <div class="info-value">
                                    {{ $project->term_months }} {{ __('auth.month') }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">{{ __('auth.min_investment') }}</div>
                                <div class="info-value">{{ $project->min_investment }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">{{ __('auth.funding_goal') }}</div>
                                <div class="info-value">{{ $project->funding_goal }}</div>
                            </div>
                        </div>


                        <div class="progress-container">
                            <div class="progress-header">
                                <span>{{ __('auth.collected') }}
                                    {{ $project->funded_amount > 0 ? round($project->percentage) : 0 }}%</span>
                                <span>
                                    {{ number_format($project->funded_amount, 0) }} /
                                    {{ number_format($project->funding_goal, 0) }}
                                    {{ __('auth.sar') }}
                                </span>
                            </div>

                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $project->percentage }}%"></div>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('details', $project->id) }}" class="details-btn">
                                <i class="far fa-eye"></i> {{ __('auth.details') }}
                            </a>

                            @guest
                                <button class="invest-btn open-auth" data-tab="login">
                                    <i class="fas fa-coins"></i>
                                    {{ __('auth.login_to_invest') }}
                                </button>
                            @else
                                @can('make_investment')
                                    @if ($project->percentage >= 100 || $project->status === 'completed')
                                        <button class="invest-btn completed" disabled>
                                            <i class="fas fa-check-circle"></i>
                                            {{ __('auth.completed') }}
                                        </button>
                                    @else
                                        <button class="invest-btn" onclick="openInvestModal(this)" data-id="{{ $project->id }}"
                                            data-title="{{ $project->title }}" data-min="{{ $project->min_investment }}"
                                            data-rate="{{ $project->interest_rate }}">
                                            <i class="fas fa-coins"></i>
                                            {{ __('auth.invest_now') }}
                                        </button>
                                    @endif
                                @endcan
                            @endguest
                        </div>

                    </div>
                </div>
            @empty
                <div class="no-projects">
                    <i class="fas fa-folder-open"></i>
                    <h4>{{ __('auth.no_projects_found') }}</h4>
                    <p>{{ __('auth.try_other_filters') }}</p>
                </div>
            @endforelse

            <div class="load-more-wrapper">
                <a href="{{ route('project') }}" class="load-more-btn">
                    <i class="fas fa-layer-group"></i>
                    {{ __('auth.more_projects') }}
                </a>
            </div>
        </div>


    </main>

    <!-- Mid CTA -->
    <section
        style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 6rem 0; text-align: center; margin-bottom: 5rem; position: relative; overflow: hidden;">
        <div
            style="position: absolute; top: -50%; left: -10%; width: 120%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%); pointer-events: none;">
        </div>
        <div class="container" style="position: relative; z-index: 2;">
            <i class="fas fa-chart-line"
                style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.9; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));"></i>
            <h2 style="font-size: 2.5rem; margin-bottom: 1.25rem; font-weight: 800;">{{ __('auth.cta_title') }}</h2>
            <p
                style="margin-bottom: 2.5rem; opacity: 0.95; font-size: 1.15rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                {{ __('auth.cta_description') }}
                .</p>
            <a href="{{ route('project') }}" class="btn"
                style="background: white; color: var(--primary-dark); font-weight: 800; padding: 1rem 3rem; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                {{ __('auth.browse_opportunities') }}</a>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials-section">
        <div class="container">
            <div style="margin-bottom: 4rem;">
                <h2 style="font-size: 2.25rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.75rem;">
                    {{ __('auth.testimonials_title') }}</h2>
                <p style="color: var(--text-light); font-size: 1.1rem;">{{ __('auth.testimonials_description') }}</p>
            </div>
            <div class="testimonials-slider">
                @foreach ($reviews as $review)
                    <!-- Testimonial 1 -->
                    <div class="testimonial-card">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                            <div class="user-avatar"><i class="fas fa-user"></i></div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; font-size: 1.1rem; color: var(--gray-900);">
                                    {{ $review->user->name }}
                                </div>
                                <div style="font-size: 0.85rem; color: var(--primary); font-weight: 600;">مستثمر منذ 2023
                                </div>
                            </div>
                        </div>

                        <div class="text-warning fs-5">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= round($averageRating) ? '★' : '☆' }}
                            @endfor
                        </div>
                        <p style="color: var(--gray-600); font-size: 1rem; line-height: 1.7;">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Education & FAQ Combined -->
    <div class="container" style="margin-bottom: 8rem;">
        <div style="display: grid; grid-template-columns: 1fr; gap: 5rem;">

            <!-- Education -->
            <section>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 6px; height: 35px; background: var(--primary); border-radius: 4px;"></div>
                    <h2 style="font-size: 2rem; font-weight: 800; color: var(--secondary);">
                        {{ __('auth.education_title') }}</h2>
                </div>
                <div class="education-grid" style="margin-top: 1rem;">
                    <div class="edu-card">
                        <div class="edu-icon"><i class="fas fa-book"></i></div>
                        <h3 style="font-weight: 800; margin-bottom: 0.75rem; font-size: 1.25rem;">
                            {{ __('auth.crowdfunding') }}</h3>
                        <p style="font-size: 1rem; color: var(--gray-600); line-height: 1.7;">
                            {{ __('auth.crowdfunding_desc') }}</p>
                    </div>
                    <div class="edu-card">
                        <div class="edu-icon"><i class="fas fa-shield-alt"></i></div>
                        <h3 style="font-weight: 800; margin-bottom: 0.75rem; font-size: 1.25rem;">
                            {{ __('auth.security') }}</h3>
                        <p style="font-size: 1rem; color: var(--gray-600); line-height: 1.7;">
                            {{ __('auth.security_desc') }}</p>
                    </div>
                    <div class="edu-card">
                        <div class="edu-icon"><i class="fas fa-chart-pie"></i></div>
                        <h3 style="font-weight: 800; margin-bottom: 0.75rem; font-size: 1.25rem;">
                            {{ __('auth.portfolio_diversification') }}</h3>
                        <p style="font-size: 1rem; color: var(--gray-600); line-height: 1.7;">
                            {{ __('auth.portfolio_diversification_desc') }}</p>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 6px; height: 35px; background: var(--primary); border-radius: 4px;"></div>
                    <h2 style="font-size: 2rem; font-weight: 800; color: var(--secondary);">{{ __('auth.faq_title') }}
                    </h2>
                </div>
                <div class="faq-container">
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div class="faq-question">{{ __('auth.faq_question_1') }} <i
                                class="fas fa-chevron-down faq-toggle"></i></div>
                        <div class="faq-answer">{{ __('auth.faq_answer_1') }}</div>
                    </div>
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div class="faq-question">{{ __('auth.faq_question_2') }} <i
                                class="fas fa-chevron-down faq-toggle"></i></div>
                        <div class="faq-answer">{{ __('auth.faq_answer_2') }}</div>
                    </div>
                    <div class="faq-item" onclick="toggleFaq(this)">
                        <div class="faq-question">{{ __('auth.faq_question_3') }} <i
                                class="fas fa-chevron-down faq-toggle"></i></div>
                        <div class="faq-answer">{{ __('auth.faq_answer_3') }}</div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Trust Logos -->
    <section class="trust-section">
        <div class="container trust-logos">
            <div style="font-weight: 800; font-size: 1.4rem; color: var(--gray-400); letter-spacing: 1px;"><i
                    class="fas fa-lock mb-2 block text-center opacity-50"></i> {{ __('auth.ssl_secured') }}</div>
            <div style="font-weight: 800; font-size: 1.4rem; color: var(--gray-400); letter-spacing: 1px;"><i
                    class="fas fa-key mb-2 block text-center opacity-50"></i> {{ __('auth.encrypted') }}</div>
            <div style="font-weight: 800; font-size: 1.4rem; color: var(--gray-400); letter-spacing: 1px;"><i
                    class="fas fa-user-check mb-2 block text-center opacity-50"></i> {{ __('auth.kyc_verified') }}</div>
            <div style="font-weight: 800; font-size: 1.4rem; color: var(--gray-400); letter-spacing: 1px;"><i
                    class="fas fa-file-contract mb-2 block text-center opacity-50"></i> {{ __('auth.aml_compliant') }}
            </div>
        </div>
    </section>


@endsection
