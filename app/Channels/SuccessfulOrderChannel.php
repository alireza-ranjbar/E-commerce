<?php

namespace App\Channels;

use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Notifications\Notification;

class SuccessfulOrderChannel
{
    public function send($notifiable, Notification $notification)
    {

        $receptor = $notifiable->cellphone;
        $type = GhasedakFacade::VERIFY_MESSAGE_TEXT;
        $template = "SuccessfulPayment";
        //$param1 = $notifiable->name;
        $param1 = $notification->orderId;
        $param2 = $notification->amount;
        $param3 = $notification->refId;

        $response = GhasedakFacade::setVerifyType($type)->Verify($receptor, $template, $param1, $param2, $param3);

    }
}
