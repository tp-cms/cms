<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class ConfigValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'title' => 'max:100',
        'keyword' => 'max:200',
        'description' => 'max:500',
        'logo' => 'number',
        'phone' => 'max:57',
        'email' => 'email',
        'address' => 'max:100',
        'qq' => 'max:11',
        'douyin' => 'number',
        'wechat' => 'number',
        'company' => 'max:200',
        'icp' => 'max:50',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'title.max' => '标题不能超过100个字符',
        'keyword.max' => '关键词不能超过200个字符',
        'description.max' => '描述不能超过500个字符',
        'logo.number' => 'Logo上传错误',
        'phone.max' => '电话不能超过57个字符',
        'email.email' => '请输入有效的电子邮箱地址',
        'address.max' => '地址不能超过100个字符',
        'qq.max' => 'QQ号不能超过11个字符',
        'douyin.number' => '抖音二给码上传错误',
        'wechat.number' => '微信二维码上传错误',
        'company.max' => '公司名称不能超过200个字符',
        'icp.max' => 'ICP备案号不能超过50个字符',
    ];
}
