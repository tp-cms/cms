<?php

namespace app\admin\controller;

use think\facade\View;

class Product extends Base
{
    public function indexHtml()
    {
        View::assign('content', '产品');
        return View::fetch('admin@product/index');
    }
}
