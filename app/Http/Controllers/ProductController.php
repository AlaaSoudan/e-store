<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;


class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function index()
{
    $products = Product::with('supplier')->get();
    return view('products.index', compact('products'));
}
  public function create()
    {
        $suppliers = Supplier::all();
        return view('products.create', compact('suppliers'));
    }

public function store(ProductRequest $request)
{
    $this->productService->create($request->validated());
    return redirect()->route('products.index');
}
    public function edit(Product $product)
    {
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'suppliers'));
    }
     public function update(ProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
        public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
