<?php

namespace app\admin\controller;

use app\admin\service\LinkService;
use think\App;
use think\facade\View;

class Link extends Base
{
    protected LinkService $link;

    public function __construct(App $app)
    {
        $this->link = new LinkService();
        return parent::__construct($app);
    }


    // 列表
    public function index() {}

    public function indexHtml()
    {
        return View::fetch('admin@link/index');
    }

    // 新增
    public function create() {}
}
