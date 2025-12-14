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

    // 删除前判断
    public function checkDelete($ids)
    {
        return $this->file->foundFile($ids);
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->fileCategory->index($keyword, $page, $perPage);
    }

    // 新增
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

    // 是否重复
    public function duplicate($name, $code, $id = 0)
    {
        return $this->fileCategory->duplicate($name, $code, $id);
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
