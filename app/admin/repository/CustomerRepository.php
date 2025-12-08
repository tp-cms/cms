<?php

namespace app\admin\repository;

use app\model\Customer;

class CustomerRepository extends BaseRepository
{
    protected Customer $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }
}
