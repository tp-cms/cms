<?php

namespace app\admin\repository;

use app\model\File;

class FileRepository extends BaseRepository
{
    protected File $file;

    public function __construct()
    {
        $this->file = new File();
    }

    public function index($keyword = '', $category = 0, $fileType = 'all', $page = 1, $perPage = 20)
    {
        $query = $this->file->alias('f')
            ->join('file_category c', 'f.category_id = c.id', 'left')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('f.name', 'like', '%' . $keyword . '%');
            })
            ->when($category > 0, function ($query) use ($category) {
                $query->where('f.category_id', $category);
            })
            ->when($fileType != 'all', function ($query) use ($fileType) {
                $query->where('mime', 'like', $fileType . '%');
            })
            ->order('f.id desc')
            ->field('f.id,f.name,f.path,f.size,f.mime,f.storage_type,f.ext,f.is_content,f.created_at,c.name as category_name');

        // 记录数
        $total = $query->count();

        $totalPages = ceil($total / $perPage);

        if ($page > $totalPages) {
            return [
                'content' => [],
                'count' => $total
            ];
        }

        $data = $query->page($page, $perPage)->select();

        return [
            'content' => $data,
            'count' => $total,
        ];
    }

    public function hashDuplicate($hash, $userID, $storageType = File::fileStorageTypeLocal)
    {
        return $this->file->where([
            'hash_name' => $hash,
            'created_by' => $userID,
            'storage_type' => $storageType
        ])->find();
    }

    public function create($data)
    {
        return $this->file->create($data);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->file
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }

    // 获取文件信息
    public function info($id)
    {
        return $this->file->where('id', $id)->field('id,path')->select();
    }

    public function batchInfo($ids)
    {
        return $this->file->whereIn('id', $ids)->field('id,path')->select();
    }

    public function selectCount($ids)
    {
        return $this->file->where('id', 'in', $ids)->count('id');
    }

    // 某个分类是否存在文件
    public function foundFile($categoryIds)
    {
        return $this->file->field('id')->where('category_id', 'in', $categoryIds)->find();
    }

    // 更新文件分类
    public function updateCategory($ids, $categoryId)
    {
        return $this->file->where('id', 'in', $ids)->update(['category_id' => $categoryId]);
    }
}
