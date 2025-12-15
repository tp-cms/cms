<?php

declare(strict_types=1);

namespace app\admin\middleware;

use app\model\ActionLog;

class ActionLogMiddleware
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        // 获取用户信息
        $user = $request->user;
        $userId = $user['id'];
        $pathInfo = $request->pathinfo();
        $pathInfo = substr($pathInfo, strlen(adminRoutePrefix()) + 1);
        // 默认操作是其他
        $action = ActionLog::ActionLogActionOther;

        // 获取操作类型
        switch (true) {
            case strpos($pathInfo, 'index') !== false:
                $action = ActionLog::ActionLogActionIndex;
                break;
            case strpos($pathInfo, 'create') !== false:
                $action = ActionLog::ActionLogActionCreate;
                break;
            case strpos($pathInfo, 'update') !== false:
                $action = ActionLog::ActionLogActionUpdate;
                break;
            case strpos($pathInfo, 'delete') !== false:
                $action = ActionLog::ActionLogActionDelete;
                break;
            default:
                $action = ActionLog::ActionLogActionOther;
                break;
        }

        // 这里先暂不记录，列表查看记录
        if ($action != ActionLog::ActionLogActionIndex) {
            $log = [
                'created_by' => $userId,
                'action' => $action,
                'module' => $pathInfo,
                'ip' => request()->header('X-Forwarded-For') ?: request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'description' => ''
            ];
            // 操作记录repo
            $actionLog = new ActionLog();
            $actionLog->save($log);
        }

        return $next($request);
    }
}
