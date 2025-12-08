<?php


use think\facade\Request;

/**
 * 标记菜单选中
 * 支持 url / children / include 扩展匹配
 */
function setActiveMenu(array &$menu)
{
    $currentUrl = '/' . Request::pathinfo(); // 当前访问路径，不带参数

    foreach ($menu as &$item) {
        // 如果 url 不存在或为 null，强制为空字符串
        $url = isset($item['url']) ? (string)$item['url'] : '';

        $item['active'] = false;

        // URL 完全相等
        if ($url !== '' && $url === $currentUrl) {
            $item['active'] = true;
        }

        // include 映射匹配
        if (!empty($item['include'])) {
            $includeList = is_array($item['include'])
                ? $item['include']
                : [$item['include']];

            if (in_array($currentUrl, $includeList)) {
                $item['active'] = true;
            }
        }

        // 子菜单递归
        if (!empty($item['children']) && is_array($item['children'])) {
            setActiveMenu($item['children']);

            // 有子项 active，则父级 active
            foreach ($item['children'] as $child) {
                if (!empty($child['active'])) {
                    $item['active'] = true; // 父级也标记 active
                    break;
                }
            }
        }
    }
}
