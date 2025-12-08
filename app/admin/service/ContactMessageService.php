<?php

namespace app\admin\service;

use app\admin\repository\ContactMessageRepository;

class ContactMessageService extends BaseService
{
    protected ContactMessageRepository $contactMessage;

    public function __construct()
    {
        $this->contactMessage = new ContactMessageRepository();
    }
}
