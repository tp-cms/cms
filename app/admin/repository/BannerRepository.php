<?php

namespace app\admin\repository;

use app\model\Banner;

class BannerRepository extends BaseRepository
{
    protected Banner $banner;

    public function __construct()
    {
        $this->banner = new Banner();
    }
}
