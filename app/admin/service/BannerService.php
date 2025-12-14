<?php

namespace app\admin\service;

use app\admin\repository\BannerRepository;
use app\admin\repository\FileRepository;

class BannerService extends BaseService
{
    protected BannerRepository $banner;
    protected FileRepository $file;

    public function __construct()
    {
        $this->banner = new BannerRepository();
        $this->file = new FileRepository();
    }

    public function checkCategory($category)
    {
        return in_array($category, [
            'product',
            'index',
            'contact',
            'project',
            'news',
            'customer'
        ]);
    }

    // 列表
    public function index($keyword = '', $category = '', $page = 1, $perPage = 20)
    {
        if ($category) {
            if (!$this->checkCategory($category)) {
                $category = '';
            }
        }
        return $this->banner->index($keyword, $category, $page, $perPage);
    }

    // 新增
    public function create($data, $userID)
    {
        // 图片处理
        if ($data['image']) {
            $imageInfo = $this->file->info($data['image']);
            if (!$imageInfo) {
                $data['image'] = 0;
            }
        }

        // 视频处理
        if ($data['video']) {
            $videoInfo = $this->file->info($data['video']);
            if (!$videoInfo) {
                $data['video'] = 0;
            }
        }

        $bannerData = [
            'title' => $data['title'],
            'category' => $data['category'],
            'summary' => $data['summary'],
            'image' => $data['image'],
            'video' => $data['video'],
            'url' => $data['url'] ?? '',
            'sorted' => $data['sorted'],
            'status' => $data['status'],
            'created_by' => $userID,
        ];

        return $this->banner->create($bannerData);
    }

    // 更新
    public function update($data)
    {
        // 图片处理
        if ($data['image']) {
            $imageInfo = $this->file->info($data['image']);
            if (!$imageInfo) {
                $data['image'] = 0;
            }
        }

        // 视频处理
        if ($data['video']) {
            $videoInfo = $this->file->info($data['video']);
            if (!$videoInfo) {
                $data['video'] = 0;
            }
        }

        $bannerData = [
            'title' => $data['title'],
            'category' => $data['category'],
            'summary' => $data['summary'],
            'image' => $data['image'],
            'video' => $data['video'],
            'url' => $data['url'] ?? '',
            'sorted' => $data['sorted'],
            'status' => $data['status']
        ];

        return $this->banner->update($data['id'], $bannerData);
    }

    // 详情
    public function info($id)
    {
        $info = $this->banner->info($id);
        if (!$info) {
            return [];
        }

        // 处理图片
        $info->image_file = [];
        $info->video_file = [];

        if ($info->image) {
            $imageInfo = $this->file->info($info->image);
            if ($imageInfo) {
                $info->image_file = $imageInfo;
            } else {
                $info->image = 0;
            }
        }

        if ($info->video) {
            $videoInfo = $this->file->batchInfo($info->video);
            if ($videoInfo) {
                $info->video_file = $videoInfo;
            } else {
                $info->video = 0;
            }
        }

        return $info->toArray();
    }

    // 检查选择
    public function checkSelect($ids)
    {
        if ($ids) {
            $count = $this->banner->selectCount($ids);
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

        return $this->banner->delete($ids);
    }
}
