<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('cache.driver', 'file'),

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
            'expire'     => env('redis.expire', 300),
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
            'host'       => env('redis.host', '127.0.0.1'),
            'port'       => env('redis.port', 6379),
            'password'   => env('redis.password', ''),
            'select'     => env('redis.db', 0),
            'timeout'    => 2,
            'expire'     => env('redis.expire', 300), // 每个缓存有效期
            'prefix'     => 'tpcms_', // 缓存前缀防冲突
            'persistent' => env('redis.persistent', false),
        ]
    ],
];
