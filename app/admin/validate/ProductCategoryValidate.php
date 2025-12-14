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
    protected $message = [];

    protected $scene = [
        'create' => ['name', 'code'],
        'update' => ['id', 'name', 'code']
    ];
}
