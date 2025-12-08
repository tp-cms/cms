<?php

namespace app\admin\service;

use app\admin\repository\BannerRepository;

class BannerService extends BaseService
{
    protected BannerRepository $banner;

    public function __construct()
    {
        $this->banner = new BannerRepository();
    }
}
