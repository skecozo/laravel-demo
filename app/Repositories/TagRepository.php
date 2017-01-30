<?php

namespace App\Repositories;

use App\Tag;

class TagRepository
{


    use BaseRepository;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }





}