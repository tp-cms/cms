<?php

namespace app\admin\repository;

use app\model\Project;

class ProjectRepository extends BaseRepository
{
    protected Project $project;

    public function __construct()
    {
        $this->project = new Project();
    }

    // 列表
    public function index($keyword = '', $page = 1, $perPage = 20)
    {
        $query = $this->project
            ->alias('p')
            ->join('file f', 'p.cover = f.id', 'left')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('p.title', 'like', '%' . $keyword . '%');
            })
            ->order('p.id desc')
            ->field('p.id,p.title,p.summary,p.cover,p.status,p.is_top,p.tag,p.created_at,f.path as file_path, f.mime as file_mime');

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


    // 详情
    public function info($id)
    {
        $info = $this->project
            ->field('id,cover,title,summary,content,cover,status,is_top,tag,created_at')
            ->where(['id' => $id])
            ->find();

        return $info;
    }

    // 添加
    public function create($data)
    {
        return $this->project->insertGetId($data);
    }

    // 更新
    public function update($id, $data)
    {
        return $this->project->update($data, ['id' => $id]);
    }

    // 删除
    public function delete(array $ids)
    {
        return $this->project
            ->where('id', 'in', $ids)
            ->useSoftDelete('deleted_at', date('Y-m-d H:i:s'))
            ->delete();
    }
}
