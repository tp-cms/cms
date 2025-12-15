<?php

namespace app\admin\service;

use app\admin\repository\CustomerRepository;
use app\admin\repository\FileRepository;

class CustomerService extends BaseService
{
    protected CustomerRepository $customer;
    protected FileRepository $file;

    public function __construct()
    {
        $this->customer = new CustomerRepository();
        $this->file = new FileRepository();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->customer->index($keyword, $page, $perPage);
    }

    // 详情
    public function info($id)
    {
        $info = $this->customer->info($id);
        if (!$info) {
            return [];
        }
        $info->logi_file = [];
        if ($info->logo) {
            $logoInfo = $this->file->pathInfo($info->logo);
            if ($logoInfo) {
                $info->logo_file = $logoInfo;
            }
        }

        return $info->toArray();
    }

    // 新增
    public function create($data, $userID)
    {
        if ($data['logo']) {
            $logoFile = $this->file->pathInfo($data['logo']);
            if (!$logoFile) {
                $data['logo'] = 0;
            }
        }

        $customerData = [
            'name' => $data['name'],
            'logo' => $data['logo'],
            'url' => $data['url'],
            'created_by' => $userID,
        ];

        return $this->customer->create($customerData);
    }

    // 更新
    public function update($data)
    {
        if ($data['logo']) {
            $logoFile = $this->file->pathInfo($data['logo']);
            if (!$logoFile) {
                $data['logo'] = 0;
            }
        }

        $customerData = [
            'name' => $data['name'],
            'logo' => $data['logo'],
            'url' => $data['url'],
        ];

        return $this->customer->update($data['id'], $customerData);
    }

    // 删除
    public function delete($ids)
    {
        if (!$ids) {
            return false;
        }

        return $this->customer->delete($ids);
    }

    public function checkSelect($ids)
    {
        if ($ids) {
            $count = $this->customer->selectCount($ids);
            return count($ids) == $count;
        }
        return false;
    }
}
