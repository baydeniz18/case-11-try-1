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

//NEED TOKEN
Route::post('/add_blog',[BlogController::class,'store']);
Route::get('/category_list', [CategoryController::class, 'index']);

