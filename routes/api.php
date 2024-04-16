<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;

Route::get('/category_list', [CategoryController::class, 'index']);
Route::get('/blog_list',[BlogController::class,'index']);
Route::post('/add_blog',[BlogController::class,'store']);

// Route::group(['prefix' => 'blog'], function () {
//     Route::get('/blog_list', [BlogController::class, 'index']);

//     Route::post('/add_blog',[BlogController::class,'store']);
// });


Route::any('/', function () {
    return response()->json([
        'S'=>'H',
        'message' => 'Route Yanlış.'
    ]);
});