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
            ->where(function ($query) use ($keyword, $category) {
                if ($keyword) {
                    $query->where('p.title', 'like', '%' . $keyword . '%');
                }
                if ($category > 0) {
                    $query->where('p.category_id', $category);
                }
            })
            ->field('p.*, c.name as category_name');

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
}
