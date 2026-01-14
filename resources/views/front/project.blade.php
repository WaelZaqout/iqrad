<!DOCTYPE html>
<html lang="ar" dir="rtl">

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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #047857;
            --secondary: #1e293b;
            --text-main: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --border: #e5e7eb;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius: 1rem;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Layout & Utilities */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        .hidden {
            display: none !important;
        }

        /* Header */

        /* Header Enhanced */
        header {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            color: white;
            padding: 1.25rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
        }

        .logo-text {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .header-actions {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .icon-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            transition: 0.3s;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.05);
            padding: 6px 8px 6px 16px;
            border-radius: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            cursor: pointer;
            transition: 0.3s;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .user-avatar-circle {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        /* Notification Bar */
        .notification-bar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 14px;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1001;
            opacity: 0;
            transform: translateY(-100%);
            animation: slideDown 0.5s ease-out forwards;
            overflow: hidden;
            white-space: nowrap;
        }

        /* small animation for the bullhorn icon in the notification bar */
        .notification-bar i {
            margin-inline-end: 8px;
            display: inline-block;
            animation: notifPulse 1.6s ease-in-out infinite;
        }

        @keyframes notifPulse {
            0% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-3px) scale(1.02);
            }

            100% {
                transform: translateY(0) scale(1);
            }
        }

        .scrolling-text {
            display: inline-block;
            /* slower scroll for a more professional feel */
            animation: scrollText 30s linear infinite;
            white-space: nowrap;
        }

        @keyframes scrollText {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        @keyframes slideDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-purple {
            background-color: #7c3aed;
            color: white;
        }

        .btn-purple:hover {
            background-color: #6d28d9;
        }

        .btn-outline {
            background-color: white;
            border: 1px solid var(--border);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background-color: var(--bg-light);
        }

        .filter-btn {
            background: white;
            border: 1px solid var(--border);
            color: var(--text-light);
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.875rem;
        }

        .filter-btn.active {
            background: var(--secondary);
            color: white;
            border-color: var(--secondary);
        }

        /* Projects Grid */
        .grid-projects {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .project-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            height: 200px;
            background-color: #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .project-card:hover .card-image img {
            transform: scale(1.1);
        }

        .badge {
            position: absolute;
            top: 12px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: bold;
            backdrop-filter: blur(4px);
        }

        .badge-active {
            right: 12px;
            background: #d1fae5;
            color: #047857;
        }

        .badge-pending {
            right: 12px;
            background: #f3f4f6;
            color: #374151;
        }

        .badge-category {
            left: 12px;
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .card-content {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-main);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .info-box {
            background: var(--bg-light);
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
        }

        .info-label {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-bottom: 2px;
        }

        .info-value {
            font-weight: 700;
            font-size: 0.9rem;
        }

        .progress-section {
            margin-top: auto;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .progress-bar-bg {
            width: 100%;
            background: #e5e7eb;
            height: 10px;
            border-radius: 9999px;
            overflow: hidden;
            margin-bottom: 1.25rem;
        }

        .progress-bar-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 9999px;
        }


        /* Footer */
        footer {
            background: var(--secondary);
            color: #94a3b8;
            padding: 6rem 0 3rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .footer-title {
            color: white;
            font-weight: 800;
            margin-bottom: 1.75rem;
            font-size: 1.25rem;
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a:hover {
            color: var(--primary);
            padding-right: 5px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Chat Widget */
        .chat-widget {
            position: fixed;
            bottom: 1.5rem;
            left: 1.5rem;
            z-index: 999;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .chat-toggle {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            background: linear-gradient(to right, var(--primary), #059669);
            color: white;
            border: none;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
            cursor: pointer;
            font-size: 1.5rem;
            transition: transform 0.3s;
        }

        .chat-toggle:hover {
            transform: scale(1.1);
        }

        .chat-window {
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: none;
            flex-direction: column;
            border: 1px solid var(--border);
        }

        .chat-window.open {
            display: flex;
        }

        .chat-header {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-body {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .msg {
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            max-width: 85%;
            line-height: 1.5;
        }

        .msg-user {
            align-self: flex-start;
            background: var(--primary);
            color: white;
            border-bottom-right-radius: 0;
        }

        .msg-model {
            align-self: flex-end;
            background: white;
            border: 1px solid var(--border);
            color: var(--text-main);
            border-bottom-left-radius: 0;
        }

        .chat-input-area {
            padding: 0.75rem;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 0.5rem;
            background: white;
        }

        .chat-input {
            flex: 1;
            padding: 0.6rem 1rem;
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            background: var(--bg-light);
            outline: none;
        }

        .chat-input:focus {
            border-color: var(--primary);
            background: white;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 500px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-family: inherit;
            margin-bottom: 1rem;
            resize: none;
            height: 100px;
        }

        textarea:focus {
            outline: 2px solid var(--primary);
            border-color: transparent;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .grid-projects {
                grid-template-columns: 1fr;
            }

            .chat-window {
                width: 300px;
            }
        }
    </style>

    <!-- Import Map for Google GenAI SDK -->
    <script type="importmap">
{
  "imports": {
    "@google/genai": "https://esm.sh/@google/genai@^1.33.0",
    "react": "https://esm.sh/react@^19.2.3",
    "react/": "https://esm.sh/react@^19.2.3/"
  }
}
</script>
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
        <div id="projects-grid" class="grid-projects">

            @foreach ($projects as $project)
                <!-- Project 1 -->
                <div class="project-card" data-status="active">
                    <div class="card-image">
                        @if (!empty($project->image))
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                        @else
                            <div class="project-thumbnail">
                                <div class="placeholder">
                                    <i class="fas fa-briefcase fa-2x" aria-hidden="true"></i>
                                    <div style="font-weight:800;margin-top:6px;color:var(--primary)">
                                        {{ $project->category->name }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <span class="status-badge {{ $project->status_badge['class'] }}">
                            {{ $project->status_badge['label'] }}
                        </span>
                        <div class="badge badge-category"><i class="fas fa-industry"
                                style="color:var(--primary)"></i>
                            {{ $project->category->name }}
                        </div>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">{{ $project->title }}</h4>
                        <div class="info-grid">
                            <div class="info-box">
                                <div class="info-label">المدة</div>
                                <div class="info-value">{{ $project->term_months }} شهر</div>
                            </div>
                            <div class="info-box">
                                <div class="info-label">العائد</div>
                                <div class="info-value">{{ $project->interest_rate }}%</div>
                            </div>
                            <div class="info-box" style="grid-column: span 2;">
                                <div class="info-label">الحد الأدنى</div>
                                <div class="info-value">{{ $project->min_investment }} ريال</div>
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-header">
                                <span style="font-weight: bold; color: var(--text-light);">
                                    @if ($project->is_completed)
                                        مكتمل
                                    @else
                                        {{ $project->percentage }}%
                                    @endif
                                </span>

                                <span style="color: #9ca3af;">{{ number_format($project->funded_amount, 0) }} /
                                    {{ number_format($project->funding_goal, 0) }}</span>
                            </div>
                            <div class="progress-bar-bg">

                                <div class="progress-bar-fill" style="width: {{ $project->percentage }}%;"></div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('details', $project->id) }}" class="btn btn-outline"
                                    style="flex:1">التفاصيل</a>
                                <button class="btn btn-primary" style="flex:1">استثمر</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


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
    <!-- Chat Widget -->
    <div class="chat-widget">
        <!-- Window -->
        <div id="chat-window" class="chat-window">
            <div class="chat-header">
                <div class="flex items-center gap-2">
                    <i class="fas fa-robot"></i>
                    <div>
                        <div style="font-weight: bold; font-size: 0.9rem;">المساعد الذكي</div>
                        <div style="font-size: 0.7rem; opacity: 0.9;">Gemini Pro متصل</div>
                    </div>
                </div>
                <button onclick="toggleChat()" style="background:none; border:none; color:white; cursor:pointer;"><i
                        class="fas fa-times"></i></button>
            </div>

            <div id="chat-messages" class="chat-body">
                <div class="msg msg-model">
                    مرحباً بك في إقراضك! أنا مساعدك الذكي. كيف يمكنني مساعدتك في استثماراتك اليوم؟
                </div>
            </div>

            <div class="chat-input-area">
                <input type="text" id="chat-input" class="chat-input" placeholder="اكتب استفسارك هنا..."
                    onkeydown="if(event.key==='Enter') sendMessage()">
                <button onclick="sendMessage()" class="btn btn-primary"
                    style="padding: 0.5rem 1rem; border-radius: 0.5rem;"><i
                        class="fas fa-paper-plane rtl:rotate-180"></i></button>
            </div>
        </div>

        <!-- Toggle Button -->
        <button id="chat-toggle-btn" onclick="toggleChat()" class="chat-toggle">
            <i class="fas fa-headset"></i>
        </button>
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

    <!-- Application Logic -->
    <script type="module">
        import {
            GoogleGenAI
        } from "@google/genai";

        // Global State
        let chatHistory = [];
        let generatedImageUrl = null;

        // --- Utils ---
        async function ensureApiKey() {
            if (window.aistudio) {
                const hasKey = await window.aistudio.hasSelectedApiKey();
                if (!hasKey) {
                    await window.aistudio.openSelectKey();
                    return await window.aistudio.hasSelectedApiKey();
                }
                return true;
            }
            return true;
        }

        const getAIClient = () => new GoogleGenAI({
            apiKey: process.env.API_KEY
        });

        // --- UI Logic ---
        window.filterProjects = (status) => {
            // Update Buttons
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('btn-' + status).classList.add('active');

            // Toggle Cards
            const cards = document.querySelectorAll('.project-card');
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'all' || cardStatus === status) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        // --- Chat Logic ---
        window.toggleChat = () => {
            const chatWindow = document.getElementById('chat-window');
            const toggleBtn = document.getElementById('chat-toggle-btn');

            if (getComputedStyle(chatWindow).display === 'none') {
                chatWindow.classList.add('open');
                toggleBtn.style.transform = 'scale(0)';
            } else {
                chatWindow.classList.remove('open');
                toggleBtn.style.transform = 'scale(1)';
            }
        }

        window.sendMessage = async () => {
            const input = document.getElementById('chat-input');
            const text = input.value.trim();
            if (!text) return;

            // Add user message
            appendMessage('user', text);
            input.value = '';

            // Add loading
            const loadingId = appendLoading();

            try {
                const ai = getAIClient();
                const chat = ai.chats.create({
                    model: 'gemini-3-pro-preview',
                    history: chatHistory.map(m => ({
                        role: m.role,
                        parts: [{
                            text: m.text
                        }]
                    })),
                    config: {
                        systemInstruction: "أنت مساعد مالي ذكي لمنصة إقراضك. تحدث بالعربية."
                    }
                });

                const result = await chat.sendMessage({
                    message: text
                });
                const response = result.text;

                removeLoading(loadingId);
                appendMessage('model', response);

                chatHistory.push({
                    role: 'user',
                    text: text
                });
                chatHistory.push({
                    role: 'model',
                    text: response
                });

            } catch (error) {
                console.error(error);
                removeLoading(loadingId);
                appendMessage('model', 'عذراً، حدث خطأ. حاول مرة أخرى.');
            }
        }

        function appendMessage(role, text) {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = `msg msg-${role}`;
            div.textContent = text;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        function appendLoading() {
            const container = document.getElementById('chat-messages');
            const id = 'loading-' + Date.now();
            const div = document.createElement('div');
            div.id = id;
            div.className = 'msg msg-model';
            div.innerHTML = '<i class="fas fa-ellipsis-h fa-beat"></i>';
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
            return id;
        }

        function removeLoading(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        // --- Image Generation Logic ---
        window.openImageModal = () => document.getElementById('image-modal').classList.add('open');
        window.closeImageModal = () => {
            document.getElementById('image-modal').classList.remove('open');
            resetImageModal();
        };

        function resetImageModal() {
            document.getElementById('image-prompt').value = '';
            document.getElementById('generated-image-container').classList.add('hidden');
            document.getElementById('image-loading').classList.add('hidden');
            document.getElementById('btn-generate').classList.remove('hidden');
            document.getElementById('btn-confirm').classList.add('hidden');
        }

        window.generateImage = async () => {
            const prompt = document.getElementById('image-prompt').value;
            if (!prompt) return;

            document.getElementById('image-loading').classList.remove('hidden');

            try {
                await ensureApiKey();
                const ai = getAIClient();
                const response = await ai.models.generateContent({
                    model: 'gemini-3-pro-image-preview',
                    contents: {
                        parts: [{
                            text: prompt
                        }]
                    },
                    config: {
                        imageConfig: {
                            aspectRatio: "16:9",
                            imageSize: "1K"
                        }
                    }
                });

                let imgUrl = null;
                for (const part of response.candidates?.[0]?.content?.parts || []) {
                    if (part.inlineData) {
                        imgUrl = `data:image/png;base64,${part.inlineData.data}`;
                        break;
                    }
                }

                if (imgUrl) {
                    generatedImageUrl = imgUrl;
                    document.getElementById('generated-image-preview').src = imgUrl;
                    document.getElementById('generated-image-container').classList.remove('hidden');
                    document.getElementById('btn-generate').classList.add('hidden');
                    document.getElementById('btn-confirm').classList.remove('hidden');
                }
            } catch (err) {
                console.error(err);
                if (err.message && err.message.includes("Requested entity was not found")) {
                    try {
                        if (window.aistudio) {
                            await window.aistudio.openSelectKey();
                            alert("تم تحديث المفتاح، حاول مرة أخرى.");
                        }
                    } catch (e) {
                        console.error(e);
                    }
                } else {
                    alert('فشل توليد الصورة. تأكد من الاتصال.');
                }
            } finally {
                document.getElementById('image-loading').classList.add('hidden');
            }
        }

        window.confirmImage = () => {
            if (generatedImageUrl) {
                const container = document.getElementById('projects-grid');

                // Manually construct HTML for new AI project
                const newCard = document.createElement('div');
                newCard.className = 'project-card';
                newCard.setAttribute('data-status', 'active');

                // Standard boilerplate for a new "AI Generated" project
                newCard.innerHTML = `
                    <div class="card-image">
                        <img src="${generatedImageUrl}" alt="AI Project">
                        <span class="badge badge-active">نشط</span>
                        <div class="badge badge-category"><i class="fas fa-lightbulb" style="color:var(--primary)"></i> ابتكار</div>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">مشروع ذكي جديد (AI)</h4>
                        <div class="info-grid">
                            <div class="info-box"><div class="info-label">المدة</div><div class="info-value">18 شهر</div></div>
                            <div class="info-box"><div class="info-label">العائد</div><div class="info-value">14%</div></div>
                            <div class="info-box" style="grid-column: span 2;"><div class="info-label">الحد الأدنى</div><div class="info-value">10,000 ريال</div></div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-header"><span style="font-weight: bold; color: var(--text-light);">0% مكتمل</span><span style="color: #9ca3af;">0 / 100,000</span></div>
                            <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 0%;"></div></div>
                            <div class="flex gap-2">
                                <button class="btn btn-outline" style="flex:1">التفاصيل</button>
                                <button class="btn btn-primary" style="flex:1">استثمر</button>
                            </div>
                        </div>
                    </div>
                `;

                container.prepend(newCard); // Add to top
                window.closeImageModal();
            }
        }
    </script>

</body>

</html>
