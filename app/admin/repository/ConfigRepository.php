<?php

namespace app\admin\repository;

use app\model\Config;

class ConfigRepository extends BaseRepository
{
    protected Config $config;

    public function __construct()
    {
        $this->config = new Config();
    }
}
