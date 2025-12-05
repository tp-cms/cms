<?php

// 后台路由

use think\facade\Route;

$adminPrefix = adminRoutePrefix();

// 不需要登录的
Route::group($adminPrefix . '/api', function () {
    Route::post('user/login', R('User@login', 'admin'));
    // 验证码
    Route::get('captcha', R('Captcha@generate', 'admin'));
});


// 需要登录的（页面）
Route::group($adminPrefix, function () {
    Route::get('/', R('Index@indexHtml', 'admin'));
    Route::get('login', R('User@login', 'admin'));
    Route::get('product', R('Product@indexHtml', 'admin'));
});


// 需要登录的（接口）
Route::group($adminPrefix . '/api', function () {});
