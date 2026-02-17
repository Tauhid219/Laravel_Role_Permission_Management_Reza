<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:create product', only: ['create', 'store']),
            new Middleware('permission:update product', only: ['edit', 'update']),
            new Middleware('permission:view product', only: ['index', 'show']),
            new Middleware('permission:delete product', only: ['destroy']),
        ];
    }
    
    public function index()
    {
        $products = Product::paginate(10);
        return view('product.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(StoreProductRequest $request)
    {
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect('product')->with('status', 'Product Created Successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        Product::findOrFail($id)->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect('product')->with('status', 'Product Updated Successfully');
    }

    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return redirect('product')->with('status', 'Product Deleted Successfully');
    }
}
