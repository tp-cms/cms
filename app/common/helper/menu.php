<?php


use think\facade\Request;

function setActiveMenu(array &$menu)
{
    $currentUrl = '/' . Request::pathinfo(); // 当前访问路径，不带参数

    foreach ($menu as &$item) {
        // 如果 url 不存在或为 null，强制为空字符串
        $url = isset($item['url']) ? (string)$item['url'] : '';

        // 当前菜单 active 判断
        $item['active'] = ($url !== '' && $url === $currentUrl);

        // 子菜单递归
        if (!empty($item['children']) && is_array($item['children'])) {
            setActiveMenu($item['children']);
            foreach ($item['children'] as $child) {
                if (!empty($child['active'])) {
                    $item['active'] = true; // 父级也标记 active
                    break;
                }
            }
        }
    }
}
