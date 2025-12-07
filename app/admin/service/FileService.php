<?php

namespace app\admin\service;

use app\admin\repository\FileRepository;

class FileService extends BaseService
{
    protected FileRepository $file;

    public function __construct()
    {
        $this->file = new FileRepository();
    }

    // 文件类型
    public function mimeType(\think\File $file): string
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

    private function fileSafeName(string $fileName): string
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
    private function fileHash(string $filePath): ?string
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

    // 文件上传
    public function fileUpload(array $files, int $userID)
    {
        $results = [];

        if (empty($files)) {
            return $results;
        }

        $dateDir = date('Y-m-d'); // 按日期归档文件目录
        $relativeDir = 'storage/upload/' . $dateDir . '/';
        $saveDir = public_path($relativeDir); // 绝对路径

        // 不存在则递归创建目录，权限 0755
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0755, true);
        }

        // 先计算所有文件的哈希、文件大小、扩展名、原始名和 MIME 类型，批量处理减少查询次数
        $fileInfos = [];

        foreach ($files as $file) {
            $realPath = $file->getRealPath();
            $hash = $this->fileHash($realPath);
            if (!$hash) {
                throw new \Exception('无法计算文件哈希');
            }

            $fileInfos[] = [
                'file' => $file,
                'hash' => $hash,
                'size' => $file->getSize(),
                'extension' => $file->getOriginalExtension() ?: 'bin',
                'originalName' => $file->getOriginalName(),
                'mime' => $this->mimeType($file),
            ];
        }

        // 查询数据库是否已有相同 hash 且属于该用户的文件
        $hashes = array_column($fileInfos, 'hash');
        $existingFilesRaw = $this->file->hashesAndUser($hashes, $userID);
        // 用关联数组以 hash 为 key，方便快速判断文件是否已存在
        $existingFiles = [];
        foreach ($existingFilesRaw as $file) {
            $existingFiles[$file->hash_name] = $file;
        }

        // 逐个处理文件
        foreach ($fileInfos as $info) {
            $hash = $info['hash'];

            if (isset($existingFiles[$hash])) {
                // 文件已存在，直接返回数据库信息，避免重复上传浪费空间
                $fileModel = $existingFiles[$hash];
                $results[] = [
                    'id' => $fileModel->id,
                    'success' => true,
                    'hash' => $hash,
                    'path' => $fileModel->path,
                    'url' => request()->domain() . '/' . $fileModel->path,
                    'msg' => '文件已存在，返回之前上传信息',
                ];
                continue;
            }

            // 新文件，保存文件到指定目录
            $saveName = $hash . '.' . $info['extension'];
            $savePath = $saveDir . $saveName;
            $relativePath = $relativeDir . $saveName;

            if (!file_exists($savePath)) {
                // move() 会自动覆盖同名文件，故这里判断避免重复移动
                $info['file']->move($saveDir, $saveName);
            }

            // 写入数据库
            $newFile = $this->file->create([
                // 使用安全文件名保存到数据库，防止路径或显示问题
                'name' => $this->fileSafeName($info['originalName']),
                'hash_name' => $hash,
                'path' => $relativePath,
                'size' => $info['size'],
                'ext' => $info['extension'],
                'mime' => $info['mime'],
                'created_by' => $userID,
            ]);

            $results[] = [
                'id' => $newFile->id,
                'success' => true,
                'hash' => $hash,
                'path' => $relativePath,
                'url' => request()->domain() . '/' . $relativePath,
                'msg' => '上传成功',
            ];
        }

        return $results;
    }
}
