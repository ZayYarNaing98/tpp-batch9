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

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // dd('here');
        // dd($request);
        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index');

    }


    public function edit($id)
    {
        $category = Category::find($id);

        return view('categories.edit', compact('category'));

    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index');
    }
}
