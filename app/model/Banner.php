<?php

namespace app\model;

use think\model\concern\SoftDelete;

class Banner extends Base
{
    use SoftDelete;

    protected $table = 'banner';

    // 指定软删除字段
    protected $deleteTime = 'deleted_at';

    // 相应的轮播图分类
    // 首页
    public const bannerIndex = 'index';
    // 关于我们
    public const bannerAboutUs = 'about_us';
    // 产品
    public const bannerProduct = 'product';
    // 新闻
    public const bannerNews = 'news';
    // 案例（model不支持使用Case，这里使用project，统一下）
    public const bannerProject = 'project';
    // 联系我们
    public const bannerContact = 'contact';
    // 隐私政策
    public const bannerPrivacy = 'privacy';
}
