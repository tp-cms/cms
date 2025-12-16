<?php

namespace app\admin\repository;

use app\model\Customer;

class CustomerRepository extends BaseRepository
{
    protected Customer $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        $query = $this->customer
            ->alias('c')
            ->join('file f', 'c.logo = f.id', 'left')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('c.name', 'like', '%' . $keyword . '%');
            })
            ->order('c.id desc')
            ->field('c.id,c.name,c.logo,c.url,f.path as file_path, f.mime as file_mime');

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

    // 名称是否重复
    public function duplicate($name, $id = 0)
    {
        return $this->customer
            ->where(['name' => $name])
            ->when($id > 0, function ($query) use ($id) {
                $query->where('id', '<>', $id);
            })
            ->field('id')
            ->find();
    }

    // 详情
    public function info($id)
    {
        $info = $this->customer
            ->field('id,name,logo,url')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 添加
    public function create($data)
    {
        return $this->customer->insertGetId($data);
    }

    // 更新
    public function update($id, $data)
    {
        return $this->customer->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->customer
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }
}
