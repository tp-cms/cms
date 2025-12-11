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

    // 详情
    public function info($category)
    {
        return $this->page
            ->field('title,category,image,summary,content')
            ->where(['category' => $category])
            ->find();
    }

    // 保存
    public function save($data, $category)
    {
        return $this->page->save($data, ['category' => $category]);
    }
}
