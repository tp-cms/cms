<?php

namespace app\admin\repository;

use app\model\File;

class FileRepository extends BaseRepository
{
    protected File $file;

    public function __construct()
    {
        $this->file = new File();
    }

    public function hashDuplicate($hash, $userID)
    {
        return $this->file->where([
            'hash_name' => $hash,
            'created_by' => $userID,
        ])->find();
    }

    public function create($data)
    {
        return $this->file->create($data);
    }
}
