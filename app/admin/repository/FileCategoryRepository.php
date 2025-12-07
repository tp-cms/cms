<?php

namespace app\admin\repository;

use app\model\FileCategory;

class FileCategoryRepository extends BaseRepository{
    protected FileCategory $fileCategory;

    public function __construct()
    {
        $this->fileCategory = new FileCategory();
    }
}