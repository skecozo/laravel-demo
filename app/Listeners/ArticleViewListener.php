<?php

namespace App\Listeners;

use App\Events\ArticleView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;

class ArticleViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  ArticleView  $event
     * @return void
     */
    public function handle(ArticleView $event)
    {
        $article = $event->article;
        //先进行判断是否已经查看过
        if (!$this->hasViewedArticle($article)) {
            //保存到数据库
           $article->increment('visit_count');
            $article->save();
            //看过之后将保存到 Session
            $this->storeViewedArticle($article);
        }
    }
    protected function hasViewedArticle($article)
    {
        return array_key_exists($article->id, $this->getViewedArticle());
    }
    protected function getViewedArticle()
    {
        return $this->session->get('viewed_Article', []);
    }
    protected function storeViewedArticle($article)
    {
        $key = 'viewed_Article.'.$article->id;

        $this->session->put($key, time());
    }
}
