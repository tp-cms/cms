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
}
