<?php

namespace app\model;

class ActionLog extends Base
{
    protected $table = 'action_log';

    public const ActionLogActionOther = 0;
    public const ActionLogActionIndex = 1;
    public const ActionLogActionCreate = 2;
    public const ActionLogActionUpdate = 3;
    public const ActionLogActionDelete = 4;
}
