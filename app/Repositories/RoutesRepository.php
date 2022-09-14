<?php

namespace App\Repositories;

use App\Models\Routes;
use App\Repositories\Interfaces\RoutesRepositoryInterface;
use DB;

class RoutesRepository extends BaseRepository implements RoutesRepositoryInterface
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
    public function __construct(Routes $model)
    {
        $this->model = $model;
    }

    public function updateByObjectId($id, $module, $routes_update){
        $model = $this->getByObjectId($id, $module);
        return $this->update($model->id, $routes_update);
    }

    public function deleteByObjectId($id, $module){
        $model = $this->getByObjectId($id, $module);
        return $this->deleteById($model->id);
    }

    public function getByObjectId($id, $module){
        return DB::table('routes')->where([
            ['objectid', $id],
            ['module',  $module],
        ])->first();
    }
}
