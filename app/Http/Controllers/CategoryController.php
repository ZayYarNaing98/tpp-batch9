<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::get();

        return view('categories.index', compact('data'));
    }

    public function show($id)
    {
        // dd('here');
        // dd($id);
        $category = Category::find($id);
        // dd($category);

        return view('categories.show', compact('category'));
    }
}
