<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LoginController;


//USER
Route::post('/register',[LoginController::class,'register']);
Route::post('/login',[LoginController::class,'login']);


//PUBLIC LISTS
Route::get('/blog_list',[BlogController::class,'index']);
Route::get('/blog/{id}', [BlogController::class, 'show']);


//NEED TOKEN

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/add_blog',[BlogController::class,'store']);
    Route::put('/update_blog/{id}', [BlogController::class, 'update']);
    Route::delete('/delete_blog/{id}', [BlogController::class, 'destroy']);


    Route::get('/category_list', [CategoryController::class, 'index']);
});

