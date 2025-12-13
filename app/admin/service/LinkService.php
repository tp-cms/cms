<?php

namespace app\admin\service;

use app\admin\repository\LinkRepository;

class LinkService extends BaseService
{
    protected LinkRepository $link;

    public function __construct()
    {
        $this->link = new LinkRepository();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->link->index($keyword, $page, $perPage);
    }

    // 新增
    public function create($data)
    {
        $linkData = [
            'title' => $data['title'],
            'url' => $data['url'],
        ];
        return $this->link->create($linkData);
    }

    // 详情
    public function info($id)
    {
        return $this->link->info($id);
    }

    // 更新
    public function update($id, $data)
    {
        $linkData = [
            'title' => $data['title'],
            'url' => $data['url'],
        ];
        return $this->link->update($id, $linkData);
    }

    // 删除
    public function delete($ids)
    {
        return $this->link->delete($ids);
    }

    public function dublicate($url, $id = 0)
    {
        return $this->link->dublicate($url, $id);
    }
}
