<?php

use app\admin\middleware\Auth;
use think\facade\Route;

// 后台路由
$adminPrefix = adminRoutePrefix();

// 不需要登录的（页面）
Route::get($adminPrefix . '/login', A('User@login'));

// 不需要登录的（接口）
Route::group($adminPrefix . '/api', function () {
    // 验证码
    Route::get('captcha', A('Captcha@generate'));

    // 用户相关
    Route::post('user/login', A('User@login'));
    // 退出
    Route::post('user/logout', A('User@logout'));
});


// 需要登录的（页面）
Route::group($adminPrefix, function () {
    // 首页
    Route::get('/', A('Index@indexHtml'));

    // banner
    Route::get('banner/index', A('Banner@indexHtml'));

    // 产品
    Route::get('product/index', A('Product@indexHtml'));
    Route::get('product/create', A('Product@createHtml'));
    Route::get('product/update/:id', A('Product@updateHtml'));

    // 新闻
    Route::get('news/index', A('News@indexHtml'));
    Route::get('news/create', A('News@createHtml'));
    Route::get('news/update/:id', A('News@updateHtml'));

    // 案例
    Route::get('project/index', A('Project@indexHtml'));
    Route::get('project/create', A('Project@creaetHtml'));
    Route::get('project/update/:id', A('Project@updateHtml'));

    // 客户
    Route::get('customer/index', A('Customer@indexHtml'));
    Route::get('customer/create', A('Customer@createHtml'));
    Route::get('customer/update/:id', A('Customer@updateHtml'));

    // 网站留言
    Route::get('contact-message/index', A('ContactMessage@indexHtml'));
    Route::get('contact-message/update/:id', A('ContactMessage@updateHtml'));

    // 友情链接
    Route::get('link/index', A('Link@indexHtml'));
    Route::get('link/create', A('Link@createHtml'));
    Route::get('link/update/:id', A('Link@updateHtml'));

    // 文件
    Route::get('file/index', A('File@indexHtml'));

    // 配置
    Route::get('config/index', A('Config@indexHtml'));

    // 单页
    // 单页-关于我们
    Route::get('page/about-us', A('Page@aboutUsHtml'));
    // 单页-隐私政策
    Route::get('page/privacy', A('Page@privacyHtml'));

    // 操作记录
    Route::get('action-log/index', A('ActionLog@indexHtml'));

    // 用户
    Route::get('user/index', A('User@indexHtml'));
    Route::get('user/create', A('User@createHtml'));
    Route::get('user/update/:id', A('User@updateHtml'));
    Route::get('user/profile', A('User@profileHtml'));
})->middleware(Auth::class);


// 需要登录的（接口）
Route::group($adminPrefix . '/api', function () {
    // Banner
    Route::post('banner/index', A('Banner@index'));
    Route::post('banner/create', A('Banner@create'));
    Route::post('banner/update', A('Banner@update'));
    Route::post('banner/delete', A('Banner@delete'));

    // 产品
    Route::post('product/index', A('Product@index'));
    Route::post('product/create', A('Product@create'));
    Route::post('product/update', A('Product@update'));
    Route::post('product/delete', A('Product@delete'));

    // 新闻
    Route::post('news/index', A('News@index'));
    Route::post('news/create', A('News@create'));
    Route::post('news/update', A('News@update'));
    Route::post('news/delete', A('News@delete'));

    // 案例
    Route::post('project/index', A('Project@index'));
    Route::post('project/create', A('Project@create'));
    Route::post('project/update', A('Project@update'));
    Route::post('project/delete', A('Project@delete'));

    // 客户
    Route::post('customer/index', A('Customer@index'));
    Route::post('customer/create', A('Customer@create'));
    Route::post('customer/update', A('Customer@update'));
    Route::post('customer/delete', A('Customer@delete'));

    // 网站留言
    Route::post('contact-message/index', A('CcontactMessage@index'));

    // 友情链接
    Route::post('link/index', A('Link@index'));
    Route::post('link/create', A('Link@create'));
    Route::post('link/update', A('Link@update'));
    Route::post('link/delete', A('Link@delete'));

    // 文件
    Route::post('file/index', A('File@index'));
    // 上传 （file，wangeditor富文本使用，上传多文件时逻辑是循环请求上传接口）
    Route::post('file/upload', A('File@upload'));
    // 批量上传（files[]，弹出框使用)
    Route::post('file/upload-multiple', A('File@uploadMultiple'));
    Route::post('file/update', A('File@update'));
    Route::post('file/delete', A('File@delete'));

    // 配置
    Route::post('config/save', A('File@save'));

    // 单页
    // 单页-关于我们
    Route::post('page/about-us', A('Page@aboutUs'));
    // 单页-隐私政策
    Route::post('page/privacy', A('Page@privacy'));

    // 操作日志
    Route::post('action-log/index', A('ActionLog@index'));

    // 用户
    Route::post('user/index', A('User@index'));
    Route::post('user/create', A('User@create'));
    Route::post('user/update/:id', A('User@update'));
    Route::post('user/delete', A('User@delete'));
    Route::post('user/profile', A('User@profile'));
})->middleware(Auth::class);
