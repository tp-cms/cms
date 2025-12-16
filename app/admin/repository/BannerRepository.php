<?php

namespace app\admin\repository;

use app\model\Banner;

class BannerRepository extends BaseRepository
{
    protected Banner $banner;

    public function __construct()
    {
        $this->banner = new Banner();
    }

    // 列表
    public function index($keyword = '', $category = '', $page = 1, $perPage = 20)
    {
        $query = $this->banner
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->order('id desc, category, sorted')
            ->field('id,category,title,image,status,video,summary,created_at');

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

    // 详情
    public function info($id)
    {
        $info = $this->banner
            ->field('id,category,title,summary,image,video,url,sorted,status')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 添加
    public function create($data)
    {
        return $this->banner->insertGetId($data);
    }

    // 更新
    public function update($id, $data)
    {
        return $this->banner->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->banner
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }
}
