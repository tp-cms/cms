<?php

namespace app\model;

use think\model\concern\SoftDelete;

class Project extends Base
{
    use SoftDelete;

    protected $table = 'project';
}
