@extends('layouts.app')

@section('title', 'Product Details')

@section('content')

<h2 style="margin-bottom: 20px;">Product Details</h2>

<div style="
    background: white;
    border: 1px solid #dddddd;
    border-radius: 6px;
    padding: 20px;
    max-width: 350px;
">

    <h3 style="margin-top: 0; margin-bottom: 15px;">
        {{ $product['name'] }}
    </h3>

    <p>
        <strong>ID:</strong>
        {{ $product['id'] }}
    </p>

    <p>
        <strong>Price:</strong>
        ₱{{ number_format($product['price'], 2) }}
    </p>

    <p>
        <strong>Stock:</strong>
        {{ $product['stock'] }}
    </p>

    <a href="{{ route('products.index') }}"
       class="btn btn-primary"
       style="margin-top: 10px;">
        Back to Products
    </a>

</div>

@endsection
