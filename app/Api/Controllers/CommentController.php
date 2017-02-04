<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-27
 * Time: 0:33
 */

namespace App\Api\Controllers;


use App\Api\Transformers\CommentTransformer;
use App\Http\Requests\CommentRequest;
use App\Notifications\ReceivedComment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PhpParser\Comment;

class CommentController extends ApiController
{

    protected $comment;

    /**
     * CommentController constructor.
     * @param CommentRepository $comment
     */
    public function __construct(CommentRepository $comment)
    {

        $this->comment = $comment;
    }
    public function article($id)
    {
         $comment=$this->comment->getByCommentable($id);
        return $this->Collection($comment,new CommentTransformer());
    }
    public function comment($id)
    {


    }
    public function store(CommentRequest $request)
    {
          $type=$this->comment->getModelNameFromType(request('type'));

        $data=[
            'commentable_id'=>$request->get('id'),
            'commentable_type'=>$type,
            'content'=>$request->get('content'),
            'user_id'=>$request->get('user_id'),
            'parent_id'=>$request->get('article_id')
        ];

        $comment= $this->comment->store($data);
        $comment->commentable->increment('comment_count');
        $comment->commentable->user->notify(new ReceivedComment($comment));
        return $this->item($comment,new CommentTransformer());
    }

    public function replystore(Request $request)
    {

        $type=$this->comment->getModelNameFromType(request('type'));
        $data=[
            'commentable_id'=>$request->get('id'),
            'commentable_type'=>$type,
            'content'=>$request->get('content'),
            'user_id'=>$request->get('user_id'),
            'parent_id'=>$request->get('article_id')
        ];
        $comment= $this->comment->store($data);
        return $this->item($comment,new CommentTransformer());

    }


    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {

       $comment= $this->comment->byArticleIds($id);

        return $this->Collection($comment,new CommentTransformer());

    }
    public function edit($id)
    {
        $this->comment->getbyIds($id);

    }
    public function update(CommentRequest $request,$id)
    {
        $comment=$this->comment->update($id, $request->all());

        return $this->item($comment,new CommentTransformer());

    }

    public function destroy($id)
    {
         $this->comment->getbyIds($id);

        $this->comment->destroy($id);

        return $this->noContent();
    }

}