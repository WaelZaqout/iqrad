<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestorPayNotification extends Notification
{
    use Queueable;
    protected $projectTitle;
    protected $investorName;
    protected $amount; // أضفنا المتغير

    /**
     * Create a new notification instance.
     */
    public function __construct($projectTitle, $investorName, $amount)
    {
        $this->projectTitle = $projectTitle;
        $this->investorName = $investorName;
        $this->amount = $amount; // حفظ المبلغ
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => "تم الدفع من المستثمر",
            'message' => "المستثمر '{$this->investorName}' قام بالدفع لمشروع '{$this->projectTitle}' بمبلغ {$this->amount} ريال",
            'url' => '/projects/investor-payments', // يمكن تغييره حسب الصفحة المناسبة
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

            'projectTitle' => $this->projectTitle,
            'investorName' => $this->investorName,
            'amount' => $this->amount,
        ];
    }
}
