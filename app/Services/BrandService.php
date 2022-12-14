<?php

namespace App\Services;

use App\Services\Interfaces\BrandServiceInterface;
use App\Repositories\Interfaces\BrandRepositoryInterface as BrandRepository;
use App\Repositories\Interfaces\RoutesRepositoryInterface as RoutesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Brand;
use App\Models\Routes;
use Illuminate\Support\Str;

/**
 * Class BrandService
 * @package App\Services
 */
class BrandService implements BrandServiceInterface
{

    public $brandRepository;
    public $routesRepository;

    public function __construct(
        BrandRepository $brandRepository,
        RoutesRepository $routesRepository,
    ){
        $this->routesRepository = $routesRepository;
        $this->brandRepository = $brandRepository;
    }

    public function getList($request){
        $perpage = $request->input('perpage') ?? 20;
        $brand = $this->brandRepository->paginateBrand($perpage);
        return $brand;
    }

    public function create($request){

        DB::beginTransaction();
        try{
            $insert = $request->all();
            $insert['canonical'] = Str::slug($insert['canonical'], '-');
            $brand = $this->brandRepository->create($insert);

            $routes_insert = [
                'module' => 'brands',
                'object_id' => $brand->id,
                'canonical' => $insert['canonical']
            ];
            $routes = $this->routesRepository->create($routes_insert);
            DB::commit();
            return $brand;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try{
            $update = $request->except(['create']);
            $brand = $this->brandRepository->update($id, $update);
                
            $routes_update = [
                'canonical' => $update['canonical']
            ];
            $routes = $this->routesRepository->updateByObjectId($id, 'brands', $routes_update);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function delete($id){
        DB::beginTransaction();
        try{
            $brand = $this->brandRepository->deleteById($id);
            $routes = $this->routesRepository->deleteByObjectId($id, 'brands');

            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
     }
}
