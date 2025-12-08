<?php

namespace app\admin\repository;

use app\model\Link;

class LinkRepository extends BaseRepository
{
    protected Link $link;

    public function __construct()
    {
        $this->link = new Link();
    }
}
