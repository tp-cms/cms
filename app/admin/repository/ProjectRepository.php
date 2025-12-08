<?php

namespace app\admin\repository;

use app\model\Project;

class ProjectRepository extends BaseRepository
{
    protected Project $project;

    public function __construct()
    {
        $this->project = new Project();
    }
}
