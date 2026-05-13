@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filters</h5>

                    <form action="{{ route('products.search') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   value="{{ request('search') }}" placeholder="Search products...">
                        </div>

                        <!-- Category Filter -->
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="form-group">
                            <label for="price_range">Price Range</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" 
                                           placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" 
                                           placeholder="Max" value="{{ request('max_price', $maxPrice) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="form-group">
                            <label for="min_rating">Minimum Rating</label>
                            <select name="min_rating" id="min_rating" class="form-control">
                                <option value="">All Ratings</option>
                                <option value="4" {{ request('min_rating') == 4 ? 'selected' : '' }}>4+ Stars</option>
                                <option value="3" {{ request('min_rating') == 3 ? 'selected' : '' }}>3+ Stars</option>
                                <option value="2" {{ request('min_rating') == 2 ? 'selected' : '' }}>2+ Stars</option>
                                <option value="1" {{ request('min_rating') == 1 ? 'selected' : '' }}>1+ Star</option>
                            </select>
                        </div>

                        <!-- Sort Options -->
                        <div class="form-group">
                            <label for="sort_by">Sort By</label>
                            <select name="sort_by" id="sort_by" class="form-control">
                                <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>Highest Rating</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                        <a href="{{ route('products.search') }}" class="btn btn-secondary btn-block mt-2">Clear Filters</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Display -->
        <div class="col-md-9">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3>Search Results</h3>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    No products found. Try adjusting your filters.
                </div>
            @else
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-success font-weight-bold">${{ number_format($product->price, 2) }}</p>
                                    
                                    @if($product->getAverageRating() > 0)
                                        <div class="mb-2">
                                            <span class="badge badge-warning">{{ number_format($product->getAverageRating(), 1) }}★</span>
                                            <small>({{ $product->getReviewCount() }} reviews)</small>
                                        </div>
                                    @endif

                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
