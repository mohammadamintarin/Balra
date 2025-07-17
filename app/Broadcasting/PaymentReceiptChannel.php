<?php

namespace App\Broadcasting;

use App\Models\User;
use Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class PaymentReceiptChannel
{
    public function send($notifiable , Notification $notification)
    {
        $receptor = $notifiable->mobile;
        $template = "paymentReceipt";
        $param1 = $notification->orderId;
        $param2 = $notifiable->name;
        $sms = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $sms->verify($receptor, $template, $param1 , $param2);
    }
}
