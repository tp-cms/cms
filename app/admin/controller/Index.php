<?php

namespace app\admin\controller;

use think\facade\View;

class Index extends Base
{
    public function indexHtml()
    {
        View::assign('content', '首页');
        return View::fetch('admin@index/index');
    }
}
