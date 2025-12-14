<?php

namespace app\admin\repository;

use app\model\ProductCategory;

class ProductCategoryRepository extends BaseRepository
{
    protected ProductCategory $productCategory;

    public function __construct()
    {
        $this->productCategory = new ProductCategory();
    }

    // 分类全部
    public function all()
    {
        // https://doc.thinkphp.cn/v8_0/query_data.html
        $names = $this->productCategory->column('name', 'id');
        return $names;
    }

    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        $query = $this->productCategory
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->order('id desc')
            ->field('id,name,code');

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
        return $this->productCategory->insertGetId($data);
    }

    // 详情
    public function info($id)
    {
        $info = $this->productCategory
            ->field('id,name,code')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 更新
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->productCategory->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->productCategory
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }

    public function selectCount($ids)
    {
        return $this->productCategory->where('id', 'in', $ids)->count('id');
    }

    public function duplicate($name, $code, $id = 0)
    {
        return $this->productCategory
            ->field('id')
            ->when($id > 0, function ($query) use ($id) {
                $query->where('id', '<>', $id);
            })
            ->where([
                'name' => $name,
                'code' => $code,
            ])->find();
    }
}
