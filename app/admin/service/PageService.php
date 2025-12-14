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

    // 详情
    public function info($category)
    {
        $info =  $this->page->info($category);
        // 图片处理
        $info->image_file = [];
        if ($info->image) {
            $imageInfo = $this->file->info($info->image);
            if ($imageInfo) {
                $info->image_file = $imageInfo;
            } else {
                $info->image = 0;
            }
        }
        return $info->toArray();
    }

    // 保存
    public function save($data, $category)
    {
        // 文件信息处理
        $image = $data['image'];
        if ($image) {
            $imageFile = $this->file->info($data['image']);
            if (!$imageFile) {
                $data['image'] = 0;
            }
        }
        return $this->page->save($data, $category);
    }
}
