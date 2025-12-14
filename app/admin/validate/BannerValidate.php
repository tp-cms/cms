<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class BannerValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id' => 'require|number|gt:0',
        'category' => 'require|max:20',
        'title' => 'max:100',
        'summary' => 'max:200',
        'image' => 'number',
        'video' => 'number',
        'url' => 'max:200',
        'sorted' => 'between:0,255'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'create' => ['category', 'title', 'summary', 'image', 'video', 'url', 'sorted'],
        'update' => ['id', 'category', 'title', 'summary', 'image', 'video', 'url', 'sorted']
    ];
}
