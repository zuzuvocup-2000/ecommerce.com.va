<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface BrandRepositoryInterface extends BaseRepositoryInterface
{
   public function paginateBrand($perpage);
}
