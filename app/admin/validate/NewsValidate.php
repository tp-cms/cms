<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class NewsValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require|number|gt:0',
        'title' => 'require|max:100',
        'summary' => 'max:200',
        'cover' => 'number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'create' => ['title', 'summary', 'cover'],
        'update' => ['id', 'title', 'summary', 'cover']
    ];
}
