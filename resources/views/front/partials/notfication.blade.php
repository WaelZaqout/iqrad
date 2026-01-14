@extends('front.master')

@section('content')
    <main class="container" style="padding: 48px 0;">
        <div class="notifications-page" dir="rtl">
            <div class="page-header" style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--gray-900); margin-bottom: 1rem;">
                    <i class="fas fa-bell" style="color: var(--primary); margin-left: 1rem;"></i>
                    الإشعارات
                </h1>
                <p style="color: var(--gray-600); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                    تابع آخر التحديثات والأخبار المهمة حول مشاريعك واستثماراتك
                </p>
            </div>

            @if ($notifications->count() > 0)
                <div class="notifications-list" style="max-width: 800px; margin: 0 auto;">
                    @foreach ($notifications as $notification)
                        <div class="notification-card {{ $notification->read_at ? 'read' : 'unread' }}"
                            style="background: white; border-radius: 1rem; padding: 1.5rem; margin-bottom: 1rem; box-shadow: var(--shadow-sm); border: 1px solid var(--border); transition: var(--transition); position: relative;">
                            @if (!$notification->read_at)
                                <div class="unread-indicator"
                                    style="position: absolute; top: 1rem; right: 1rem; width: 8px; height: 8px; background: var(--primary); border-radius: 50%;">
                                </div>
                            @endif

                            <div class="notification-content" style="display: flex; gap: 1rem; align-items: flex-start;">
                                <div class="notification-icon"
                                    style="flex-shrink: 0; width: 48px; height: 48px; background: {{ $notification->read_at ? 'var(--bg-light)' : 'rgba(16, 185, 129, 0.1)' }}; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: {{ $notification->read_at ? 'var(--gray-500)' : 'var(--primary)' }}; font-size: 1.25rem;">
                                    <i class="fas fa-bell"></i>
                                </div>

                                <div class="notification-details" style="flex: 1;">
                                    <h3 class="notification-title"
                                        style="font-size: 1.1rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">
                                        {{ $notification->data['title'] ?? 'إشعار جديد' }}
                                    </h3>
                                    <p class="notification-message"
                                        style="color: var(--gray-600); line-height: 1.6; margin-bottom: 0.75rem;">
                                        {{ $notification->data['message'] ?? '' }}
                                    </p>
                                    <div class="notification-meta"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <span class="notification-time" style="font-size: 0.85rem; color: var(--gray-500);">
                                            <i class="fas fa-clock" style="margin-left: 0.5rem;"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        @if (isset($notification->data['url']) && $notification->data['url'])
                                            <a href="{{ $notification->data['url'] }}" class="notification-link"
                                                style="font-size: 0.9rem; color: var(--primary); font-weight: 600; text-decoration: none;">
                                                عرض التفاصيل <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="notifications-footer"
                    style="text-align: center; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                    <p style="color: var(--gray-500); font-size: 0.95rem;">
                        هذه جميع إشعاراتك. إذا كان لديك أي استفسارات، تواصل معنا عبر
                        <a href="mailto:support@iqrad.example"
                            style="color: var(--primary); text-decoration: none;">support@iqrad.example</a>
                    </p>
                </div>
            @else
                <div class="no-notifications"
                    style="text-align: center; padding: 4rem 2rem; max-width: 500px; margin: 0 auto;">
                    <div class="no-notifications-icon"
                        style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1.5rem;">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-700); margin-bottom: 1rem;">
                        لا توجد إشعارات
                    </h3>
                    <p style="color: var(--gray-500); font-size: 1rem; line-height: 1.6;">
                        لم يتم العثور على أي إشعارات حالياً. سنقوم بإشعارك فور حدوث أي تحديثات مهمة.
                    </p>
                </div>
            @endif
        </div>
    </main>

    <style>
        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .notification-card.unread {
            border-right: 4px solid var(--primary);
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.02) 0%, white 20%);
        }

        .notification-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .notification-content {
                flex-direction: column;
                text-align: center;
            }

            .notification-meta {
                flex-direction: column;
                gap: 0.5rem;
                align-items: center;
            }
        }
    </style>
@endsection
