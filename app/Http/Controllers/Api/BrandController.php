<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Routes;
use Illuminate\Http\Request;
use App\Services\Interfaces\BrandServiceInterface;
use App\Repositories\Interfaces\BrandRepositoryInterface as BrandRepository;
use Validator;
use Illuminate\Support\Str;


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

    public function index(Request $request, $id)
    {
        $brand = $this->brandRepository->findById($id);
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
        $data = $request->all();
        $data['canonical'] = Str::slug($data['canonical'], '-');
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'keyword' => 'required|string|max:255',
            'canonical' => 'required|unique:routes,canonical',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $brand = $this->brandService->create($request);
        if($brand){
            return response()->json([
                'message' => 'Brand successfully created',
                'brand' => $brand
            ], 201);
        }else{
            return response()->json([
                'message' => 'An error occurred, please try again!',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['canonical'] = Str::slug($data['canonical'], '-');
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'keyword' => 'required|string|max:255',
            'canonical' => 'required|unique:routes,canonical,'.$request->id.',object_id,module,brands',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $brand = $this->brandService->update($id, $request);
        if($brand > 0){
            return response()->json([
                'message' => 'Brand successfully updated',
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = $this->brandService->delete($id);
        if($brand > 0){
            return response()->json([
                'message' => 'Brand successfully deleted',
            ], 200);
        }else{
            return response()->json([
                'message' => 'An error occurred, please try again!',
            ], 400);
        }
    }
}
