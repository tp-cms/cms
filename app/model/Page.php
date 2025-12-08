<?php

namespace app\model;

class Page extends Base
{
    protected $table = 'page';

    // 单页信息
    // 关于我们
    public const pageAbout = 'about_us';
    // 隐私政策
    public const pagePrivacy = 'privacy';
}
