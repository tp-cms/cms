<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\service\FileService;
use app\trait\ResponseTrait;
use think\App;
use think\facade\View;

// 大文件错误提示
// PHP Request Startup: POST Content-Length of 9536740 bytes exceeds the limit of 8388608 bytes in
// php.ini
// 修改配置
// upload_max_filesize = 20M   ; 允许上传的最大文件大小，单位是MB
// post_max_size = 20M         ; 允许的最大 POST 数据大小，单位是MB
// 其他（可选）
// max_execution_time = 300     ; 允许脚本执行的最大时间，单位秒
// max_input_time = 300         ; 允许 PHP 处理输入数据的最大时间

// openresty
// client_max_body_size 20M;  # 设置最大上传文件大小

class File extends Base
{
    use ResponseTrait;
    protected FileService $file;
    protected FileCategoryService $fileCategory;
    protected $allowedPrefixes;

    public function __construct(App $app)
    {
        $this->file = new FileService();
        $this->fileCategory = new FileCategoryService();
        $this->allowedPrefixes = [
            'image/',      // png, jpg, jpeg, gif, webp
            'video/',      // mp4, mov, avi...
            'application/pdf', // PDF

            // Word
            'application/msword', // .doc
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx

            // Excel
            'application/vnd.ms-excel', // .xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
        ];
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@file/index');
    }

    // 文件列表
    public function index()
    {
        $page = input('post.p', 1);
        $keyword = input('post.keyword', '');
        $categoryId = input('post.category', 0);
        $fileType = strtolower(input('post.type', 'all'));
        // 这里弹出框选中时使用，这里先使用一个接口处理下
        if (!in_array($fileType, ['all', 'image', 'video'])) {
            $fileType = 'all';
        }
        $list = $this->file->index($keyword, $categoryId, $fileType, $page);
        return $this->suc($list);
    }

    // 文件上传
    public function upload()
    {
        // 用户id
        $userID = $this->request->user['id'];
        // 文件信息
        $file = $this->request->file('file');

        if (!$file) {
            return $this->err('未选择文件',);
        }

        // 判断下
        $mime = $this->file->mimeType($file);
        $valid = false;
        foreach ($this->allowedPrefixes as $prefix) {
            if (str_starts_with($mime, $prefix)) {
                $valid = true;
                break;
            }
        }
        if (!$valid) {
            return $this->err('只允许上传图片/视频/文档,不支持' . $mime);
        }

        // 上传
        try {
            $res = $this->file->upload($file, $userID);
            return $this->suc($res);
        } catch (\Exception $e) {
            return $this->err($e->getMessage());
        }
    }

    // 文件上传（批量）
    public function uploadMultiple()
    {
        // 用户id
        $userID = $this->request->user['id'];
        // 文件信息
        $files = $this->request->file('files');

        if (!$files) {
            return $this->err('未选择文件',);
        }

        foreach ($files as $file) {
            // 判断下
            $mime = $this->file->mimeType($file);
            $valid = false;
            foreach ($this->allowedPrefixes as $prefix) {
                if (str_starts_with($mime, $prefix)) {
                    $valid = true;
                    break;
                }
            }
            if (!$valid) {
                return $this->err('只允许上传图片/视频/文档,不支持' . $mime);
            }
        }

        // 上传
        try {
            $res = $this->file->uploadMultiple($files, $userID);
            return $this->suc($res);
        } catch (\Exception $e) {
            return $this->err($e->getMessage());
        }
    }
}
