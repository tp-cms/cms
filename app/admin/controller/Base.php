<?php

namespace app\admin\controller;

use app\BaseController;
use app\trait\JWTTrait;
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
                    'title' => 'Banner',
                    'url'   => '/' . $this->adminRoutePrefix . '/banner/index',
                ],
                [
                    'title' => '产品',
                    'url'   => '/' . $this->adminRoutePrefix . '/product/index',
                    'include' => [
                        '/' . $this->adminRoutePrefix . '/product/create',
                        '/' . $this->adminRoutePrefix . '/product/update/:id',
                    ]
                ],
                [
                    'title' => '新闻',
                    'url'   => '/' . $this->adminRoutePrefix . '/news/index',
                ],
                [
                    'title' => '案例',
                    'url'   => '/' . $this->adminRoutePrefix . '/project/index',
                ],
                [
                    'title' => '客户',
                    'url'   => '/' . $this->adminRoutePrefix . '/customer/index',
                ],
                [
                    'title' => '网站留言',
                    'url'   => '/' . $this->adminRoutePrefix . '/contact-message/index',
                ],
                [
                    'title' => '友情链接',
                    'url'   => '/' . $this->adminRoutePrefix . '/link/index',
                ],
                [
                    'title' => '单页',
                    'children' => [
                        [
                            'title' => '隐私政策',
                            'url'   => '/' . $this->adminRoutePrefix . '/page/privacy',
                        ],
                        [
                            'title' => '关于我们',
                            'url'   => '/' . $this->adminRoutePrefix . '/page/about-us',
                        ]
                    ]
                ],
                [
                    'title' => '系统',
                    'children' => [
                        [
                            'title' => '文件',
                            'url'   => '/' . $this->adminRoutePrefix . '/file/index',
                        ],
                        [
                            'title' => '配置',
                            'url'   => '/' . $this->adminRoutePrefix . '/config/index',
                        ],
                        [
                            'title' => '操作记录',
                            'url'   => '/' . $this->adminRoutePrefix . '/action-log/index',
                        ],
                    ]
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
