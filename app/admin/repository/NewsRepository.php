<?php

namespace app\admin\repository;

use app\model\News;

class NewsRepository extends BaseRepository
{
    protected News $news;

    public function __construct()
    {
        $this->news = new News();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        $query = $this->news
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->order('id desc')
            ->field('id,title,summary,cover,status,is_top,created_at');

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
        $info = $this->news
            ->field('id,cover,title,summary,content,cover,status,is_top,created_at')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 添加
    public function create($data)
    {
        return $this->news->insertGetId($data);
    }

    // 更新
    public function update($id, $data)
    {
        return $this->news->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->news
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }
}
