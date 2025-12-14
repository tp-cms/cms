<?php

namespace app\admin\controller;

use app\admin\service\ContactMessageService;
use app\admin\validate\ContactMessageValidate;
use think\App;
use think\facade\View;

class ContactMessage extends Base
{
    protected ContactMessageService $contactMessage;
    protected ContactMessageValidate $contactMessageValidate;

    public function __construct(App $app)
    {
        $this->contactMessage = new ContactMessageService();
        $this->contactMessageValidate = new ContactMessageValidate();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@contactmessage/index');
    }

    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.page', 1);
        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->contactMessage->index($keyword, $page);
        return $this->suc($list);
    }

    // 更新
    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->contactMessage->info($id);
        View::assign('info', $info);
        return View::fetch('admin@contactmessage/update');
    }

    public function update()
    {
        $param = $this->request->post();
        if (!$this->contactMessageValidate->scene('update')->check($param)) {
            return $this->err($this->contactMessageValidate->getError());
        }

        $status = in_array($param['status'], [0, 1, 2]) ? $param['status'] : 0;
        $this->contactMessage->updateStatus($param['id'], $status);
        return $this->suc();
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids');
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除留言');
        }

        // 是否选择正确
        $check = $this->contactMessage->checkSelect($ids);
        if (!$check) {
            return $this->err('留言选择错误');
        }

        $this->contactMessage->delete($ids);

        return $this->suc();
    }
}
