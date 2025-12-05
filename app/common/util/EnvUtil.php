<?php

namespace app\common\util;

class EnvUtil
{
    protected $root;
    protected $envFile;
    protected $envName;
    protected $envConfigFile;

    public function __construct()
    {
        $this->root = root_path();
        $this->envFile = $this->root . '.env';
        $this->envName = 'prod';  // 默认环境为 prod

        $this->load();
    }

    protected function load()
    {
        // 检查 .env 文件是否存在
        if (!file_exists($this->envFile)) {
            die("环境配置文件不存在: {$this->envFile}");
        }

        // 获取环境名称
        $this->envName = trim(file_get_contents($this->envFile));

        // 检查对应的环境配置文件是否存在
        $this->envConfigFile = $this->root . ".env.{$this->envName}";
        if (!file_exists($this->envConfigFile)) {
            die("环境配置文件不存在: {$this->envConfigFile}");
        }
    }

    public function getEnvName()
    {
        return $this->envName;
    }

    public function getEnvConfigFile()
    {
        return $this->envConfigFile;
    }
}
