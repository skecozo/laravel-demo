<?php

namespace App\Api\Transformers;
use App\User;
use League\Fractal\TransformerAbstract;


class LessonTransformer extends TransformerAbstract
{
    public function transform(User $lesson)
    {
        return [
            'name1' => $lesson['name'],
            'email' =>  $lesson['email'],
            'avatar' =>  'http://blog.hd/'.$lesson['avatar']
        ];
    }
}