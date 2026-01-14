<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ApplicationAcceptedNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $projectTitle;

    public function __construct($projectTitle, $status = null)
    {
        $this->projectTitle = $projectTitle;
        $this->status = $status ?? 'تم التحديث'; // افتراضي
    }


    public function via($notifiable): array
    {
        return ['database', 'broadcast']; // تخزين في قاعدة البيانات + بث مباشر
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => "تغير حالة المشروع",
            'message' => "حالة مشروع '{$this->projectTitle}' تغيرت إلى: {$this->status}",
            'url' => '/projects/my-projects', // يمكن تغييره حسب الصفحة المناسبة
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => "تغير حالة المشروع",
            'message' => "حالة مشروع '{$this->projectTitle}' تغيرت إلى: {$this->status}",
            'url' => '/projects/my-projects',
        ]);
    }
}
