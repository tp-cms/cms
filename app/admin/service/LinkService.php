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

    // 链接是否重复
    public function duplicate($url, $id = 0)
    {
        return $this->link->duplicate($url, $id);
    }

    // 详情
    public function info($id)
    {
        $info =  $this->link->info($id);
        if (!$info) {
            return [];
        }
        return $info->toArray();
    }

    // 添加
    public function create($data, $userID)
    {
        $linkData = [
            'title' => $data['title'],
            'url' => $data['url'],
            'created_by' => $userID
        ];
        return $this->link->create($linkData);
    }

    // 更新
    public function update($data)
    {
        $linkData = [
            'title' => $data['title'],
            'url' => $data['url'],
        ];
        return $this->link->update($data['id'], $linkData);
    }

    // 选择有效记录数量
    public function selectedCount($ids)
    {
        if ($ids) {
            $count = $this->link->selectedCount('link', $ids);
            return count($ids) == $count;
        }
        return false;
    }

    // 删除
    public function delete($ids)
    {
        return $this->link->delete($ids);
    }
}
