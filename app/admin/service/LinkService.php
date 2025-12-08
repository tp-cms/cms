<?php

namespace app\admin\service;

use app\admin\repository\LinkRepository;

class LinkService extends BaseService
{
    protected LinkRepository $link;

    public function __construct()
    {
        $this->link = new LinkRepository();
    }
}
