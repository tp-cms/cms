<?php

namespace app\admin\service;

use app\admin\repository\ConfigRepository;

class ConfigService extends BaseService
{
    protected ConfigRepository $config;

    public function __construct()
    {
        $this->config = new ConfigRepository();
    }
}
