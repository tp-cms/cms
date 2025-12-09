<?php

namespace app\admin\service;

use app\admin\repository\FileRepository;
use app\admin\repository\ProductRepository;

class ProductService extends BaseService
{
    protected ProductRepository $product;
    protected FileRepository $file;

    public function __construct()
    {
        $this->product = new ProductRepository();
        $this->file = new FileRepository();
    }

    // index
    public function index($keyword = '', $category = 0, $page = 1, $perPage = 20)
    {
        return $this->product->index($keyword, $category, $page, $perPage);
    }

    // 详情
    public function info($id)
    {
        $info = $this->product->info($id);
        if (!$info) {
            return [];
        }

        // 处理图片
        $info->cover_file = [];
        $info->content_image_file = [];

        if ($info->cover) {
            $info->cover_file = $this->file->info($info->cover);
        }

        if ($info->content_image) {
            $info->content_image_file = $this->file->info($info->content_image);
        }

        return $info->toArray();
    }

    public function create($data, $userID)
    {
        $productData = [
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'cover' => $data['cover'],
            'summary' => $data['summary'],
            'parameter' => $data['parameter'],
            'content_image' => $data['content_image'],
            'content' => $data['content'],
            'price' => $data['price'],
            'b2b_uri' => $data['b2b_uri'],
            'created_by' => $userID,
        ];

        return $this->product->create($productData);
    }

    public function update($data)
    {
        $productData = [
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'cover' => $data['cover'],
            'summary' => $data['summary'],
            'parameter' => $data['parameter'],
            'content_image' => $data['content_image'],
            'content' => $data['content'],
            'price' => $data['price'],
            'b2b_uri' => $data['b2b_uri'],
        ];

        return $this->product->update($data['id'], $productData);
    }
}
