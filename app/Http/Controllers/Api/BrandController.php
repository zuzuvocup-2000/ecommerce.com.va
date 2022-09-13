<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Routes;
use Illuminate\Http\Request;
use App\Services\Interfaces\BrandServiceInterface;
use App\Repositories\Interfaces\BrandRepositoryInterface as BrandRepository;
use Validator;



class BrandController extends Controller
{
    protected $brandRepository;
    protected $brandService;
    public function __construct(BrandServiceInterface $brandService, BrandRepository $brandRepository){
        $this->brandService = $brandService;
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $brand = $this->brandService->getList($request);
        return response()->json([
            'brand' => $brand
        ], 200);
    }

    public function index(Request $request)
    {
        $id = ($request->input('id') ? $request->input('id') : 0);
        $brand = $this->brandRepository->findById($id);
        print_r($brand);die();
        return response()->json([
            'brand' => $brand
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'keyword' => 'required|string|max:255',
            'canonical' => 'required|unique:routes,canonical',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        // Add brand

        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->keyword = $request->input('keyword');
        $brand->canonical = $request->input('canonical');
        $brand->description = $request->input('description');
        $brand->save();

        // Add routes
        $routes = new Routes();
        $routes->module = 'brands';
        $routes->objectid = $brand->id;
        $routes->canonical = $request->input('canonical');
        $routes->save();

        return response()->json([
            'message' => 'Brand successfully created',
            'brand' => $brand
        ], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
