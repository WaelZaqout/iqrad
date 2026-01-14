<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المشاريع المفضلة - إقراضك</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* نفس التنسيقات من الصفحة الرئيسية تماماً */
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

        .badge-category {
            right: 12px;
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* تنسيق زر المفضلة الخاص */
        .fav-btn-action {
            position: absolute;
            top: 12px;
            left: 12px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            z-index: 10;
            transition: transform 0.2s;
        }

        .fav-btn-action:hover {
            transform: scale(1.1);
            background: #fef2f2;
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: var(--radius);
            border: 1px dashed var(--border);
            margin-top: 2rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .grid-projects {
                grid-template-columns: 1fr;
            }

            .hidden-mobile {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container header-inner">
            <div class="logo">
                <a href="/" class="logo-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </a>
                <span class="logo-text">إقراضك</span>
            </div>

            <div class="header-actions">
                <!-- Notifications -->
                <div class="dropdown">
                    <div class="icon-btn" style="position: relative;" data-bs-toggle="dropdown" title="الإشعارات">
                        <i class="fas fa-bell fa-lg"></i>
                        <span
                            style="position: absolute; top: 10px; right: 12px; width: 10px; height: 10px; background: #ef4444; border-radius: 50%; border: 2px solid #1e293b;"></span>
                    </div>
                </div>

                <!-- Profile -->
                @auth
                    <div class="dropdown">
                        <div class="user-profile" data-bs-toggle="dropdown">
                            <div class="hidden-mobile" style="text-align: left;">
                                <div style="font-weight: 700; font-size: 0.95rem; line-height: 1.2;">
                                    {{ auth()->user()->name }}</div>
                                <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 500;">
                                    {{ auth()->user()->role === 'investor' ? 'مستثمر' : 'مقترض' }}
                                </div>
                            </div>
                            <div class="user-avatar-circle">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            <i class="fas fa-chevron-down hidden-mobile" style="font-size: 0.75rem; color: #64748b;"></i>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container" style="padding-top: 2rem; padding-bottom: 2rem; flex: 1;">

        <!-- Intro Section for Favorites -->
        <div style="margin-bottom: 2.5rem;">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <h1
                        style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-heart" style="color: #ef4444;"></i> قائمة المفضلة
                    </h1>
                    <p style="color: var(--text-light);">المشاريع التي قمت بحفظها للرجوع إليها والاستثمار فيها لاحقاً.
                    </p>
                </div>
                <!-- Button to go back to main dashboard -->
                <a href="{{ route('home') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-right"></i> تصفح جميع المشاريع
                </a>
            </div>

            <!-- Filters (Optional for Favorites, keeping design consistent) -->
            <div class="flex gap-2" style="overflow-x: auto; padding-bottom: 0.5rem;">
                <button onclick="filterProjects('all')" class="filter-btn active" id="btn-all">الكل</button>
                <button onclick="filterProjects('active')" class="filter-btn" id="btn-active">نشط حالياً</button>
                <button onclick="filterProjects('completed')" class="filter-btn" id="btn-completed">مكتمل
                    التمويل</button>
            </div>
        </div>

        <!-- Favorites Grid -->
        <div id="projects-grid" class="grid-projects">

            <!-- Check if there are favorites -->
            @forelse ($favorites as $project)
                <!-- Project Card -->
                <div class="project-card" data-status="{{ $project->status }}">
                    <div class="card-image">
                        @if (!empty($project->image))
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                        @else
                            <div
                                style="width:100%; height:100%; background: linear-gradient(135deg, #1e293b, #334155); display:flex; align-items:center; justify-content:center; color:white;">
                                <i class="fas fa-briefcase fa-3x"></i>
                            </div>
                        @endif

                        <!-- Remove from Favorites Button -->
                        <form action="{{ route('favorites.remove', $project->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="fav-btn-action" title="إزالة من المفضلة">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>

                        <div class="badge badge-active" style="right: 12px; left: auto;">
                            {{ $project->status === 'active' ? 'نشط' : 'مكتمل' }}
                        </div>
                    </div>

                    <div class="card-content">
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                            <h4 class="card-title" style="margin-bottom: 0;">{{ $project->title }}</h4>
                            <span
                                style="font-size: 0.75rem; background: #f3f4f6; padding: 2px 8px; border-radius: 4px; color: #6b7280;">
                                {{ $project->category->name ?? 'عام' }}
                            </span>
                        </div>

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
                                <div class="info-value">{{ number_format($project->min_investment) }} ريال</div>
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-header">
                                <span
                                    style="font-weight: bold; color: var(--text-light);">{{ $project->percentage ?? 0 }}%</span>
                                <span style="color: #9ca3af;">{{ number_format($project->funded_amount) }} /
                                    {{ number_format($project->funding_goal) }}</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: {{ $project->percentage ?? 0 }}%;"></div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('details', $project->id) }}" class="btn btn-outline"
                                    style="flex:1">التفاصيل</a>
                                <button class="btn btn-primary" style="flex:1">استثمر</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State (Shown if no favorites) -->
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <i class="far fa-heart empty-icon"></i>
                    <h3 style="font-weight: 700; margin-bottom: 0.5rem;">لا توجد مشاريع في المفضلة</h3>
                    <p style="color: var(--text-light); margin-bottom: 1.5rem;">لم تقم بإضافة أي مشاريع إلى قائمة
                        المفضلة بعد. تصفح المشاريع واحفظ ما يثير اهتمامك.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">تصفح المشاريع</a>
                </div>
            @endforelse

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
                        <span class="logo-text">إقراضك</span>
                    </div>
                    <p style="font-size: 1rem; line-height: 1.8; opacity: 0.8; margin-bottom: 2rem;">منصة تمويل رقمية
                        رائدة تجمع بين الطموح والفرصة.</p>
                </div>
                <div>
                    <h5 class="footer-title">روابط سريعة</h5>
                    <ul class="footer-links" style="font-size: 1rem;">
                        <li><a href="#">فرص الاستثمار المتاحة</a></li>
                        <li><a href="#">المشاريع النشطة</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="footer-title">الدعم والمساعدة</h5>
                    <ul class="footer-links" style="font-size: 1rem;">
                        <li><a href="#">تواصل معنا</a></li>
                        <li><a href="#">الأسئلة الشائعة</a></li>
                    </ul>
                </div>
            </div>
            <div
                style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2.5rem; text-align: center; font-size: 0.95rem; opacity: 0.6;">
                © 2025 منصة إقراضك. جميع الحقوق محفوظة.
            </div>
        </div>
    </footer>

    <!-- Logic for Filtering (Optional) -->
    <script>
        function filterProjects(status) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('btn-' + status).classList.add('active');

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
    </script>
</body>

</html>
