<?php

namespace app\admin\controller;

use app\admin\service\ContactMessageService;
use think\App;
use think\facade\View;

class ContactMessage extends Base
{
    protected ContactMessageService $contactMessage;

    public function __construct(App $app)
    {
        $this->contactMessage = new ContactMessageService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@contactmessage/index');
    }
}
