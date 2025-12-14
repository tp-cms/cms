<?php

namespace app\admin\service;

use app\admin\repository\ProductCategoryRepository;
use app\admin\repository\ProductRepository;

class ProductCategoryService extends BaseService
{
    protected ProductCategoryRepository $productCategory;
    protected ProductRepository $product;

    public function __construct()
    {
        $this->productCategory = new ProductCategoryRepository();
        $this->product = new ProductRepository();
    }

    public function all()
    {
        return $this->productCategory->all();
    }

    public function info($id)
    {
        $info = $this->productCategory->info($id);
        if (!$info) {
            return [];
        }
        return $info->toArray();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->productCategory->index($keyword, $page, $perPage);
    }

    // 新增
    public function create($data, $userID)
    {
        $productCategoryData = [
            'name' => $data['name'],
            'code' => $data['code'],
            'created_by' => $userID,
        ];

        return $this->productCategory->create($productCategoryData);
    }

    // 更新
    public function update($data)
    {
        $productCategoryData = [
            'name' => $data['name'],
            'code' => $data['code'],
        ];

        return $this->productCategory->update($data['id'], $productCategoryData);
    }

    public function checkSelect($ids)
    {
        if ($ids) {
            $count = $this->productCategory->selectCount($ids);
            return count($ids) == $count;
        }
        return false;
    }

    // 删除
    public function delete($ids)
    {
        return $this->productCategory->delete($ids);
    }

    // 删除前判断
    public function checkDelete($ids)
    {
        return $this->product->foundProduct($ids);
    }

    // 是否重复
    public function duplicate($name, $code, $id = 0)
    {
        return $this->productCategory->duplicate($name, $code, $id);
    }
}
