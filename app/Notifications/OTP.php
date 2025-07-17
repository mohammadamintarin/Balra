<?php

namespace App\Notifications;

use App\Broadcasting\OTPChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTP extends Notification
{
    use Queueable;
    public $code;
    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [OTPChannel::class];
    }

    public function toSms($notifiable)
    {
        return $this->code;
    }
}
