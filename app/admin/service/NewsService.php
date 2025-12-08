<?php

namespace app\admin\service;

use app\admin\repository\NewsRepository;

class NewsService extends BaseService
{
    protected NewsRepository $news;

    public function __construct()
    {
        $this->news = new NewsRepository();
    }
}
