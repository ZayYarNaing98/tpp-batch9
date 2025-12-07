<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Static Route
Route::get('/blogs', function(){
    return "This is Blog Lists";
});

// Dynamic Route
Route::get('/blogs/{id}', function($id){
    return "This is Blog Detail => $id";
});

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Redirect Route
Route::get('/tpp', function(){
    return redirect()->route('dashboard.tpp');
});


// Group Route
Route::prefix('/backend')->group(function(){
    Route::get('/admin', function(){
        return "This is Admin User";
    })->name('admin');

    Route::get('/students', function(){
        return "This is Student User";
    });

    Route::get('/students/{id}', function($id){
        return "This is student details => $id";
    });

    Route::get('/teachers', function(){
        return redirect()->route('dashboard.tpp');
    });

});

// Route::get('/articles', function(){
//     return view('articles.index');
// });


    Route::get('/articles', [ArticleController::class, 'index']);

    // Categories
    Route::get('/categories', [CategoryController::class,'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories/{id}/delete', [CategoryController::class, 'delete'])->name('categories.delete');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::post('/products/{id}', [ProductController::class, 'delete'])->name('products.delete');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
});
