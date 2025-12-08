<?php

namespace app\admin\controller;

use think\facade\View;

class ProductCategory extends Base
{
    public function indexHtml()
    {
        return View::fetch('admin@productcategory/index');
    }
}