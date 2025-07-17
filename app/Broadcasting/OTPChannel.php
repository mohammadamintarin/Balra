<?php

namespace App\Broadcasting;

use App\Models\User;
use Ghasedak\GhasedakApi;
use Illuminate\Notifications\Notification;

class OTPChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        //
    }

    public function send($notifiable ,  Notification $notification)
    {
        $receptor = $notifiable->mobile;
        $template = "auth";
        $user = User::where('mobile' , $receptor)->first();
        $name = $user->name != null ? $user->name : 'کاربر گرامی' ;
        $code = $notification->code;
        $ghasedak =new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $ghasedak->Verify($receptor,$template,$code);

    }
}
