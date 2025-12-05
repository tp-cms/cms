<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\App;

// [ 应用入口文件 ]

require __DIR__ . '/../vendor/autoload.php';

// .env 处理
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$envFile = $root . '.env';

$envName = 'prod';
if (!file_exists($envFile)) {
    die("环境配置文件不存在: {$envFile}");
}

// 环境名
$envName = trim(file_get_contents($envFile));

// 配置文件
$envConfigFile = $root . ".env.{$envName}";

if (!file_exists($envConfigFile)) {
    die("环境配置文件不存在: {$envConfigFile}");
}

$app = new App();
// 配置文件加载
$app->env->load($envConfigFile);

// 执行HTTP应用并响应
$http = $app->http;

$response = $http->run();

$response->send();

$http->end($response);
