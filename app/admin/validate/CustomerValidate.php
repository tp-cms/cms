<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class CustomerValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:100',
        'logo' => 'number',
        'url' => 'max:200'
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
        'name.max'     => '名称不能超过100个字符',
        'logo.number' => 'Logo字段必须为数字',
        'url.max' => 'URL不能超过200个字符'
    ];


    protected $scene = [
        'create' => ['name', 'logo', 'url'],
        'update' => ['id', 'name', 'logo', 'url']
    ];
}
