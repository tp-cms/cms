<?php

if (!function_exists('generateUUID4')) {
    function generateUUID4(): string
    {
        // 生成16个随机字节
        $data = random_bytes(16);

        // 设置版本字段为 0100（UUIDv4的版本标识）
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);  // 版本号：4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);  // 随机数范围

        // 格式化为标准的 UUID v4 格式：xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx
        return vsprintf(
            '%s%s-%s-%s-%s-%s%s%s',
            str_split(bin2hex($data), 4)
        );
    }
}
