@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h2 style="color: var(--crave-red); margin: 0;">Marketplace Items</h2>
    
    <a href="#" style="text-decoration: none; display: flex; align-items: center; gap: 8px; background: #3498db; color: white; padding: 8px 15px; border-radius: 8px; font-weight: bold; font-size: 0.9rem;">
        <i class="fas fa-hand-holding-heart"></i> My Borrowed Items
    </a>
</div>

<div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
    @foreach($products as $product)
    <div class="card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" style="width: 100%; height: 200px; object-fit: cover;">
        
        <div class="card-body" style="padding: 15px;">
            <h3 style="margin-top: 0; font-size: 1.1rem; min-height: 2.4em; color: #333;">{{ $product->name }}</h3>
            
            <p style="color: var(--crave-red); font-weight: bold; font-size: 1.2rem; margin: 10px 0;">
                ₱{{ number_format($product->price, 2) }}
            </p>
            
            <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">
                Category: <span style="color: var(--crave-orange); font-weight: 600;">{{ $product->category }}</span>
            </p>
            
            <div class="card-footer" style="display: flex; flex-direction: column; gap: 10px;">
                <button class="btn-action" style="width: 100%; cursor: pointer;">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
                
                <button class="btn-secondary" style="width: 100%; padding: 10px; border: 2px solid #3498db; background: transparent; color: #3498db; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                    <i class="fas fa-handshake"></i> Request Lending
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($products->isEmpty())
    <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 12px; margin-top: 20px; border: 2px dashed var(--crave-pink);">
        <p style="font-size: 1.2rem; color: #888;">No products found in the database. Start by adding some!</p>
    </div>
@endif

<style>
    .btn-secondary:hover {
        background: #3498db;
        color: white;
    }
</style>
@endsection