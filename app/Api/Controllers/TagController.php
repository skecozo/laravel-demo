<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-24
 * Time: 13:39
 */

namespace App\Api\Controllers;


use App\Repositories\TagRepository;
use App\Api\Transformers\TagTransformer;
class TagController extends ApiController
{

    protected $tag;


    public function __construct(TagRepository $tag)
    {

        $this->tag = $tag;
    }

    public function index()
    {
        $tag  = $this->tag->all();

        return $this->collection($tag,new TagTransformer());
    }
}