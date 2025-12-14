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

    public function index($keyword = '', $userID = 0, $page = 1, $perPage = 20)
    {
        $query = $this->actionLog
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereLike('ip', '%' . $keyword . '%')
                        ->whereOrLike('module', '%' . $keyword . '%');
                });
            })
            ->when($userID, function ($query) use ($userID) {
                $query->where('created_by', $userID);
            })
            ->order('id desc, category, sorted')
            ->field('id,action,module,description,ip,user_agent,created_at,created_by');

        // 记录数
        $total = $query->count();

        $totalPages = ceil($total / $perPage);

        if ($page > $totalPages) {
            return [
                'content' => [],
                'count' => $total
            ];
        }

        $data = $query->page($page, $perPage)->select();

        return [
            'content' => $data,
            'count' => $total,
        ];
    }

    // 详情
    public function info($id)
    {
        $info = $this->actionLog
            ->field('id,action,module,description,ip,user_agent,created_by,created_at')
            ->where(['id' => $id])
            ->find();

        return $info;
    }
}
