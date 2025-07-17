<?php

namespace App\Broadcasting;

use App\Models\User;
use Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class CallToSendCommentChannel
{
    /**
     * Create a new channel instance.
     */
    public function send($notifiable , Notification $notification)
    {
        $receptor = $notification->mobile;
        $name = $notification->name;
        $product = $notification->product . "#comments";
        $message= $name ." " . "جان،" . PHP_EOL . "از لباسی که خریدین راضی هستین؟ 😍" . PHP_EOL . "برامون از لینک زیر کامنت بذار و نظرت رو برای بقیه بگو:" . PHP_EOL . $product . PHP_EOL . "همچنین با ثبت کامنت از طرف فروشگاه نیور کد تخفیف هدیه بگیر 🤩";
        $linenumber = "10008566";
        $sms = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $sms->SendSimple($receptor, $message, $linenumber);
   }
}
