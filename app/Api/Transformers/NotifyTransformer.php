<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-16
 * Time: 0:20
 */

namespace App\Api\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class NotifyTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [

            'unreadnotify'=>$user->unreadNotifications,
            'notify'=>$user->Notifications,


        ];
    }
}