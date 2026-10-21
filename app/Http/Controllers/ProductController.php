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

    // SS7: After with()
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

        // SS6: Load categories one by one.
        // SS7: with('category') loads them together.
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

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function featured()
    {
        $products = Product::with('category')
            ->where('stock', '>=', 20)
            ->get();

        return view('products.featured', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

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
