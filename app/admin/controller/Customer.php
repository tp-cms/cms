<?php

namespace app\admin\controller;

use app\admin\service\CustomerService;
use app\admin\service\FileCategoryService;
use app\admin\validate\CustomerValidate;
use think\App;
use think\facade\View;

class Customer extends Base
{
    protected CustomerService $customer;
    protected CustomerValidate $customerValidate;
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->customer = new CustomerService();
        $this->customerValidate = new CustomerValidate();
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    // 列表
    public function indexHtml()
    {
        return View::fetch('admin@customer/index');
    }

    public function index()
    {
        $page = input('post.p', 1);
        $keyword = input('post.keyword', '');
        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }
        $list = $this->customer->index($keyword, $page);
        return $this->suc($list);
    }

    // 新增
    public function createHtml()
    {
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@customer/create');
    }

    public function create()
    {
        $param = $this->request->post();
        if (!$this->customerValidate->scene('create')->check($param)) {
            return $this->err($this->customerValidate->getError());
        }

        $userID = $this->request->user['id'];
        $id = $this->customer->create($param, $userID);
        if (!$id) {
            return $this->err('保存失败');
        }

        return $this->suc();
    }


    // 更新
    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->customer->info($id);
        View::assign('info', $info);

        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@customer/update');
    }

    public function update()
    {
        $param = $this->request->post();
        if (!$this->customerValidate->scene('update')->check($param)) {
            return $this->err($this->customerValidate->getError());
        }

        $this->customer->update($param);
        return $this->suc();
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除客户');
        }

        // 是否选择正确
        $check = $this->customer->checkSelect($ids);
        if (!$check) {
            return $this->err('客户选择错误');
        }

        $this->customer->delete($ids);

        return $this->suc();
    }
}
