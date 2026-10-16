<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');
        $stock = $request->query('stock');

        $query = Product::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($stock !== null && $stock !== '') {
            $query->where('stock', '>=', $stock);
        }

        $products = $query->get()->toArray();

        return view('products.index', compact(
            'products',
            'name',
            'stock'
        ));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id)->toArray();

        return view('products.show', compact('product'));
    }

    public function featured()
    {
        $products = Product::where('stock', '>=', 20)
            ->get()
            ->toArray();

        return view('products.featured', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|in:0,10,15,18,20,25,30',
        ]);

        $validated['available'] = $validated['stock'] > 0;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    public function filter($stock = null)
    {
        $query = Product::query();

        if ($stock !== null) {
            $query->where('stock', '>=', $stock);
        }

        $products = $query->get()->toArray();

        return view('products.filter', compact(
            'products',
            'stock'
        ));
    }
}