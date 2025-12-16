<?php

namespace app\admin\repository;

use app\model\ContactMessage;

class ContactMessageRepository extends BaseRepository
{
    protected ContactMessage $contactMessage;

    public function __construct()
    {
        $this->contactMessage = new ContactMessage();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        $query = $this->contactMessage
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->order('id desc')
            ->field('id,name,email,phone,content,status,ip,user_agent,created_at');

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
        $info = $this->contactMessage
            ->field('id,name,email,phone,content,status,ip,user_agent,created_at')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 更新
    public function update($id, $status)
    {
        $data = [
            'status' => $status,
        ];
        return $this->contactMessage->update($data, ['id' => $id]);
    }

    // 删除
    public function delete($ids)
    {
        return $this->contactMessage
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }
}
