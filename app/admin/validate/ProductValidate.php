<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class ProductValidate extends Validate
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
        'cover' => 'number',
        'summary' => 'require|max:200',
        // 'category_id' => 'require|number|gt:0',
        'category_id' => [
            'require',
            'integer',
            'gt' => 0,
        ]
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require'          => '更新产品不能为空',
        'id.number'           => '更新产品id格式错误',
        'id.gt'               => '更新产品id不可小于0',
        'title.require'       => '产品名不能为空',
        'title.max'           => '产品名不能超过100个字符',
        'summary.require'     => '简介不能为空',
        'summary.max'         => '简介不能超过200个字符',
        'category_id.require' => '分类不能为空',
        'category_id.integer' => '分类ID必须为整数',
        'category_id.gt'      => '分类ID必须大于0',
    ];

    protected $scene = [
        'create' => ['title', 'cover', 'summary', 'category_id'], // 新增
        'update' => ['id', 'title', 'cover', 'summary', 'category_id'], // 编辑
    ];
}
