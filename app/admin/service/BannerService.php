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

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        return $this->banner->index($keyword, $page, $perPage);
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
            'sorted' => $data['sotred'],
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
            'sorted' => $data['sotred'],
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
            $info->image_file = $this->file->info($info->image);
        }

        if ($info->video) {
            $info->video_file = $this->file->batchInfo($info->video);
        }

        return $info->toArray();
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
