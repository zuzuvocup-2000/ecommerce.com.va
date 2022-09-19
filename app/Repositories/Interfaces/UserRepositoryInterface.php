<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface UserRepositoryInterface extends BaseRepositoryInterface
{
   public function paginateUser($perpage);
}
