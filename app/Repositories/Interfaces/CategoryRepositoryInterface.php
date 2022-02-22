<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAll();

    public function getPaginated($limit);

    public function findOrFail($id);

    public function create($name, $slug, $editorId = null);

    public function update($id, $name, $slug, $editorId = null);
}
