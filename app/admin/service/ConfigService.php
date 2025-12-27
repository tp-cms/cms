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

    // 配置信息
    public function index()
    {
        $configs = $this->config->index();

        // 图片处理
        foreach ($configs as &$config) {
            if ($config['cfg_type'] == 'img') {
                $val = $config['cfg_val'];
                $config['cfg_val_file'] = $val ? $this->file->pathInfo($val) : [];
            }
        }

        return $configs;
    }

    // 检查下配置键是否存在
    public function checkKey($key)
    {
        return in_array($key, [
            Config::configKeyTitle,
            Config::configKeyKeywords,
            Config::configKeyDescription,
            Config::configKeyLogo,
            Config::configKeyPhone,
            Config::configKeyEmail,
            Config::configKeyAddress,
            Config::configKeyQQ,
            Config::configKeyWechat,
            Config::configKeyDouyin,
            Config::configKeyCompany,
            Config::configKeyICP,
            Config::configkeyBaiduB2b,
        ]);
    }

    // 保存
    public function save($param)
    {
        // 图片处理
        if ($param['logo']) {
            $logoInfo = $this->file->pathInfo($param['logo']);
            if (!$logoInfo) {
                $param['logo'] = 0;
            }
        }

        // 抖音二维码
        if ($param['douyin']) {
            $douyinInfo = $this->file->pathInfo($param['douyin']);
            if (!$douyinInfo) {
                $param['douyin'] = 0;
            }
        }

        // 微信二维码
        if ($param['wechat']) {
            $wechatInfo = $this->file->pathInfo($param['wechat']);
            if (!$wechatInfo) {
                $param['wechat'] = 0;
            }
        }

        foreach ($param as $key => $val) {
            if ($this->checkKey($key)) {
                $this->config->save(['cfg_val' => $val], $key);
            }
        }

        return true;
    }
}
