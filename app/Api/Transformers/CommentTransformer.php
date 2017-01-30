<?php

namespace App\Api\Transformers;

use App\Comment;
use League\Fractal\TransformerAbstract;


class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id'=>$comment->id,
            'content'=>$comment->content,
            'article_id'=>isset($comment->commentable->id)?$comment->commentable->id:'',
            'created_at'=> $comment->created_at,
            'user_name'=>$comment->user->name,
            'user_id'=>$comment->user->id,
            'user_avatar'=>$comment->user->avatar,
            'replys'=>isset($comment->comments) ?$comment->comments :''
        ];
    }
}