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

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email'=>$user->email,
            'avatar' => $user->avatar,
            'created_at'=>$user->created_at->toDateTimeString(),
            'contents_count'=> isset($user->contents_count) ? $user->contents_count : 0,
            'favorites_count'=>isset($user->favorites_count) ? $user->favorites_count : 0,
            'likes_count'=>isset($user->likes_count) ? $user->likes_count : 0,
            'followers_count'=>isset($user->followers_count) ? $user->followers_count : 0,
            'followings_count'=>isset($user->followings_count) ? $user->followings_count : 0,



        ];
    }
}