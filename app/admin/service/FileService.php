<?php

namespace app\admin\service;

use app\admin\repository\FileRepository;
use app\model\File;

class FileService extends BaseService
{
    protected FileRepository $file;

    public function __construct()
    {
        $this->file = new FileRepository();
    }

    // 文件列表
    public function index($keyword = '', $category = 0, $fileType = 'all', $page = 1, $perPage = 20)
    {
        return $this->file->index($keyword, $category, $fileType, $page, $perPage);
    }

    // 文件详情
    public function info($id)
    {
        $info = $this->file->info($id);
        if (!$info) {
            return [];
        }

        return $info->toArray();
    }

    // 文件上传
    public function upload($file, $userID, $isContent = true)
    {
        $dirInfo = prepareUploadDir();
        $saveDir = $dirInfo['saveDir'];
        $relativeDir = $dirInfo['relativeDir'];

        $realPath = $file->getRealPath();
        $hash = fileHash($realPath);
        if (!$hash) {
            throw new \Exception('无法计算文件哈希');
        }

        $fileInfo = [
            'file' => $file,
            'hash' => $hash,
            'size' => $file->getSize(),
            'extension' => $file->getOriginalExtension() ?: 'bin',
            'originalName' => $file->getOriginalName(),
            'mime' => mimeType($file),
        ];

        // 是否重复
        $found = $this->file->isExist([$hash], $userID);

        if ($found) {
            return [
                'id' => $found->id,
                'success' => true,
                'hash' => $hash,
                'path' => $found->path,
                'url' => request()->domain() . '/' . $found->path,
                'msg' => '文件已存在，返回之前上传信息',
            ];
        }

        // 保存文件
        $saveName = $hash . '.' . $fileInfo['extension'];
        $savePath = $saveDir . $saveName;
        $relativePath = $relativeDir . $saveName;

        if (!file_exists($savePath)) {
            $fileInfo['file']->move($saveDir, $saveName);
        }

        // 写入数据库
        $new = $this->file->create([
            'name' => fileSafeName($fileInfo['originalName']),
            'hash_name' => $hash,
            'path' => $relativePath,
            'size' => $fileInfo['size'],
            'ext' => $fileInfo['extension'],
            'mime' => $fileInfo['mime'],
            'storage_type' => File::fileStorageTypeLocal,
            'is_content' => $isContent,
            'created_by' => $userID,
        ]);

        return [
            'id' => $new->id,
            'success' => true,
            'hash' => $hash,
            'path' => $relativePath,
            'url' => request()->domain() . '/' . $relativePath,
            'msg' => '上传成功',
        ];
    }

    // 批量上传
    public function uploadMultiple(array $files, $userID)
    {
        $results = [];

        foreach ($files as $file) {
            if (!$file) continue;

            $results[] = $this->upload($file, $userID, false);
        }

        return $results;
    }

    // 更新
    public function update($data)
    {
        $fileData = [
            'category_id' => $data['category_id'],
            'name' => fileSafeName($data['name'])
        ];

        return $this->file->update($data['id'], $fileData);
    }

    // 更新文件分类
    public function updateCategory($ids, $categoryId)
    {
        return $this->file->updateCategory($ids, $categoryId);
    }

    // 选择有效记录数量
    public function selectedCount($ids)
    {
        if ($ids) {
            $count = $this->file->selectedCount('file', $ids);
            return count($ids) == $count;
        }
        return false;
    }

    // 删除
    public function delete($ids)
    {
        if (!$ids) {
            return false;
        }

        return $this->file->delete($ids);
    }
}
