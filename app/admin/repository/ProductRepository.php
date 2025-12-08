<?php

namespace app\admin\repository;

use app\model\Product;

class ProductRepository extends BaseRepository
{
    protected Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index($keyword = '', $category = 0, $page = 1, $perPage = 20)
    {
        $query = $this->product->alias('p')
            ->join('product_category c', 'p.category_id = c.id', 'left')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('p.title', 'like', '%' . $keyword . '%');
            })
            ->when($category > 0, function ($query) use ($category) {
                $query->where('p.category_id', $category);
            })
            ->field('p.id,p.title,p.summary,p.cover,p.created_at,p.price,p.b2b_uri, c.name as category_name');

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
        return $this->product->insertGetId($data);
    }

    // 详情
    public function info($id)
    {
        $info = $this->product
            ->field('id,category_id,cover,title,summary,parameter,content_image,content,price,b2b_uri,created_by')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 更新
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->product->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->product->delete($ids);
    }
}
