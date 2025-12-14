<?php

namespace app\admin\service;

use app\admin\repository\ContactMessageRepository;
use app\model\ContactMessage;

class ContactMessageService extends BaseService
{
    protected ContactMessageRepository $contactMessage;

    public function __construct()
    {
        $this->contactMessage = new ContactMessageRepository();
    }

    // 列表
    public function index($keywrod = '', $page = 1, $perPage = 20)
    {
        return $this->contactMessage->index($keywrod, $page, $perPage);
    }

    // 详情
    public function info($id)
    {
        return $this->contactMessage->info($id);
    }

    // 检查状态
    public function checkStatus($status)
    {
        return in_array($status, [
            ContactMessage::ContactMessageStatusDefault,
            ContactMessage::ContactMessageStatusRead,
            ContactMessage::ContactMessageStatusUseless,
        ]);
    }

    // 更新状态
    public function updateStatus($id, $status)
    {
        return $this->contactMessage->update($id, $status);
    }
}
