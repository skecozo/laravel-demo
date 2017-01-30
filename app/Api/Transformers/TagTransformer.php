<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-24
 * Time: 13:42
 */

namespace App\Api\Transformers;

use App\Tag;
use League\Fractal\TransformerAbstract;
class TagTransformer extends TransformerAbstract
{
    public function transform(Tag $tag)
    {
        return [
            'id'=>$tag['id'],
            'text' => $tag['name'],


        ];
    }
}