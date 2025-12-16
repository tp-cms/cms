<?php

// 文件类型
function mimeType(\think\File $file): string
{
    $realPath = $file->getRealPath();
    if (!$realPath || !is_file($realPath)) {
        return '';
    }

    // 打开 finfo 资源，用于检测 MIME 类型
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    if (!$finfo) {
        return '';
    }

    // 获取文件的 MIME 类型
    $mimeType = finfo_file($finfo, $realPath);
    // 不需要手动关闭,finfo会自动关闭

    return $mimeType ?: '';
}

function fileSafeName(string $fileName): string
{
    // 获取扩展名和主文件名
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $base = pathinfo($fileName, PATHINFO_FILENAME);

    // 替换非法字符为下划线，Windows 和 Linux 常见非法字符
    $illegal = ['\\', '/', ':', '*', '?', '"', '<', '>', '|'];
    $base = str_replace($illegal, '_', $base);

    // 去除不可打印的控制字符，避免文件名异常
    $base = preg_replace('/[\x00-\x1F]/', '', $base);

    // URL 编码，防止特殊字符导致路径或链接异常
    $safe = rawurlencode($base);

    // 返回拼接扩展名的安全文件名
    return $safe . ($ext ? '.' . $ext : '');
}

// 文件hash
function fileHash(string $filePath): ?string
{
    if (!is_readable($filePath)) {
        return null;
    }

    $handle = fopen($filePath, 'rb');
    if (!$handle) {
        return null;
    }

    $hashContext = hash_init('sha256');
    while (!feof($handle)) {
        // 每次读取 128KB，防止内存占用过大
        $chunk = fread($handle, 128 * 1024);
        if ($chunk === false) {
            fclose($handle);
            return null;
        }
        hash_update($hashContext, $chunk);
    }

    fclose($handle);
    return hash_final($hashContext);
}

function prepareUploadDir()
{
    $dateDir = date('Y-m-d');
    $relativeDir = 'storage/upload/' . $dateDir . '/';
    $saveDir = public_path($relativeDir);

    if (!is_dir($saveDir)) {
        mkdir($saveDir, 0755, true);
    }

    return [
        'saveDir' => $saveDir,
        'relativeDir' => $relativeDir,
    ];
}
