<?php

namespace app\admin\controller;

use app\admin\service\ProductCategoryService;
use app\admin\validate\ProductCategoryValidate;
use think\App;
use think\facade\View;

class ProductCategory extends Base
{
    protected ProductCategoryService $productCategory;
    protected ProductCategoryValidate $productCategoryValidate;

    public function __construct(App $app)
    {
        $this->productCategory = new ProductCategoryService();
        $this->productCategoryValidate = new ProductCategoryValidate();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@productcategory/index');
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除产品');
        }

        // 是否选择正确
        $check = $this->productCategory->checkSelect($ids);
        if (!$check) {
            return $this->err('产品选择错误');
        }

        // 删除前判断
        $hasProduct = $this->productCategory->checkDelete($ids);
        if ($hasProduct) {
            return $this->err('请先删除分类下的产品信息');
        }

        $this->productCategory->delete($ids);

        return $this->suc();
    }
}
