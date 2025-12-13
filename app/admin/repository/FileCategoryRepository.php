<?php

namespace app\admin\repository;

use app\model\FileCategory;

class FileCategoryRepository extends BaseRepository
{
    protected FileCategory $fileCategory;

    public function __construct()
    {
        $this->fileCategory = new FileCategory();
    }

    // 分类全部
    public function all()
    {
        $names = $this->fileCategory->column('name', 'id');
        return $names;
    }

    public function dublicate($name, $code, $id = 0)
    {
        return $this->fileCategory
            ->where(['name' => $name, 'code' => $code])
            ->when($id > 0, function ($query) use ($id) {
                $query->where('id', '<>', $id);
            })
            ->field('id')
            ->find();
    }

    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        $query = $this->fileCategory
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->order('id desc')
            ->field('id,name,code');

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

    // 添加
    public function create($data)
    {
        return $this->fileCategory->insertGetId($data);
    }

    // 详情
    public function info($id)
    {
        $info = $this->fileCategory
            ->field('id,name,code')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 更新
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->fileCategory->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->fileCategory
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }
}
