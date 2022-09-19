<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCatalogue;
use App\Models\Routes;
use Illuminate\Http\Request;
use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use Validator;
use Illuminate\Support\Str;


class ProductCatalogueController extends Controller
{
    protected $productCatalogueRepository;
    protected $productCatalogueService;
    public function __construct(
        ProductCatalogueServiceInterface $productCatalogueService, 
        ProductCatalogueRepository $productCatalogueRepository
    ){
        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueRepository = $productCatalogueRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $productCatalogue = $this->productCatalogueService->getList($request);
        return response()->json([
            'product_catalogue' => $productCatalogue
        ], 200);
    }

    public function index(Request $request, $id)
    {
        $productCatalogue = $this->productCatalogueRepository->findById($id);
        return response()->json([
            'product_catalogue' => $productCatalogue
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $data = $request->all();
        $data['canonical'] = Str::slug($data['canonical'], '-');
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'canonical' => 'required|unique:routes,canonical',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $productCatalogue = $this->productCatalogueService->create($request);
        if($productCatalogue){
            return response()->json([
                'message' => 'Product catalogue successfully created',
                'product_catalogue' => $productCatalogue
            ], 201);
        }else{
            return response()->json([
                'message' => 'An error occurred, please try again!',
            ], 400);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCatalogue  $productCatalogue
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCatalogue $productCatalogue)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCatalogue  $productCatalogue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['canonical'] = Str::slug($data['canonical'], '-');
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'canonical' => 'required|unique:routes,canonical,'.$request->id.',object_id,module,products_catalogue',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $productCatalogue = $this->productCatalogueService->update($id, $request);
        if($productCatalogue > 0){
            return response()->json([
                'message' => 'Product catalogue successfully updated',
            ], 200);
        }else{
            return response()->json([
                'message' => 'An error occurred, please try again!',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCatalogue  $productCatalogue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productCatalogue = $this->productCatalogueService->delete($id);
        if($productCatalogue > 0){
            return response()->json([
                'message' => 'Product catalogue successfully deleted',
            ], 200);
        }else{
            return response()->json([
                'message' => 'An error occurred, please try again!',
            ], 400);
        }
    }
}
