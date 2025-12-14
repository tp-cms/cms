<?php

namespace app\admin\service;

use app\admin\repository\FileRepository;
use app\admin\repository\NewsRepository;

class NewsService extends BaseService
{
    protected NewsRepository $news;
    protected FileRepository $file;

    public function __construct()
    {
        $this->news = new NewsRepository();
        $this->file = new FileRepository();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->news->index($keyword, $page, $perPage);
    }

    // 新增
    public function create($data, $userID)
    {
        if ($data['cover']) {
            $coverInfo = $this->file->info($data['cover']);
            if (!$coverInfo) {
                $data['cover'] = 0;
            }
        }
        $newsData = [
            'title' => $data['title'],
            'summary' => $data['summary'],
            'cover' => $data['cover'],
            'content' => $data['content'],
            'status' => $data['status'],
            'is_top' => $data['is_top'],
            'created_by' => $userID
        ];

        return $this->news->create($newsData);
    }

    // 更新
    public function update($data)
    {
        if ($data['cover']) {
            $coverInfo = $this->file->info($data['cover']);
            if (!$coverInfo) {
                $data['cover'] = 0;
            }
        }
        $newsData = [
            'title' => $data['title'],
            'summary' => $data['summary'],
            'cover' => $data['cover'],
            'content' => $data['content'],
            'status' => $data['status'],
            'is_top' => $data['is_top'],
        ];

        return $this->news->update($data['id'], $newsData);
    }

    // 删除
    public function delete($ids)
    {
        if (!$ids) {
            return false;
        }

        return $this->news->delete($ids);
    }

    public function checkSelect($ids)
    {
        if ($ids) {
            $count = $this->news->selectCount($ids);
            return count($ids) == $count;
        }
        return false;
    }
}
