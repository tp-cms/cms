<?php
// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

return [
    // 模板引擎类型使用Think
    'type'          => 'Think',
    // 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写 3 保持操作方法
    'auto_rule'     => 1,
    // 模板目录名
    'view_dir_name' => 'view',
    // 模板后缀
    'view_suffix'   => 'html',
    // 模板文件名分隔符
    'view_depr'     => DIRECTORY_SEPARATOR,
    // 模板引擎普通标签开始标记
    'tpl_begin'     => '{',
    // 模板引擎普通标签结束标记
    'tpl_end'       => '}',
    // 标签库标签开始标记
    'taglib_begin'  => '{',
    // 标签库标签结束标记
    'taglib_end'    => '}',

    // 添加模板变量替换，前期前后端不分离时使用
    'tpl_replace_string' => [
        // 后台资源
        '__STATIC_ADMIN__'      => '/assets/admin',
        '__ADMIN_CSS__'         => '/assets/admin/css',
        '__ADMIN_JS__'          => '/assets/admin/js',
        '__ADMIN_IMG__'         => '/assets/admin/img',

        // 上传相关
        '__UPLOAD_DIR__'        => '/storage/upload', // 图片上传目录
    ]
];
