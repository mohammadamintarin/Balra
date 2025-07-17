<?php

namespace App\Notifications;

use App\Broadcasting\CallToSendCommentChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CallToSendComment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($product , $mobile , $name)
    {
        $this->product = $product;
        $this->mobile=$mobile;
        $this->name=$name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [CallToSendCommentChannel::class];
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

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toSms($notifiable)
    {
        return [$this->product , $this->mobile , $this->name];
    }
}
