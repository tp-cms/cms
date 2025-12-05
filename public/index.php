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

use app\common\util\EnvUtil;
use think\App;

// [ 应用入口文件 ]

require __DIR__ . '/../vendor/autoload.php';

$evnUtil = new EnvUtil();
$envConfigFile = $evnUtil->getEnvConfigFile();

$app = new App();
// 配置文件加载
$app->env->load($envConfigFile);

// 执行HTTP应用并响应
$http = $app->http;

$response = $http->run();

$response->send();

$http->end($response);
