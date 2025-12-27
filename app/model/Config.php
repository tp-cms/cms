<?php

namespace app\model;

class Config extends Base
{
    protected $table = 'config';

    // tdk
    public const configKeyTitle = 'title';
    public const configKeyDescription = 'description';
    public const configKeyKeywords = 'keywords';

    // 基本信息
    // logo
    public const configKeyLogo = 'logo';
    // 电话
    public const configKeyPhone = 'phone';
    // 邮箱
    public const configKeyEmail = 'email';
    // 地址
    public const configKeyAddress = 'address';
    // qq
    public const configKeyQQ = 'qq';
    // 抖音
    public const configKeyDouyin = 'douyin';
    // 微信
    public const configKeyWechat = 'wechat';
    // 公司名
    public const configKeyCompany = 'company';
    // 备案号
    public const configKeyICP = 'icp';
    // 百度爱采购商铺
    public const configkeyBaiduB2b = 'baidu_b2b';
}
