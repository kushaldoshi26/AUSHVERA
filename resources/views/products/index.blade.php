@extends('layouts.app')

@section('title', 'Products — AUSHVERA')

@push('styles')
<style>
.products-hero { padding: 8rem 3rem 4rem; background: var(--cream); margin-top: 80px; }
.products-grid { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; }
.product-card-full { background: white; border: 1px solid rgba(198, 167, 94, 0.2); border-radius: 8px; overflow: hidden; transition: all 0.3s; cursor: pointer; }
.product-card-full:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
.product-card-full img { width: 100%; height: 300px; object-fit: cover; }
.product-card-full .content { padding: 2rem; }
.product-card-full h3 { font-family: 'Playfair Display', serif; color: #C6A75E; margin-bottom: 0.5rem; }
.product-card-full .price { font-size: 1.5rem; color: #0B1C2D; font-weight: 600; margin-top: 1rem; }
</style>
@endpush

@section('content')
<section class="products-hero">
    <h1 style="text-align: center; font-family: 'Cinzel', serif; font-size: 3rem; color: #0B1C2D; margin-bottom: 3rem;">Our Products</h1>
    <div class="products-grid">
        @foreach($products as $product)
        <div class="product-card-full" onclick="window.location.href='{{ route('products.show', $product->id) }}'">
            <img src="{{ asset('assets/img/product.jpeg') }}" alt="{{ $product->name }}">
            <div class="content">
                <h3>{{ $product->name }}</h3>
                <p>{{ Str::limit($product->description, 100) }}</p>
                <div class="price">₹{{ number_format($product->price, 2) }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
