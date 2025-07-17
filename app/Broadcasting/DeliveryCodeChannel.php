<?php

namespace App\Broadcasting;

use App\Models\User;
use Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class DeliveryCodeChannel
{
    public function send($notifiable , Notification $notification)
    {
        $receptor = $notification->mobile;
        $template = "DeliveryCode";
        $param1 = $notification->code;
        $param2 = $notification->name;
        $sms = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $sms->verify($receptor, $template, $param1 , $param2);
    }
}
