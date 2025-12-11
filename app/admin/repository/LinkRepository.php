<?php

namespace app\admin\repository;

use app\model\Link;

class LinkRepository extends BaseRepository
{
    protected Link $link;

    public function __construct()
    {
        $this->link = new Link();
    }

    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        $query = $this->link
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereLike('title', '%' . $keyword . '%')
                        ->whereOrLike('url', '%' . $keyword . '%');
                });
            })
            ->order('id desc')
            ->field('id,title,url');

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
        return $this->link->insertGetId($data);
    }

    // 详情
    public function info($id)
    {
        $info = $this->link
            ->field('id,title,url')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 更新
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->link->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->link->delete($ids);
    }
}
