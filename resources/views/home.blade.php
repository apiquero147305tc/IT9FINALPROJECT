<x-layout>

<!-- HERO -->
<section class="hero">
    <div class="hero-text">
        <h1>Essentials and Necessities,<br>Delivered to Your Door!</h1>
        <p>Shop a wide range of essential products for yourself and your family.</p>
         <a href="{{ route('chooseRole') }}" class="btn">SHOP NOW</a>
    </div>

    <div class="hero-img">
        <img src="{{ asset('images/hero.png') }}">
    </div>
</section>


<!-- CATEGORIES -->
<section class="categories">
    <h2>Our Top Categories</h2>

    <div class="category-grid">
        <div class="cat">Groceries</div>
        <div class="cat">Baby</div>
        <div class="cat">Home</div>
        <div class="cat">Health</div>
        <div class="cat">Personal</div>
    </div>

    <button class="outline-btn">View All Categories</button>
</section>


<!-- PRODUCTS -->
<section class="products">
    <h2>Best Sellers</h2>

    <div class="product-grid">
        @foreach($products as $product)
        <div class="card">
            <div class="heart">❤</div>

            <img src="{{ $product['image'] }}">

            <h3>{{ $product['name'] }}</h3>
            <p>${{ $product['price'] }}</p>

            <button class="cart-btn">ADD TO CART</button>
        </div>
        @endforeach
    </div>
</section>


<!-- PROMO -->
<section class="promo">
    <h2>Get 50% OFF Your First Order!</h2>
    <p>Sign up today and enjoy exclusive deals.</p>
    <button class="signup-btn btn"><a href="chooseRole" class="cravecartlogo">SIGN UP NOW</a></button>
</section>

</x-layout>