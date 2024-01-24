<?php

namespace App\Channels;

use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $receptor = $notifiable->cellphone;
        $type = GhasedakFacade::VERIFY_MESSAGE_TEXT;
        $template = "test";
        $param1 = $notification->code;

        $response = GhasedakFacade::setVerifyType($type)->Verify($receptor, $template, $param1);

    }
}
