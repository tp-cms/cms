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

    // 列表
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
            $coverInfo = $this->file->pathInfo($info->cover);
            if ($coverInfo) {
                $info->cover_file = $coverInfo;
            } else {
                $info->cover = 0;
            }
        }

        if ($info->content_image) {
            $contentImageInfo = $this->file->batchInfo($info->content_image);
            if ($contentImageInfo) {
                $info->content_image_file = $contentImageInfo;
            } else {
                $info->content_image = 0;
            }
        }

        return $info->toArray();
    }

    // 新增
    public function create($data, $userID)
    {
        if ($data['cover']) {
            $coverInfo = $this->file->pathInfo($data['cover']);
            if (!$coverInfo) {
                $data['cover'] = 0;
            }
        }

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

    // 更新
    public function update($data)
    {
        if ($data['cover']) {
            $coverInfo = $this->file->pathInfo($data['cover']);
            if (!$coverInfo) {
                $data['cover'] = 0;
            }
        }

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

    // 检查选择
    public function checkSelect($ids)
    {
        if ($ids) {
            $count = $this->product->selectCount($ids);
            return count($ids) == $count;
        }
        return false;
    }

    // 删除
    public function delete($ids)
    {
        if (!$ids) {
            return false;
        }

        return $this->product->delete($ids);
    }
}
