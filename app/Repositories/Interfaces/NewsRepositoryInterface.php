<?php

namespace App\Repositories\Interfaces;

interface NewsRepositoryInterface
{
    public function getPaginated($limit);

    public function findOrFail($id);

    public function create($userId, $categoryId, $title, $body = null, $tags = null, $editorId = null);

    public function update($id, $categoryId, $title, $body = null, $tags = null, $editorId = null);
}
