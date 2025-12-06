<?php
// +----------------------------------------------------------------------
// | 控制台配置
// +----------------------------------------------------------------------
return [
    // 指令定义
    'commands' => [
        // 环境切换
        'app\command\Env', // 如果使用 'xxx' => 'app\command\xxx' 时，指定的setName('xxx') 会被这里的键覆盖,
        // 管理员创建、修改密码
        'app\command\User',
        // repository
        'app\command\Repository',
        // service
        'app\command\Service',
        // controller
        'app\command\Controller',
        // model
        'app\command\Model',
    ],
];
