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
    protected $message = [
        'id.require' => 'ID是必填项',
        'id.number'  => 'ID必须为数字',
        'id.gt'      => 'ID必须大于0',
        'category.require' => '分类是必填项',
        'category.max'     => '分类名称不能超过20个字符',
        'title.max' => '标题不能超过100个字符',
        'summary.max' => '简介不能超过200个字符',
        'image.number' => '图片字段必须为数字',
        'video.number' => '视频字段必须为数字',
        'url.max' => 'URL不能超过200个字符',
        'sorted.between' => '排序值必须在0到255之间'
    ];

    protected $scene = [
        'create' => ['category', 'title', 'summary', 'image', 'video', 'url', 'sorted'],
        'update' => ['id', 'category', 'title', 'summary', 'image', 'video', 'url', 'sorted']
    ];
}
