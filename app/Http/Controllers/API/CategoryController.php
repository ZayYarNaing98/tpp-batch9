<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::get();

        $result = CategoryResource::collection($categories);

        return $this->success($result, "Categories Retrieved Successfully", 200);
    }

    public function show($id)
    {
        $category = Category::find($id);

        $result = new CategoryResource($category);

        return $this->success($result, "Category Show Successfully", 200);
    }

    public function store(Request $request)
    {
        // dd('hree');

        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required',
        ]);

        if ($validation->fails()) {
            return $this->error("Validation Error", $validation->errors(), 422);
        }

        if ($request->hasFile('image'))
        {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('categoryImages'), $imageName);
        }

        $category = Category::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);


        return $this->success($category, "Category created successfully", 201);
    }
}
