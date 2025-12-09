<?php

namespace app\admin\repository;

use app\model\Page;

class PageRepository extends BaseRepository
{
    protected Page $page;

    public function __construct()
    {
        $this->page = new Page();
    }

    // info
    public function info($category)
    {
        return $this->page
            ->field('title,category,image,summary,content')
            ->where(['category' => $category])
            ->find();
    }
}
