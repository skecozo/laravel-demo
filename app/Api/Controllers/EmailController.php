<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-16
 * Time: 0:20
 */

namespace App\Api\Controllers;


use App\User;

class EmailController extends BaseController
{

    public function verify($token)
    {
        $user=User::where('confirmation_token',$token)->first();

        if(!is_null($user))
        {
            $user->is_active=1;

           // $user->confirmation_token=str_random(48);
            $user->save();
        }
          return redirect()->to('/login')->with('message','请登录');
    }
}