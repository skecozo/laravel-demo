<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-22
 * Time: 14:22
 */

namespace App\Api\Controllers;


use App\Api\Transformers\ActivityTransformer;
use App\Repositories\ActivityRepository;
use JWTAuth;

class ActivityController extends ApiController
{
    protected $activity;


    public function __construct(ActivityRepository $activity)
    {

        $this->activity = $activity;
    }

    public function show()
    {

        $id=JWTAuth::parseToken()->authenticate()->id;
        $activities=$this->activity->byUserIds($id);
        return $this->Collection($activities,new ActivityTransformer());

    }

}