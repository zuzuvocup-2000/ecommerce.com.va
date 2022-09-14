<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface RoutesRepositoryInterface extends BaseRepositoryInterface
{
    public function updateByObjectId($id, $module, $routes_update);
    public function deleteByObjectId($id, $module);
    public function getByObjectId($id, $module);
}
