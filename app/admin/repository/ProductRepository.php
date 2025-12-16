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

    // 列表
    public function index($keyword = '', $category = 0, $page = 1, $perPage = 20)
    {
        $query = $this->product->alias('p')
            ->join('product_category c', 'p.category_id = c.id', 'left')
            ->join('file f', 'p.cover = f.id', 'left')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('p.title', 'like', '%' . $keyword . '%');
            })
            ->when($category > 0, function ($query) use ($category) {
                $query->where('p.category_id', $category);
            })
            ->order('p.id desc')
            ->field('p.id,p.title,p.summary,p.cover,p.created_at,p.price,p.b2b_uri, c.name as category_name, f.path as file_path, f.mime as file_mime');

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

    // 某个分类是否存在产品
    public function hasProductInCategory($categoryIds)
    {
        return $this->product->field('id')->where('category_id', 'in', $categoryIds)->find();
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

    // 添加
    public function create($data)
    {
        return $this->product->insertGetId($data);
    }

    // 更新
    public function update($id, $data)
    {
        return $this->product->update($data, ['id' => $id]);
    }

    // 删除
    public function delete($ids)
    {
        // 这个场景好像必须添加一个useSoftDelete，find后直接->delete是可以的
        // https://doc.thinkphp.cn/v8_0/soft_delete.html
        return $this->product
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }
}
