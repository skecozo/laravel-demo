<?php

namespace App\Api\Transformers;
use App\Article;
use League\Fractal\TransformerAbstract;


class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
        return [
            'id'     => $article->id,
            'title'  => $article->title,
            'content'=> $article->content,
            'images'=>isset($article->images) ? collect(json_decode($article->images)) : '',
            'visit_count'=>$article->visit_count,
            'like_count'=>$article->like_count,
            'comment_count'=>isset($article->comment_count)? $article->comment_count : '',
            'created_at'    => $article->created_at->diffForHumans(),
            'published_time'   => $article->created_at->toDateTimeString(),
            'user_id'   => $article->user->id,
            'user_name'   => $article->user->name,
            'user_avatar'   => $article->user->avatar,
            'user_followings_count'=> $article->user->followings_count,
            'user_likes_count'=> $article->user->likes_count,




        ];
    }
}