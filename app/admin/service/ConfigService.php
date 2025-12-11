<?php

namespace app\admin\service;

use app\admin\repository\ConfigRepository;
use app\admin\repository\FileRepository;
use app\model\Config;

class ConfigService extends BaseService
{
    protected ConfigRepository $config;
    protected FileRepository $file;

    public function __construct()
    {
        $this->config = new ConfigRepository();
        $this->file = new FileRepository();
    }

    public function index()
    {
        $configs = $this->config->index();

        // 图片处理
        foreach ($configs as &$config) {
            if ($config['cfg_type'] == 'img') {
                $val = $config['cfg_val'];
                $config['cfg_val_file'] = $val ? $this->file->info($val) : [];
            }
        }

        return $configs;
    }
}
