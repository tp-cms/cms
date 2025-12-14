<?php

namespace app\admin\controller;

use app\admin\service\NewsService;
use app\admin\validate\NewsValidate;
use think\App;
use think\facade\View;

class News extends Base
{
    protected NewsService $news;
    protected NewsValidate $newsValidate;

    public function __construct(App $app)
    {
        $this->news = new NewsService();
        $this->newsValidate = new NewsValidate();
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

        $list = $this->news->index($keyword, $page);
        $this->suc($list);
    }

    public function indexHtml()
    {
        return View::fetch('admin@news/index');
    }
}
