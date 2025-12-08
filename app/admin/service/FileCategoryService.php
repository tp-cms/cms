<?php

namespace app\admin\service;

use app\admin\repository\FileCategoryRepository;

class FileCategoryService extends BaseService
{
    protected FileCategoryRepository $fileCategory;

    public function __construct()
    {
        $this->fileCategory = new FileCategoryRepository();
    }

    public function all()
    {
        return $this->fileCategory->all();
    }
}
