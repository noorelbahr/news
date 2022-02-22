<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function findByEmail($email);

    public function create($name, $email, $password, $gender = null, $editorId = null);

    public function update($id, $name, $email, $gender = null, $editorId = null);

    public function updatePassword($id, $password, $editorId = null);
}
