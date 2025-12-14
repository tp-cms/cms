<?php

namespace app\admin\controller;

use app\admin\service\CustomerService;
use app\admin\validate\CustomerValidate;
use think\App;
use think\facade\View;

class Customer extends Base
{
    protected CustomerService $customer;
    protected CustomerValidate $customerValidate;

    public function __construct(App $app)
    {
        $this->customer = new CustomerService();
        $this->customerValidate = new CustomerValidate();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@customer/index');
    }
}