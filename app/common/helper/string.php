<?php

function randomCode($length = 4)
{
    $chars = '345678abcdefhkmnpqrstwxyABCDEFGHKMNPQRTWXY';

    // 获取字符池的长度
    $charLength = strlen($chars);

    $codeArray = [];

    // 生成随机码
    for ($i = 0; $i < $length; $i++) {
        $codeArray[] = $chars[mt_rand(0, $charLength - 1)];
    }

    return implode('', $codeArray);
}
