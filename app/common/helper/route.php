<?php

function R(string $controllerAction, $app = 'frontend'): string
{
    return "\\app\\{$app}\\controller\\{$controllerAction}";
}

// admin 用户路由前缀
function adminRoutePrefix(): string
{
    $prefix = strtolower(env('route.admin_prefix', 'tpcmsadmin'));


    // 如果为空字符串或 '/'，则置为默认值
    if ($prefix === '' || $prefix === '/') {
        $prefix = 'tpcmsadmin';
    }

    // 防止用户配置非法字符
    if (!preg_match('/^[a-z0-9\-_]+$/', $prefix)) {
        $prefix = 'tpcmsadmin';
    }

    // 避免和默认 admin 应用名冲突
    return $prefix === 'admin' ? 'tpcmsadmin' : $prefix;
}
