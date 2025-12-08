<?php

namespace app\admin\service;

use app\admin\repository\PageRepository;

class PageService extends BaseService
{
    protected PageRepository $page;

    public function __construct()
    {
        $this->page = new PageRepository();
    }
}
