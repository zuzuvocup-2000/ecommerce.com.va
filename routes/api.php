<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductCatalogueController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api'],'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);    
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function ($router) {
    Route::get('/user/list', [UserController::class, 'list']);
    Route::get('/user/index/{id}', [UserController::class, 'index'])->where(['id' => '[0-9]+']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/update/{id}', [UserController::class, 'update'])->where(['id' => '[0-9]+']);
    Route::post('/user/destroy/{id}', [UserController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'brand'
], function ($router) {
    Route::get('/brand/list', [BrandController::class, 'list']);
    Route::get('/brand/index/{id}', [BrandController::class, 'index'])->where(['id' => '[0-9]+']);
    Route::post('/brand/store', [BrandController::class, 'store']);
    Route::post('/brand/update/{id}', [BrandController::class, 'update'])->where(['id' => '[0-9]+']);
    Route::post('/brand/destroy/{id}', [BrandController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'product'
], function ($router) {
    Route::get('/catalogue/list', [ProductCatalogueController::class, 'list']);
    Route::get('/catalogue/index/{id}', [ProductCatalogueController::class, 'index'])->where(['id' => '[0-9]+']);
    Route::post('/catalogue/store', [ProductCatalogueController::class, 'store']);
    Route::post('/catalogue/update/{id}', [ProductCatalogueController::class, 'update'])->where(['id' => '[0-9]+']);
    Route::post('/catalogue/destroy/{id}', [ProductCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+']);
});
