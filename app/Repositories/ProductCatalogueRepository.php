<?php

namespace App\Repositories;

use App\Models\ProductCatalogue;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;

class ProductCatalogueRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
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
    public function __construct(ProductCatalogue $model)
    {
        $this->model = $model;
    }

    public function paginateProductCatalogue($perpage){
        return $this->model->paginate($perpage);
    }
}
