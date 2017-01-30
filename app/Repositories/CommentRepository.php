<?php

namespace App\Repositories;

use App\Comment;

class CommentRepository
{
    use BaseRepository;
    /**
     * CommentRepository constructor.
     * @param Comment $comment
     */

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }



    /**
     * @param $name
     * @return mixed
     */

    public function byArticleIds($articleIds)
    {
        return  $this->model->where('article_id', $articleIds)->get();

    }

    public function getModelNameFromType($type)
    {
         return $type === 'article' ? 'App\Article': 'App\Comment';
    }

    public function getByCommentable($commentableId)
    {

       return $this->model->where('commentable_type','App\Article')->where('commentable_id',$commentableId)->get();
    }
}