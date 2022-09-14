<?php

namespace App\Services;

use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Repositories\Interfaces\RoutesRepositoryInterface as RoutesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductCatalogue;
use App\Models\Routes;
use Illuminate\Support\Str;

/**
 * Class ProductCatalogueService
 * @package App\Services
 */
class ProductCatalogueService implements ProductCatalogueServiceInterface
{

    public $productCatalogueRepository;
    public $routesRepository;

    public function __construct(
        ProductCatalogueRepository $productCatalogueRepository,
        RoutesRepository $routesRepository,
    ){
        $this->routesRepository = $routesRepository;
        $this->productCatalogueRepository = $productCatalogueRepository;
    }

    public function getList($request){
        $perpage = $request->input('perpage') ?? 20;
        $productCatalogue = $this->productCatalogueRepository->paginateProductCatalogue($perpage);
        return $productCatalogue;
    }

    public function create($request){

        DB::beginTransaction();
        try{
            $insert = $request->all();
            $insert['canonical'] = Str::slug($insert['canonical'], '-');
            $productCatalogue = $this->productCatalogueRepository->create($insert);

            $routes_insert = [
                'module' => 'products_catalogue',
                'objectid' => $productCatalogue->id,
                'canonical' => $insert['canonical']
            ];
            $routes = $this->routesRepository->create($routes_insert);
            DB::commit();
            return $productCatalogue;
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
            $productCatalogue = $this->productCatalogueRepository->update($id, $update);
                
            $routes_update = [
                'canonical' => $update['canonical']
            ];
            $routes = $this->routesRepository->updateByObjectId($id, 'products_catalogue', $routes_update);
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
            $productCatalogue = $this->productCatalogueRepository->deleteById($id);
            $routes = $this->routesRepository->deleteByObjectId($id, 'products_catalogue');

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
