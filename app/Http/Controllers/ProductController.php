<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {

        $products = $this->productRepository->index();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->index();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required',
            'category_id' => 'required',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('productImages'), $imageName);

            $data = array_merge($data, ['image' => $imageName]);
        }

        $data['status'] = $request->has('status') ? true : false;

        $this->productRepository->store($data);

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = $this->productRepository->show($id);
        $categories = $this->categoryRepository->index();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(ProductUpdateRequest $request)
    {
        $product = $this->productRepository->show($request->id);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'status' => $request->has('status') ? true : false,
        ]);

        return redirect()->route('products.index');
    }

    public function delete($id)
    {
        $product = $this->productRepository->show($id);

        $product->delete();

        return redirect()->route('products.index');
    }
}
