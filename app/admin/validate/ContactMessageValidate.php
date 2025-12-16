<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class ContactMessageValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require|number|gt:0',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require' => 'ID是必填项',
        'id.number'  => 'ID必须为数字',
        'id.gt'      => 'ID必须大于0',
    ];

    protected $scene = [
        'update' => ['id']
    ];
}
