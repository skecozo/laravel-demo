<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-01-18
 * Time: 15:56
 */

namespace App\Services\Mailer;


class UserMailer extends Mailer
{

    public function sendVerifyEmail($user)
    {
        $data=[
            'url'=>route('email.verify',['token'=>$user->confirmation_token]),
            'name'=>$user->name
        ];

        $this->sendTo('welcome',$user->email,$data);
    }


    public function ReceivedNotifyEmail($email)
    {
        $data=['url'=>'http://www.w00000.top','name'=>'skecozo'];

        $this->sendTo('welcome',$email,$data);
    }
}