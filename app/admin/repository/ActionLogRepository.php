<?php

namespace app\admin\repository;

use app\model\ActionLog;

class ActionLogRepository extends BaseRepository
{
    protected ActionLog $actionLog;

    public function __construct()
    {
        $this->actionLog = new ActionLog();
    }
}
