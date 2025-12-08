<?php

namespace app\admin\repository;

use app\model\FileCategory;

class FileCategoryRepository extends BaseRepository
{
    protected FileCategory $fileCategory;

    public function __construct()
    {
        $this->fileCategory = new FileCategory();
    }

    // 分类全部
    public function all()
    {
        $names = $this->fileCategory->column('name', 'id');
        return $names;
    }

    public function dublicate($name, $code, $id = 0)
    {
        return $this->fileCategory
            ->where(['name' => $name, 'code' => $code])
            ->when($id > 0, function ($query) use ($id) {
                $query->where('id', '<>', $id);
            })
            ->field('id')
            ->find();
    }
}
