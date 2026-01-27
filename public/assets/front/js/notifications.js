   document.addEventListener('DOMContentLoaded', function() {
            const notificationBell = document.getElementById('notificationBell');

            if (notificationBell) {
                notificationBell.addEventListener('click', function() {
                    // تأخير صغير للسماح بفتح الـ dropdown أولاً
                    setTimeout(markNotificationsAsRead, 300);
                });
            }
        });

        function markNotificationsAsRead() {
            const unreadItems = document.querySelectorAll('.notification-item');

            // إذا لم تكن هناك إشعارات غير مقروءة
            if (unreadItems.length === 0) return;

            fetch(window.routes.markNotificationsRead, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    console.log('✅ تم تحديث الإشعارات:', data);

                    // إزالة العلامة الحمراء
                    const badge = document.getElementById('notificationBadge');
                    if (badge) {
                        badge.remove();
                    }

                    // تحديث كل إشعار
                    unreadItems.forEach(notification => {
                        // تغيير خلفية الإشعار
                        notification.style.background = '#f3f4f6';

                        // تغيير لون الأيقونة
                        const iconCircle = notification.querySelector(
                            '.d-flex.align-items-center.justify-content-center.rounded-circle');
                        if (iconCircle) {
                            iconCircle.style.background = '#f3f4f6';
                        }
                    });
                })
                .catch(error => console.error('❌ خطأ:', error));
        }
