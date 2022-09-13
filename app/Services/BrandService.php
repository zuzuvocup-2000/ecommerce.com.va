<?php

namespace App\Services;

use App\Services\Interfaces\BrandServiceInterface;
use App\Repositories\Interfaces\BrandRepositoryInterface as BrandRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Brand;

/**
 * Class BrandService
 * @package App\Services
 */
class BrandService implements BrandServiceInterface
{

    public $brandRepository;

    public function __construct(
        BrandRepository $brandRepository
    ){
        $this->brandRepository = $brandRepository;
    }

    public function getList($request){
        $perpage = $request->input('perpage') ?? 20;
        $brand = $this->brandRepository->paginateBrand($perpage);
        return $brand;
     }
}
