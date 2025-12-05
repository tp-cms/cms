<?php

namespace app\admin\controller;

use app\admin\trait\JWTTrait;
use app\BaseController;
use app\trait\ResponseTrait;
use think\facade\Cache;
use think\facade\View;

class Base extends BaseController
{
    use JWTTrait;
    use ResponseTrait;

    // 后台路由前缀
    protected $adminRoutePrefix;
    // 菜单
    protected $menu;

    public function initialize()
    {
        $this->adminRoutePrefix = adminRoutePrefix();

        // 先在缓存中读取下
        $menu = Cache::get('admin_menu');
        if ($menu) {
            $this->menu = $menu;
        } else {
            $menu = [
                [
                    'title' => '首页',
                    'url'   => '/' . $this->adminRoutePrefix,
                ],
                [
                    'title' => '产品列表',
                    'url'   => '/' . $this->adminRoutePrefix . '/product',
                ]
            ];

            Cache::set('admin_menu', $menu, 60 * 60);
        }

        setActiveMenu($menu);
        $this->menu = $menu;

        View::assign('baseConfig', [
            'adminRoutePrefix' => $this->adminRoutePrefix,
            'copyright' => [
                'year' => date('Y')
            ],
            'menu' => $this->menu,
        ]);
        return parent::initialize();
    }
}
