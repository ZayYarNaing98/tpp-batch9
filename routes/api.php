<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;


Route::post('/auth/login', [AuthController::class, 'login']);


Route::group(["middleware" => 'auth:api'], function () {
    Route::get('/categories', [CategoryController::class, 'index']);

 Route::post('/categories', [CategoryController::class, 'store']);


});
