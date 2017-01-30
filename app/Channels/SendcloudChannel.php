<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-01-18
 * Time: 4:20
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable,Notification $notification)
    {
        $message=$notification->toSendcloud($notifiable);
    }

}