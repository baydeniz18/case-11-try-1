<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/category_list', [CategoryController::class, 'index']);

Route::get('/api-test', function () {
    return 'bla';
});

