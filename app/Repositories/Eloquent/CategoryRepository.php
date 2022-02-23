<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var Category
     */
    private $model;

    /**
     * CategoryRepository constructor.
     * - - -
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
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
     * @param $name
     * @param $slug
     * @param null $editorId
     * @return mixed
     */
    public function create($name, $slug, $editorId = null)
    {
        return $this->model->create([
            'name' => $name,
            'slug' => $slug,
            'created_by' => $editorId
        ]);
    }

    /**
     * @param $id
     * @param $name
     * @param $slug
     * @param null $editorId
     * @return mixed
     */
    public function update($id, $name, $slug, $editorId = null)
    {
        return $this->model->where('id', $id)
            ->update([
                'name' => $name,
                'slug' => $slug,
                'updated_by' => $editorId
            ]);
    }
}
