<?php

namespace app\admin\service;

use app\admin\repository\ProjectRepository;

class ProjectService extends BaseService
{
    protected ProjectRepository $project;

    public function __construct()
    {
        $this->project = new ProjectRepository();
    }
}
