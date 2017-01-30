<?php

namespace App\Repositories;

use App\User;



class UserRepository
{

    use BaseRepository;

    public function __construct(User $user)
    {
        $this->model = $user;
    }




    public function getByGithubId($githubId)
    {
        return $this->model->where('github_id', $githubId)->first();
    }


}