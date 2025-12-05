<?php

// admin 用户路由前缀
function adminRoutePrefix(): string
{
    $prefix = strtolower(env('ROUTE_ADMIN_PREFIX', 'tpcmsadmin'));

    // 防止用户配置非法字符
    if (!preg_match('/^[a-z0-9\-_]+$/', $prefix)) {
        $prefix = 'tpcmsadmin';
    }

    // 避免和默认 admin 应用名冲突
    return $prefix === 'admin' ? 'tpcmsadmin' : $prefix;
}
