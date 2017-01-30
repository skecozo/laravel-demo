<?php

namespace App\Repositories;

use App\Activity;


class ActivityRepository
{


    use BaseRepository;

    public function __construct(Activity $activity)
    {

        $this->model = $activity;

    }


    public function byUserIds($userIds)
    {

        return  $this->model->where('user_id', $userIds)->orderBy('created_at', 'desc')->get();

    }


}