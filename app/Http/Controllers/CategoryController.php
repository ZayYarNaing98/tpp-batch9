<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryUpdateRequest;
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
        // dd($request->all());
        $data = $request->validate([
            'name' => 'required|string',
            'image' => 'required'
        ]);

        if ($request->hasFile('image'))
        {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('categoryImages'), $imageName);

            $data = array_merge($data, ['image' => $imageName]);
        }


        Category::create($data);

        return redirect()->route('categories.index');

    }


    public function edit($id)
    {
        $category = Category::find($id);

        return view('categories.edit', compact('category'));

    }

    public function update(CategoryUpdateRequest $request)
    {
        $category = Category::find($request->id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('categories.index');
    }
}
