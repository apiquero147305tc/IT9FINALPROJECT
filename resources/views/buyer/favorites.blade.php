<x-buyerDash>

<script src="https://unpkg.com/lucide@latest"></script>

<style>
    body {
        background: #f8fafc;
    }

    .top-back {
        margin-bottom: 15px;
    }

    .btn {
        padding: 10px 14px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        background: linear-gradient(90deg, #e11d48, #f97316);
        color: white;
        text-decoration: none;
        display: inline-block;
    }

    .btn:hover {
        transform: scale(1.03);
    }

    .page-header {
        background: linear-gradient(90deg, #e11d48, #f97316);
        color: white;
        padding: 25px;
        border-radius: 16px;
        margin-bottom: 20px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
    }

    .page-header p {
        margin-top: 5px;
        opacity: 0.9;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        transition: 0.25s ease;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.10);
    }

    .img {
        height: 200px;
        overflow: hidden;
    }

    .img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .content {
        padding: 15px;
    }

    .name {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #111827;
    }

    .price {
        margin-top: 8px;
        font-size: 18px;
        font-weight: 800;
        color: #e11d48;
    }

    .empty {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        border: 1px solid #eee;
    }
</style>

<div style="padding:30px;">

    {{-- BACK TO PROFILE --}}
    <div class="top-back">
        <a href="{{ route('buyer.profile') }}" class="btn">← Back to Profile</a>
    </div>

    {{-- HEADER --}}
    <div class="page-header">
        <h2>Your Favorites</h2>
        <p>All products you liked are stored here.</p>
    </div>

    @php
        $user = auth()->user();
        $favorites = $user ? ($user->favoriteProducts ?? collect()) : collect();
    @endphp

    @if($favorites->isEmpty())
        <div class="empty">
            <h3>No favorites yet</h3>
            <p style="color:#6b7280;">
                Start exploring products and click the heart icon to save them.
            </p>
        </div>
    @else

        <div class="grid">
            @foreach($favorites as $product)

                <div class="card">

                    <div class="img">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}">
                        @else
                            <img src="https://via.placeholder.com/300x200">
                        @endif
                    </div>

                    <div class="content">
                        <p class="name">{{ $product->name }}</p>

                        <div class="price">
                            ₱{{ number_format($product->price, 2) }}
                        </div>

                        <form action="{{ route('favorite.toggle', $product->id) }}" method="POST" style="margin-top:10px;">
                            @csrf
                            <button style="
                                width:100%;
                                padding:10px;
                                border:none;
                                border-radius:10px;
                                background:#111;
                                color:white;
                                font-weight:600;
                                cursor:pointer;
                            ">
                                Remove
                            </button>
                        </form>
                    </div>

                </div>

            @endforeach
        </div>

    @endif

</div>

<script>
    lucide.createIcons();
</script>

</x-buyerDash>