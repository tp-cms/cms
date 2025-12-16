<?php

namespace app\admin\service;

use app\admin\repository\FileCategoryRepository;
use app\admin\repository\FileRepository;

class FileCategoryService extends BaseService
{
    protected FileCategoryRepository $fileCategory;
    protected FileRepository $file;

    public function __construct()
    {
        $this->fileCategory = new FileCategoryRepository();
        $this->file = new FileRepository();
    }

    // 文件分类（全部）
    public function all()
    {
        return $this->fileCategory->all();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->fileCategory->index($keyword, $page, $perPage);
    }

    // 名称/CODE是否存在
    public function duplicate($name, $code, $id = 0)
    {
        return $this->fileCategory->duplicate($name, $code, $id);
    }

    // 某个分类是否存在文件
    public function hasFileInCategory($ids)
    {
        return $this->file->hasFileInCategory($ids);
    }

    // 详情
    public function info($id)
    {
        $info = $this->fileCategory->info($id);
        if (!$info) {
            return [];
        }
        return $info->toArray();
    }


    // 添加
    public function create($data, $userID)
    {
        $fileCategoryData = [
            'name' => $data['name'],
            'code' => $data['code'],
            'created_by' => $userID,
        ];

        return $this->fileCategory->create($fileCategoryData);
    }

    // 更新
    public function update($data)
    {
        $fileCategoryData = [
            'name' => $data['name'],
            'code' => $data['code'],
        ];

        return $this->fileCategory->update($data['id'], $fileCategoryData);
    }

    // 选择有效记录数量
    public function selectedCount($ids)
    {
        if ($ids) {
            $count = $this->fileCategory->selectedCount('file_category', $ids);
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

        return $this->fileCategory->delete($ids);
    }
}
