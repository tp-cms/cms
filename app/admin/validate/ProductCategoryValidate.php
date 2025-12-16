<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class ProductCategoryValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:26',
        'code' => 'require|max:50'
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
        'name.require' => '名称是必填项',
        'name.max'     => '名称不能超过26个字符',
        'code.require' => 'CODE是必填项',
        'code.max'     => 'CODE不能超过50个字符'
    ];

    protected $scene = [
        'create' => ['name', 'code'],
        'update' => ['id', 'name', 'code']
    ];
}
