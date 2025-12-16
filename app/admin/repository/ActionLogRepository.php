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

    // 列表
    public function index($keyword = '', $userID = 0, $page = 1, $perPage = 20)
    {
        $query = $this->actionLog
            ->alias('al')
            ->join('user u', 'al.created_by = u.id', 'left')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    // https://doc.thinkphp.cn/v8_0/adv_query.html
                    $ipMap = ['al.ip', 'like', '%' . $keyword . '%'];
                    $moduleMap = ['al.module', 'like', '%' . $keyword . '%'];
                    $q->whereOr([$ipMap, $moduleMap]);
                });
            })
            ->when($userID, function ($query) use ($userID) {
                $query->where('al.created_by', $userID);
            })
            ->order('al.id desc')
            ->field('al.id,al.action,al.module,al.description,al.ip,al.user_agent,al.created_at,al.created_by,u.username');

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
            ->alias('al')
            ->join('user u', 'al.created_by = u.id', 'left')
            ->field('al.id,al.action,al.module,al.description,al.ip,al.user_agent,al.created_by,al.created_at,u.username')
            ->where(['al.id' => $id])
            ->find();

        return $info;
    }
}
