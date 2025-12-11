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

    // 配置信息
    public function index()
    {
        return $this->config->column('cfg_label,cfg_key,cfg_val,cfg_type', 'id');
    }
}
