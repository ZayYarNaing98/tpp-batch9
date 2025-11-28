<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Static Route
Route::get('/blogs', function(){
    return "This is Blog Lists";
});

// Dynamic Route
Route::get('/blogs/{id}', function($id){
    return "This is Blog Detail => $id";
});

// Naming Route
Route::get('/dashboard', function(){
    return "Welcome TPP Program";
})->name('dashboard.tpp');

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

Route::get('/categories', [CategoryController::class,'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
