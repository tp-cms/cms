<?php

namespace app\admin\controller;

use app\admin\service\CustomerService;
use think\App;
use think\facade\View;

class Customer extends Base
{
    protected CustomerService $customer;

    public function __construct(App $app)
    {
        $this->customer = new CustomerService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@customer/index');
    }
}