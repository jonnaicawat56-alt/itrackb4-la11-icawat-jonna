<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');
        $stock = $request->query('stock');
        $price = $request->query('price');
        $benchmark = $request->query('benchmark');

        // Lesson 10: Query benchmark
        $query = $benchmark === 'after'
            ? Product::with('category')
            : Product::query();

        if ($name !== null && $name !== '') {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($stock !== null && $stock !== '') {
            $query->where('stock', '>=', $stock);
        }

        if ($price !== null && $price !== '') {
            $query->where('price', '<=', $price);
        }

        DB::flushQueryLog();
        DB::enableQueryLog();

        try {
            $products = $query->get();

            // Before: load category for each product
            // After: eager load with with('category')
            if ($benchmark !== 'after') {
                foreach ($products as $product) {
                    $product->category;
                }
            }

            $queryCount = count(DB::getQueryLog());
        } finally {
            DB::disableQueryLog();
        }

        return view('products.index', compact(
            'products',
            'name',
            'stock',
            'price',
            'queryCount'
        ));
    }

    // Show one product using route model binding
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    // Display the edit form
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }

    // Save the updated product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|in:0,10,15,18,20,25,30',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['available'] = $validated['stock'] > 0;

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete one product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    // Existing featured products page
    public function featured()
    {
        $products = Product::with('category')
            ->where('stock', '>=', 20)
            ->get();

        return view('products.featured', compact('products'));
    }

    // Display the create form
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    // Save a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|in:0,10,15,18,20,25,30',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['available'] = $validated['stock'] > 0;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    // Existing stock filter page
    public function filter($stock = null)
    {
        $query = Product::query();

        if ($stock !== null) {
            $query->where('stock', '>=', $stock);
        }

        $products = $query->get();

        return view('products.filter', compact(
            'products',
            'stock'
        ));
    }
}
