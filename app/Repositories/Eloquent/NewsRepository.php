<?php

namespace App\Repositories\Eloquent;

use App\Models\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    /**
     * @var News
     */
    private $model;

    /**
     * NewsRepository constructor.
     * - - -
     * @param News $model
     */
    public function __construct(News $model)
    {
        $this->model = $model;
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getPaginated($limit)
    {
        return $this->model->latest()->simplePaginate($limit);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $userId
     * @param $categoryId
     * @param $title
     * @param null $body
     * @param null $tags
     * @param null $editorId
     * @return mixed
     */
    public function create($userId, $categoryId, $title, $body = null, $tags = null, $editorId = null)
    {
        return $this->model->create([
            'category_id' => $categoryId,
            'user_id' => $userId,
            'title' => $title,
            'body' => $body,
            'tags' => $tags,
            'created_by' => $editorId
        ]);
    }

    /**
     * @param $id
     * @param $categoryId
     * @param $title
     * @param null $body
     * @param null $tags
     * @param null $editorId
     * @return mixed
     */
    public function update($id, $categoryId, $title, $body = null, $tags = null, $editorId = null)
    {
        return $this->model->where('id', $id)
            ->update([
                'category_id' => $categoryId,
                'title' => $title,
                'body' => $body,
                'tags' => $tags,
                'updated_by' => $editorId
            ]);
    }
}
