@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>My Favorites</h1>

            @if($favorites->isEmpty())
                <p>You haven't added any products to your favorites yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
            @else
                <div class="row">
                    @foreach($favorites as $product)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-success font-weight-bold">${{ number_format($product->price, 2) }}</p>
                                    
                                    <form action="{{ route('favorites.destroy', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                    
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12">
                        {{ $favorites->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
