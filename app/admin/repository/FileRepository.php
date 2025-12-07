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

    public function hashesAndUser($hashes, $userID)
    {
        return $this->file->where('created_by', $userID)
            ->whereIn('hash_name', $hashes)
            ->select();
    }

    public function create($data)
    {
        return $this->file->create($data);
    }
}
