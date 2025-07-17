<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

class Telegram extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($id , $name ,$family, $mobile , $address , $variation ,$quantity, $image,$time  , $note)
    {
        $this->id = $id;
        $this->name = $name;
        $this->family = $family;
        $this->mobile = $mobile;
        $this->address = $address;
        $this->variation = $variation;
        $this->quantity = $quantity;
        $this->image = $image;
        $this->time = $time;
        $this->note = $note;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ["telegram"];
    }

    public function toTelegram($notifiable)
    {
        return TelegramFile::create()
            ->to('-1002490766408')
            ->content( "#️⃣" . " " . "سفارش:" . " " . "*" . "$this->id" . "*" . "\n" .
                "🕰" . "زمان:" . " " . "$this->time" . "\n" .
                "⚖️" . " " . "مقدار:" . " " . "$this->variation" .  "\n" .
                "🥡" . " " . "تلفن همراه:" . " " . "$this->mobile" . "\n" .
                "🗿" . " " . "نام و نام خانوادگی:" . " " . "$this->name" . " " ."$this->family" . "\n" .
                "☎️" . " " . "تلفن همراه:" . " " . "$this->mobile" . "\n" .
                "🏠" . " " . "آدرس:" . " " . "$this->address" . "\n" .
                "📝" . " " . "یادداشت:" . " " . "$this->note"
            )
            ->file("$this->image", "photo");



        // (Optional) Inline Buttons
        // (Optional) Inline Button with callback. You can handle callback in your bot instance
//            ->buttonWithCallback('Confirm', 'confirm_invoice ');
    }
}
