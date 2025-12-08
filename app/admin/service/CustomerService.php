<?php

namespace app\admin\service;

use app\admin\repository\CustomerRepository;

class CustomerService extends BaseService
{
    protected CustomerRepository $customer;

    public function __construct()
    {
        $this->customer = new CustomerRepository();
    }
}
