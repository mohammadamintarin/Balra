<?php

namespace App\Broadcasting;

use App\Models\User;
use Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class CallToBuyChannel
{
    public function send($notifiable , Notification $notification)
    {
        $receptor = $notification->mobile;
        $template = "NivorCallToBuy";
        $param1 = $notification->name;
        $param2 = $notification->product;
        $sms = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $sms->verify($receptor, $template, $param1 , $param2);
    }
}
