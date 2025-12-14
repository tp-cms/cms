<?php

namespace app\admin\controller;

use app\admin\service\LinkService;
use app\admin\validate\LinkValidate;
use think\App;
use think\facade\View;

class Link extends Base
{
    protected LinkService $link;
    protected LinkValidate $linkValidate;

    public function __construct(App $app)
    {
        $this->link = new LinkService();
        $this->linkValidate = new LinkValidate();
        return parent::__construct($app);
    }

    // 列表
    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.p', 1);
        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->link->index($keyword, $page);
        $this->suc($list);
    }

    public function indexHtml()
    {
        return View::fetch('admin@link/index');
    }

    // 新增
    public function create()
    {
        $param = $this->request->post();
        if (!$this->linkValidate->scene('create')->check($param)) {
            return $this->err($this->linkValidate->getError());
        }

        $userID = $this->request->user['id'];
        $id = $this->link->create($param, $userID);

        if (!$id) {
            return $this->err('保存失败');
        }

        return $this->suc();
    }

    public function createHtml()
    {
        return View::fetch('admin@link/create');
    }

    // 更新
    public function update()
    {
        $param = $this->request->post();
        if (!$this->linkValidate->scene('update')->check($param)) {
            return $this->err($this->linkValidate->getError());
        }

        $this->link->update($param);
        return $this->suc();
    }

    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->link->info($id);
        View::assign('info', $info);
        return View::fetch('admin@link/update');
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除的链接');
        }

        // 是否选择正确
        $check = $this->link->checkSelect($ids);
        if (!$check) {
            return $this->err('链接选择错误');
        }

        $this->link->delete($ids);

        return $this->suc();
    }
}
