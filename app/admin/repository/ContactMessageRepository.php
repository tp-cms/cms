<?php

namespace app\admin\repository;

use app\model\ContactMessage;

class ContactMessageRepository extends BaseRepository
{
    protected ContactMessage $contactMessage;

    public function __construct()
    {
        $this->contactMessage = new ContactMessage();
    }
}
