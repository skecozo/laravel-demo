<?php

namespace App\Repositories;

use App\Article;
use App\Repositories\Traits\RecordsActivity;


class ArticleRepository
{

    use BaseRepository;

    public function __construct(Article $article)
    {

        $this->model = $article;

    }

    public function page($number = 30, $sort = 'desc', $sortColumn = 'created_at')
    {

        return $this->model->orderBy($sortColumn, $sort)->paginate($number);

    }

    public function getbyTag($id)
    {
        return $this->model->tags()->where('tag_id',$id)->get();
    }



    public function checkAuthToken($article,$user)
    {

        $islike=$article->like->where('id',$user->id)->count();

        $isfollower=$user->followings->where('id',$article->user_id)->count();

        $meta=[
            'islike'=>$islike,
            'isfollower'=>$isfollower
        ];
        return $meta;

    }

    public function serachByKey($key)
    {
        return   Article::where('title', 'like', $key)
        ->orWhere('content', 'like', $key)
        ->orderBy('visit_count', 'desc')
        ->get();


    }




}