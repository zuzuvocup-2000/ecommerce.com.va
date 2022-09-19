<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/{url}', [App\Http\Controllers\BaseController::class, 'index'])->name('home');


// Route::get('chat', function () {
//     return view('chat');
// });

// Route::post('message', function (Request $request) {
//     broadcast(new MessageSent(auth()->user(), $request->input('message')));

//     return $request->input('message');
// });