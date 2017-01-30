<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-22
 * Time: 14:22
 */

namespace App\Api\Controllers;

use App\Api\Transformers\ArticleTransformer;
use App\Events\ArticleView;
use App\Http\Requests\ArticleRequest;
use App\Notifications\ArticleLike;
use App\Repositories\ArticleRepository;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use JWTAuth;

class ArticleController extends ApiController
{
    protected $article;



    public function __construct(ArticleRepository  $article)
    {

        $this->article =$article;

    }


    public function store(ArticleRequest $request)
    {

        $data = array_merge($request->all(), [
            'last_user_id' => $request->get('user_id'),
            'images'=>getimagesurl($request->get('content'))
        ]);

        $newArticle=$this->article->store($data);
        $newArticle->user->increment('contents_count');
        return $newArticle->tags()->attach(json_decode($request->get('tag')));

    }



    public function index(Request $request)
    {
       $style=$request->get('style');
         if($style){
             if(is_numeric($style)) {

                 $article =Tag::find($style)->articles;
                 return    $this->Collection($article,new ArticleTransformer());
             }
             $article = $this->article->page($number = 30, $sort = 'desc', $sortColumn = $style);
             return $this->paginator($article, new ArticleTransformer());
         }

        $article=$this->article->page();
        return   $this->paginator($article,new ArticleTransformer());
    }


    public function show($id)
    {

        $article=$this->article->getbyIds($id);
        Event::fire(new ArticleView($article));

        if(JWTAuth::getToken()){
            $user = JWTAuth::parseToken()->toUser();
            $meta=$this->article->checkAuthToken($article,$user);
            return $this->item($article,new ArticleTransformer())->addMeta('meta', $meta);
        }

        return  $this->item($article,new ArticleTransformer());
    }


    public function like($id)
    {
        $user=JWTAuth::parseToken()->authenticate();
         $article=$this->article->getbyIds($id);


        if($article->like->contains($user->id)) {
            $article->decrement('like_count');
            $user->decrement('likes_count');
        }
        else {
            $article->increment('like_count');
            $user->increment('likes_count');
            $article->user->notify(new ArticleLike($article));
        }
        $article->like()->toggle($user->id);

        return response()->json([
            'article_like_count' => $article->like_count,
            'user_like_count' => $user->likes_count
        ]);

    }

    public function serach(Request $request)
    {
         $key = trim($request->get('serachdata'));

        if ($key == ''){
            return response()->json([
                'error' => ["请输入关键字"],
            ], 401);
        }

          $key = "%$key%";

           $article=$this->article->serachByKey($key);
       return $this->Collection($article,new ArticleTransformer());

    }

}