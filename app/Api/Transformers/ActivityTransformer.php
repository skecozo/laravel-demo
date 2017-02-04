<?php

namespace App\Api\Transformers;


use App\Activity;

use League\Fractal\TransformerAbstract;


class ActivityTransformer extends TransformerAbstract
{
    public function transform(Activity $activity)
    {
        return [
            'id'     => $activity->id,
            'user_id'=>$activity->user_id,
            'name' => $activity->user->name,
            'conversation_type'=>class_basename($activity->conversation_type),
            'created_at'=>$activity->created_at->toDateTimeString(),
            'conversation_content'=>isset($activity->conversation->content)?str_limit($activity->conversation->content,50):'',
            'conversation_content_count'=>isset($activity->conversation->comments)?collect($activity->comments)->count():'',
            'conversation_title'=>isset($activity->conversation->title) ? $activity->conversation->title : '',
            'conversation_id'=>isset($activity->conversation->id) ? $activity->conversation->id : '',

            'conversation_article'=> isset($activity->conversation)?$activity->conversation->article :'',
         //   'conversation_article_id'=> isset($activity->conversation->article->id)?$activity->conversation->article->id :'',
         //   'conversation_article_user_name'=> isset($activity->conversation->article->user->name)?$activity->conversation->article->user->name:'',
       //     'conversation_article_user_content'=> isset($activity->conversation->article->content)? str_limit($activity->conversation->article->content,50):'',
        //    'conversation_article_user_title'=> isset($activity->conversation->article->title)? $activity->conversation->article->title:'',







        ];
    }
}