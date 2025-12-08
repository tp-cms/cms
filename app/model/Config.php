<?php

namespace app\model;

class Config extends Base
{
    protected $table = 'config';

    // tdk
    public const title = 'title';
    public const description = 'description';
    public const keywords = 'keywords';

    // 基本信息
    // logo
    public const configLogo = 'logo';
    // 电话
    public const configPhone = 'phone';
    // 邮箱
    public const configEmail = 'email';
    // 地址
    public const configAddress = 'address';
    // qq
    public const configQQ = 'qq';
    // 抖音
    public const configDouyin = 'douyin';
    // 微信
    public const configWechat = 'wechat';
    // 公司名
    public const configCompany = 'company';
    // 备案号
    public const configICP = 'icp';
}
