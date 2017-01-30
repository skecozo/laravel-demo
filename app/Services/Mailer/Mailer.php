<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-01-18
 * Time: 15:51
 */

namespace App\Services\Mailer;


use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
   public function sendTo($template,$email,array $data)
   {

       $content=new SendCloudTemplate($template,$data);

       Mail::raw($content, function ($message) use($email) {

           $message->from('876645@qq.com', 'admin');

           $message->to($email);
       });
   }

}