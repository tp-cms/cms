<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\service\FileService;
use app\trait\ResponseTrait;
use think\App;

class File extends Base
{
    use ResponseTrait;
    protected FileService $file;
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->file = new FileService();
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    public function index()
    {
        return 'Hello, File';
    }

    // 文件上传
    public function upload()
    {
        // 用户id
        $userID = $this->request->user['id'];
        // 文件信息
        $files = $this->request->file('file');

        if (!$files) {
            return $this->err('未选择文件',);
        }

        if (!is_array($files)) {
            $files = [$files];
        }

        // 允许上传文件前缀
        $allowedPrefixes = ['image/', 'video/'];

        // 判断下
        foreach ($files as $file) {
            $mime = $this->file->mimeType($file);
            $valid = false;
            foreach ($allowedPrefixes as $prefix) {
                if (str_starts_with($mime, $prefix)) {
                    $valid = true;
                    break;
                }
            }
            if (!$valid) {
                return $this->err('只允许上传图片/视频,不支持' . $mime);
            }
        }


        // 上传
        try {
            $res = $this->file->fileUpload($files, $userID);
            return $this->suc($res);
        } catch (\Exception $e) {
            return $this->err($e->getMessage());
        }
    }
}
