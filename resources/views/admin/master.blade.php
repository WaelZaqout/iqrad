<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'الرئيسية')</title>
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <!-- Font for Arabic UI -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/admin/table.css') }}">
    @yield('css')
    @if (App::getLocale() == 'en')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

            /* ============================================
               ENGLISH LTR STYLES - Mirrored from styles.css
               ============================================ */

            * {
                direction: ltr;
            }

            body {
                direction: ltr;
                text-align: left;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background-color: var(--bg-light);
                color: var(--text-main);
                line-height: 1.6;
                overflow-x: hidden;
                font-size: 16px;
            }

            a {
                text-decoration: none;
                color: inherit;
                transition: 0.3s;
            }

            ul {
                list-style: none;
            }

            /* Container & Grid System */
            .container {
                direction: ltr;
                text-align: left;
            }

            /* Buttons Global - LTR */
            .btn {
                direction: ltr;
                text-align: center;
            }

            .btn-primary {
                direction: ltr;
            }

            .btn-outline {
                direction: ltr;
            }

            .btn-purple {
                direction: ltr;
            }

            /* Header Enhanced - LTR */
            header {
                direction: ltr;
            }

            .header-inner {
                direction: ltr;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                direction: ltr;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .logo-icon {
                direction: ltr;
            }

            .logo-icon i {
                direction: ltr;
            }

            .logo-text {
                direction: ltr;
            }

            .header-actions {
                direction: ltr;
                display: flex;
                gap: 1.5rem;
                align-items: center;
            }

            .icon-btn {
                direction: ltr;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .icon-btn i {
                direction: ltr;
            }

            /* Notification badge position for LTR */
            .icon-btn.position-relative .position-absolute {
                left: auto;
                right: 0;
                top: 0;
                transform: translate(50%, -50%);
            }

            .icon-btn.position-relative .position-absolute.start-100 {
                left: auto;
                right: 0;
            }

            .user-profile {
                direction: ltr;
                padding: 6px 8px 6px 16px;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .user-profile .hidden-mobile {
                direction: ltr;
                text-align: left;
            }

            .user-avatar-circle {
                direction: ltr;
                order: 1;
            }

            .user-profile i.fa-chevron-down {
                direction: ltr;
                order: 2;
                margin-left: 0;
                margin-right: 0;
            }

            /* Dropdown icons in header */
            .dropdown-menu i {
                direction: ltr;
                margin-right: 0.5rem;
                margin-left: 0;
            }

            .dropdown-item i {
                direction: ltr;
            }

            /* Language toggle and other header icons */
            .header-actions .icon-btn i.fa-globe,
            .header-actions .icon-btn i.fa-bell {
                direction: ltr;
            }

            /* Hero Section - LTR */
            .hero {
                direction: ltr;
            }

            .hero::before {
                left: -100px;
                right: auto;
            }

            .hero-inner {
                direction: ltr;
                text-align: left;
            }

            @media(min-width: 992px) {
                .hero-inner {
                    flex-direction: row;
                    justify-content: space-between;
                    text-align: left;
                }

                .hero-content {
                    text-align: left;
                }
            }

            .hero h1 {
                text-align: left;
            }

            .hero-lead {
                text-align: left;
            }

            .hero-buttons {
                direction: ltr;
                justify-content: flex-start;
            }

            /* Stats Banner - LTR */
            .stats-banner {
                direction: ltr;
                text-align: center;
            }

            .stat-item {
                direction: ltr;
            }

            /* Search & Filter - LTR */
            .search-section {
                direction: ltr;
            }

            .search-controls {
                direction: ltr;
            }

            .filters {
                direction: ltr;
                justify-content: center;
            }

            .filter-btn {
                direction: ltr;
            }

            /* Project Cards - LTR */
            .project-cards-container {
                direction: ltr;
            }

            .project-card {
                direction: ltr;
            }

            .project-thumbnail {
                direction: ltr;
            }

            .project-header {
                direction: ltr;
                text-align: left;
            }

            .project-title {
                text-align: left;
            }

            .project-purpose {
                direction: ltr;
                text-align: left;
            }

            .project-details {
                direction: ltr;
            }

            .project-info {
                direction: ltr;
            }

            .info-item {
                direction: ltr;
                text-align: center;
            }

            .info-label {
                direction: ltr;
            }

            .info-value {
                direction: ltr;
            }

            .progress-container {
                direction: ltr;
            }

            .progress-header {
                direction: ltr;
            }

            .progress-bar {
                direction: ltr;
            }

            .progress-fill {
                direction: ltr;
            }

            .card-actions {
                direction: ltr;
            }

            .invest-btn {
                direction: ltr;
            }

            .details-btn {
                direction: ltr;
            }

            .status-badge {
                left: 16px;
                right: auto;
            }

            /* Trust & Testimonials - LTR */
            .trust-section {
                direction: ltr;
            }

            .trust-logos {
                direction: ltr;
            }

            .testimonials-section {
                direction: ltr;
            }

            .testimonials-slider {
                direction: ltr;
            }

            .testimonial-card {
                direction: ltr;
                text-align: left;
            }

            .user-avatar {
                direction: ltr;
            }

            /* Education & FAQ - LTR */
            .education-grid {
                direction: ltr;
            }

            .edu-card {
                direction: ltr;
                text-align: left;
            }

            .edu-icon {
                direction: ltr;
            }

            .faq-item {
                direction: ltr;
            }

            .faq-question {
                direction: ltr;
            }

            .faq-answer {
                direction: ltr;
                text-align: left;
            }

            .faq-toggle {
                direction: ltr;
            }

            /* Footer - LTR */
            footer {
                direction: ltr;
            }

            .footer-grid {
                direction: ltr;
            }

            .footer-title {
                direction: ltr;
                text-align: left;
            }

            .footer-links {
                direction: ltr;
            }

            .footer-links li {
                direction: ltr;
                text-align: left;
            }

            .footer-links a {
                direction: ltr;
            }

            .footer-links a:hover {
                padding-left: 5px;
                padding-right: 0;
            }

            /* Modals - LTR */
            .modal-overlay {
                direction: ltr;
            }

            .modal-box {
                direction: ltr;
            }

            .modal-header {
                direction: ltr;
            }

            .close-modal {
                direction: ltr;
            }

            .modal-content {
                direction: ltr;
            }

            .modal-content.auth-modal {
                direction: ltr;
            }

            .modal-content.auth-modal .close {
                right: 14px;
                left: auto;
            }

            .form-group {
                direction: ltr;
            }

            .form-label {
                direction: ltr;
                text-align: left;
            }

            .form-control {
                direction: ltr;
                text-align: left;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                direction: ltr;
                text-align: left;
            }

            .form-row {
                direction: ltr;
            }

            .stripe-notice {
                direction: ltr;
            }

            .modal-image {
                direction: ltr;
            }

            .modal-description {
                direction: ltr;
                text-align: left;
            }

            .modal-details {
                direction: ltr;
            }

            .detail-item {
                direction: ltr;
            }

            .detail-label {
                direction: ltr;
            }

            .detail-value {
                direction: ltr;
            }

            .modal-section {
                direction: ltr;
            }

            .auth-tabs {
                direction: ltr;
            }

            .tab-btn {
                direction: ltr;
            }

            .auth-body {
                direction: ltr;
            }

            .auth-form {
                direction: ltr;
            }

            .auth-form .form-group {
                direction: ltr;
            }

            .auth-form .form-group label {
                direction: ltr;
                text-align: left;
            }

            .auth-form .form-group input {
                direction: ltr;
                text-align: left;
            }

            /* Chat Widget - LTR */
            .chat-widget {
                left: 2.5rem;
                right: auto;
            }

            .chat-toggle-btn {
                direction: ltr;
            }

            .chat-window {
                left: 0;
                right: auto;
                transform-origin: bottom left;
            }

            .chat-msgs {
                direction: ltr;
            }

            .chat-msg {
                direction: ltr;
            }

            .msg-bot {
                border-bottom-left-radius: 4px;
                border-bottom-right-radius: 1.25rem;
            }

            .msg-user {
                border-bottom-right-radius: 4px;
                border-bottom-left-radius: 1.25rem;
            }

            /* Scroll to Top - LTR */
            .scroll-to-top {
                left: 32px;
                right: auto;
            }

            /* Preloader - LTR */
            #preloader {
                direction: ltr;
            }

            .preloader-content {
                direction: ltr;
            }

            .preloader-icon {
                direction: ltr;
            }

            /* Notification Bar - LTR */
            .notification-bar {
                direction: ltr;
                text-align: center;
            }

            .notification-bar i {
                margin-right: 8px;
                margin-left: 0;
            }

            .scrolling-text {
                direction: ltr;
            }

            /* Dropdown menus - LTR */
            .dropdown-menu {
                left: 0 !important;
                right: auto !important;
                text-align: left;
                direction: ltr;
            }

            .topbar .dropdown .dropdown-menu {
                left: 0;
                right: auto;
                text-align: left;
            }

            /* Dropdown items with icons - LTR */
            .dropdown-item {
                direction: ltr;
                text-align: left;
                display: flex;
                align-items: center;
            }

            .dropdown-item i {
                margin-right: 0.5rem;
                margin-left: 0;
                order: -1;
            }

            .dropdown-item .me-2 {
                margin-right: 0.5rem !important;
                margin-left: 0 !important;
            }

            /* Notification dropdown items */
            .dropdown-item.d-flex {
                direction: ltr;
            }

            .dropdown-item.d-flex i {
                order: -1;
            }

            /* Sidebar - LTR */
            .sidebar {
                direction: ltr;
                padding: 0;
                text-align: left;
            }

            .sidebar .nav-item .nav-link {
                direction: ltr;
                text-align: left;
                margin-left: 0;
                margin-right: 0;
                font-weight: 600;
                color: var(--gray-900);
            }

            .sidebar .nav-item .nav-link[data-toggle=collapse]::after {
                float: right;
                transform: rotate(0deg);
            }

            /* Menu - LTR */
            .limiter-menu-desktop {
                direction: ltr;
                margin: 0 auto;
                display: flex;
                justify-content: center;
            }

            .main-menu {
                direction: ltr;
                padding: 0;
                text-align: left;
            }

            /* Margins and padding - LTR */
            .ml-auto {
                margin-left: auto !important;
                margin-right: 0 !important;
            }

            .mx-auto {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* Project cards and thumbnails - LTR */
            .item-slick1::before {
                left: 0;
                right: auto;
                transform: scaleX(1);
            }

            .favorite-button {
                padding-left: 230px;
                padding-right: 0;
            }

            .thumbnails {
                left: -110px;
                right: auto;
            }

            .thumbnail img {
                direction: ltr;
            }

            /* Header buttons and user dropdown - LTR */
            .header-buttons {
                direction: ltr;
                justify-content: flex-start;
                padding-left: 40px;
                padding-right: 0;
            }

            .user-dropdown {
                direction: ltr;
                justify-content: flex-start;
                padding-left: 40px;
                padding-right: 0;
            }

            /* Fix icon alignment in header actions */
            .header-actions>* {
                display: flex;
                align-items: center;
            }

            /* Separator in header */
            .header-actions>div[style*="width: 1px"] {
                margin-left: 0.25rem;
                margin-right: 0.25rem;
            }

            /* Button in header */
            .header-actions .btn {
                direction: ltr;
                white-space: nowrap;
            }

            .user-name-btn {
                margin-right: 0;
                margin-left: 10px;
            }

            .img-profile {
                direction: ltr;
            }

            /* Close button - LTR */
            .close {
                float: right;
                direction: ltr;
            }

            /* Responsive - LTR */
            @media (max-width: 1024px) {
                .thumbnails {
                    left: -80px;
                    right: auto;
                }
            }

            @media (max-width: 768px) {
                .hero-inner {
                    text-align: center;
                }

                .hero h1 {
                    text-align: center;
                }

                .hero-lead {
                    text-align: center;
                }

                .hero-buttons {
                    justify-content: center;
                }

                .thumbnails {
                    position: static;
                    left: auto;
                    right: auto;
                    justify-content: center;
                }

                .card-actions {
                    flex-direction: column;
                }

                .details-btn,
                .invest-btn {
                    width: 100%;
                }
            }

            @media (max-width: 520px) {
                .modal-content.auth-modal {
                    direction: ltr;
                }
            }

            /* Star Rating - LTR */
            .star-rating {
                direction: ltr;
            }

            .star-rating label {
                direction: ltr;
            }
        </style>
    @endif
</head>

<body>
    <!-- Floating shapes (decorative) -->
    <div class="floating-shapes"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1;">
        <div class="shape shape1" style="position: absolute; top: 20%; left: 10%; opacity: 0.1;"><i class="fas fa-tag"
                style="font-size: 4rem; color: #667eea;"></i></div>
        <div class="shape shape2" style="position: absolute; top: 40%; right: 15%; opacity: 0.1;"><i
                class="fas fa-folder" style="font-size: 5rem; color: #764ba2;"></i></div>
        <div class="shape shape3" style="position: absolute; bottom: 30%; left: 20%; opacity: 0.1;"><i
                class="fas fa-list" style="font-size: 3.5rem; color: #2196F3;"></i></div>
        <div class="shape shape4" style="position: absolute; bottom: 20%; right: 10%; opacity: 0.1;"><i
                class="fas fa-cog" style="font-size: 3rem; color: #21CBF3;"></i></div>
    </div>

    <div class="container" style="position: relative; z-index: 10;">
        <!-- Success alert (example) -->
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert" style="display: none;">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-3" style="font-size: 1.5rem;"></i>
                <div><strong>تمت العملية بنجاح</strong></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="top-bar">
            <div class="datetime" id="datetime"></div>

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
            <div class="user-info">
                <span class="username">
                    {{__('admin.hello')}} , ( {{ Auth::user()->name }} )
                </span>
                <!-- زر تسجيل خروج وهمي -->
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">{{ __('admin.logout') }}</button>
                </form>
            </div>
        </div>

        @include('admin.sidebar')
    </div>

    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('assets/admin/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('datetime').textContent = now.toLocaleDateString('ar-EG', options);
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

    <script>
        CKEDITOR.replace('editor', {
            language: 'ar',
            contentsLangDirection: 'rtl',
            height: 250,
            versionCheck: false,
            toolbar: [{
                    name: 'document',
                    items: ['Source', '-', 'Preview']
                },
                {
                    name: 'clipboard',
                    items: ['Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', '-', 'RemoveFormat']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ]
        });
    </script>

    <script>
        /* ===== Toast موحّد ===== */
        (function() {
            const MAP = {
                success: {
                    klass: 'ct-success',
                    icon: '✓'
                },
                error: {
                    klass: 'ct-error',
                    icon: '✖'
                },
                warning: {
                    klass: 'ct-warning',
                    icon: '!'
                },
                info: {
                    klass: 'ct-info',
                    icon: 'ℹ'
                }
            };
            window.showToast = function(input = {}) {
                const t = (input.type || 'success').toLowerCase();
                const conf = MAP[t] || MAP.info;
                const message = input.message || '';
                const timeout = Number.isFinite(input.timeout) ? input.timeout : 2600;
                const position = input.position || 'top-end';

                if (Swal.isVisible() && Swal.getPopup()?.classList.contains('card-toast')) Swal.close();

                Swal.fire({
                    toast: true,
                    position,
                    showConfirmButton: false,
                    timer: timeout,
                    html: `
                        <div class="ct-row">
                            <span class="ct-icon">${conf.icon}</span>
                            <div class="ct-text">${message}</div>
                        </div>
                        <div class="ct-bar"><span></span></div>
                    `,
                    customClass: {
                        popup: `card-toast ${conf.klass}`
                    },
                    didOpen: (el) => {
                        el.setAttribute('dir', 'rtl');
                        const bar = el.querySelector('.ct-bar > span');
                        if (!bar) return;
                        const start = performance.now();

                        function step(now) {
                            const p = Math.min(1, (now - start) / timeout);
                            bar.style.width = (p * 100) + '%';
                            if (p < 1) requestAnimationFrame(step);
                        }
                        requestAnimationFrame(step);
                    }
                });
            };
        })();

        /* ===== نافذة تأكيد موحّدة ===== */
        function confirmDialog({
            title,
            text,
            confirmText,
            icon = 'warning'
        }) {
            return Swal.fire({
                title,
                text,
                icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'إلغاء',
                reverseButtons: false,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'swal2-confirm btn btn-success px-4',
                    cancelButton: 'swal2-cancel btn btn-danger px-4'
                }
            });
        }


        /* ===== الحذف ===== */
        document.addEventListener('submit', async (e) => {
            const form = e.target.closest('.delete-form');
            if (!form) return;

            e.preventDefault();
            const res = await confirmDialog({
                title: 'حذف العنصر؟',
                text: 'سيتم حذف العنصر نهائيًا ولا يمكن التراجع.',
                confirmText: 'نعم، احذف',
                icon: 'warning'
            });

            if (res.isConfirmed) {
                showToast({
                    type: 'success',
                    message: 'تم الحذف بنجاح!'
                });
                form.submit(); // ← هذا يخلي الطلب يوصل للـ backend فعلاً
            }

        });
    </script>

</body>

</html>
