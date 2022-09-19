<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register($data){
        $data['password'] = bcrypt($data['password']);
        $user = $this->model->create($data);
        if($data['parent_id']){
            $tree = $this->model->find($data['parent_id'])->appendNode($user);
        }

        return $user->fresh();
    }
}
