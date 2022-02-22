<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $model;

    /**
     * UserRepository constructor.
     * - - -
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     * @param null $gender
     * @param null $editorId
     * @return mixed
     */
    public function create($name, $email, $password, $gender = null, $editorId = null)
    {
        return $this->model->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'gender' => $gender,
            'created_by' => $editorId,
        ]);
    }

    /**
     * @param $id
     * @param $name
     * @param $email
     * @param null $gender
     * @param null $editorId
     * @return mixed
     */
    public function update($id, $name, $email, $gender = null, $editorId = null)
    {
        return $this->model->where('id', $id)
            ->update([
                'name' => $name,
                'email' => $email,
                'gender' => $gender,
                'updated_by' => $editorId,
            ]);
    }

    /**
     * @param $id
     * @param $password
     * @param null $editorId
     * @return mixed
     */
    public function updatePassword($id, $password, $editorId = null)
    {
        return $this->model->where('id', $id)
            ->update([
                'password' => $password,
                'updated_by' => $editorId,
            ]);
    }
}
