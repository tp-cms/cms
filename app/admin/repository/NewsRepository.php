<?php

namespace app\admin\repository;

use app\model\News;

class NewsRepository extends BaseRepository
{
    protected News $news;

    public function __construct()
    {
        $this->news = new News();
    }
}
