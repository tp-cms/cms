<?php

namespace app\admin\service;

use app\admin\repository\FileRepository;
use app\admin\repository\PageRepository;
use app\model\Page;

class PageService extends BaseService
{
    protected PageRepository $page;
    protected FileRepository $file;

    public function __construct()
    {
        $this->page = new PageRepository();
        $this->file = new FileRepository();
    }

    // 判断下category是否存在
    public function checkCategory($category)
    {
        return in_array($category, [
            Page::pageAbout,
            Page::pagePrivacy,
        ]);
    }

    // info
    public function info($category)
    {
        $info =  $this->page->info($category);
        // 图片处理
        $info->image_file = [];
        if ($info->image) {
            $info->image_file = $this->file->info($info->image);
        }
        return $info->toArray();
    }
}
