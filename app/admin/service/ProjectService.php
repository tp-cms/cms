<?php

namespace app\admin\service;

use app\admin\repository\FileRepository;
use app\admin\repository\ProjectRepository;

class ProjectService extends BaseService
{
    protected ProjectRepository $project;
    protected FileRepository $file;

    public function __construct()
    {
        $this->project = new ProjectRepository();
        $this->file = new FileRepository();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->project->index($keyword, $page, $perPage);
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
        $projectData = [
            'title' => $data['title'],
            'summary' => $data['summary'],
            'cover' => $data['cover'],
            'content' => $data['content'],
            'status' => $data['status'],
            'is_top' => $data['is_top'],
            'tag' => $data['tag'],
            'created_by' => $userID,
        ];

        return $this->project->create($projectData);
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
        $projectData = [
            'title' => $data['title'],
            'summary' => $data['summary'],
            'cover' => $data['cover'],
            'content' => $data['content'],
            'status' => $data['status'],
            'is_top' => $data['is_top'],
            'tag' => $data['tag'],
        ];

        return $this->project->update($data['id'], $projectData);
    }

    // 检查选择
    public function checkSelect($ids)
    {
        if ($ids) {
            $count = $this->project->selectCount($ids);
            return count($ids) == $count;
        }
        return false;
    }

    // 删除
    public function delete($ids)
    {
        if (!$ids) {
            return false;
        }

        return $this->project->delete($ids);
    }
}
