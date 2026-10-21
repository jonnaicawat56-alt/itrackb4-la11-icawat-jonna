@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<h2>Add Product</h2>

@if ($errors->any())
    <div style="color: #dc3545; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="name">Product Name</label><br>
        <input type="text" id="name" name="name"
               value="{{ old('name') }}" required>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="category_id">Category</label><br>
        <select id="category_id" name="category_id" required>
            <option value="">-- Select Category --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="price">Price</label><br>
        <input type="number" id="price" name="price"
               value="{{ old('price') }}" min="0" required>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="stock">Stock</label><br>
        <select id="stock" name="stock" required>
            <option value="">-- Select Stock --</option>
            @foreach ([0, 10, 15, 18, 20, 25, 30] as $stock)
                <option value="{{ $stock }}"
                    {{ old('stock') == (string) $stock ? 'selected' : '' }}>
                    {{ $stock }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit">Save Product</button>
    <a href="{{ route('products.index') }}">Cancel</a>
</form>
@endsection