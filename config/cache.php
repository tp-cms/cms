<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('CACHE_DRIVER', 'file'),

    // 缓存连接方式配置
    'stores'  => [
        'file' => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => runtime_path('cache'),
            // 缓存前缀
            'prefix'     => 'tpcms_',
            // 缓存有效期 0表示永久缓存
            'expire'     => 300,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        // 更多的缓存连接

        // redis
        // github https://github.com/phpredis/phpredis
        // php扩展下载地址 https://pecl.php.net/package/redis
        'redis' => [
            'type'       => 'redis',
            'host'       => env('REDIS_HOST', '127.0.0.1'),
            'port'       => env('REDIS_PORT', 6379),
            'password'   => env('REDIS_PASSWORD', ''),
            'select'     => env('REDIS_DB', 0),
            'timeout'    => 2,
            'expire'     => env('REDIS_EXPIRE', 300), // 每个缓存有效期
            'prefix'     => 'tpcms_', // 缓存前缀防冲突
            'persistent' => env('REDIS_PERSISTENT', false),
        ]
    ],
];
