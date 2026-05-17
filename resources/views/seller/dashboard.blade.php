<x-sellerDash>

<div style="padding: 20px; max-width: 1200px; margin: 0 auto;">

    <!-- HEADER SECTION -->
    <div style="background: linear-gradient(135deg, #dd0d22 0%, #b30b1b 100%); color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="margin: 0 0 10px 0; font-size: 1.8rem;">🍱 CraveCart | Seller Studio</h2>
        <p style="margin: 0; opacity: 0.9; font-size: 1rem;">Store Overview & Performance</p>

        <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('seller.profile') }}" style="padding: 10px 20px; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 0.9rem;">🚁 Edit Profile</a>
            <a href="{{ route('seller.orders') }}" style="padding: 10px 20px; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 0.9rem;">📊 Order Hub</a>
            <a href="{{ route('lending.seller') }}" style="padding: 10px 20px; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 0.9rem;">📚 Lending Management</a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0 0 15px 0; color: #666; font-size: 1rem;">My Inventory</h3>
            <div style="font-size: 2.5rem; font-weight: bold; color: #dd0d22; margin-bottom: 10px;">{{ $products->count() }}</div>
            <div style="font-size: 2rem;">📦</div>
        </div>
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0 0 15px 0; color: #666; font-size: 1rem;">Total Revenue</h3>
            <div style="font-size: 2.5rem; font-weight: bold; color: #dd0d22; margin-bottom: 10px;">₱{{ number_format($totalEarnings, 2) }}</div>
            <div style="font-size: 2rem;">💰</div>
        </div>
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="margin: 0 0 15px 0; color: #666; font-size: 1rem;">Pending Orders</h3>
            <div style="font-size: 2.5rem; font-weight: bold; color: #dd0d22; margin-bottom: 10px;"><strong>{{ $notifCount }}</strong></div>
            <div style="font-size: 2rem;">📊</div>
        </div>
    </div>

    <!-- PRODUCTS SECTION -->
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="margin: 0; color: #333; font-size: 1.5rem;">🛍️ Active Inventory</h2>
            <a href="{{ route('products.create') }}" style="padding: 10px 20px; background: #dd0d22; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">+ Add Product</a>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #f3e3cb;">
                    <th style="text-align: left; padding: 15px; color: #666; font-size: 0.9rem;">Product Details</th>
                    <th style="text-align: left; padding: 15px; color: #666; font-size: 0.9rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                @if($product->images && $product->images->isNotEmpty())
                                    <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" alt="Product Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                                @else
                                    <div style="width: 60px; height: 60px; background: #f3e3cb; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">🛒</div>
                                @endif
                                <div>
                                    <div style="font-weight: bold; color: #333; margin-bottom: 5px;">{{ $product->name }}</div>
                                    <div style="color: #dd0d22; font-weight: bold; margin-bottom: 3px;">₱{{ number_format($product->price, 2) }}</div>
                                    <div style="color: #666; font-size: 0.85rem;">Stock: {{ $product->stock }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">
                            <!-- ✅ LENDABLE TOGGLE BUTTON WITH INLINE CSS -->
                            <form action="{{ route('products.toggle-lendable', $product->id) }}" method="POST" style="display: inline; margin-right: 5px;">
                                @csrf
                                @method('patch')
                                <button type="submit" 
                                        style="padding: 6px 12px; border-radius: 5px; border: none; cursor: pointer; font-size: 0.8rem; font-weight: bold;
                                        @if($product->is_lendable) background: #d4edda; color: #155724;
                                        @else background: #f8f9fa; color: #666; border: 1px solid #ddd;
                                        @endif">
                                    {{ $product->is_lendable ? '📚 Borrowable' : '📚 Not Borrowable' }}
                                </button>
                            </form>

                            <a href="{{ route('products.edit', $product->id) }}" 
                               style="padding: 6px 12px; background: #ffc107; color: #333; text-decoration: none; border-radius: 5px; font-size: 0.8rem; font-weight: bold; display: inline-block; margin-right: 5px;">Edit Product</a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="padding: 6px 12px; background: #dc3545; color: white; border: none; border-radius: 5px; font-size: 0.8rem; font-weight: bold; cursor: pointer;"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center; padding: 60px 20px;">
                            <div style="font-size: 3rem; margin-bottom: 15px;">📦</div>
                            <p style="color: #666; margin-bottom: 15px;">No products currently in studio</p>
                            <a href="{{ route('products.create') }}" style="padding: 10px 20px; background: #dd0d22; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">+ Add Your First Product</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- RECENT ORDERS SECTION (MOVED INSIDE THE LAYOUT) -->
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 30px;">
        <h2 style="margin: 0 0 20px 0; color: #333; font-size: 1.5rem;">📦 Recent Orders</h2>

        @forelse($orders as $order)
            <div style="
                    border-left: 4px solid #ff4a00;
                    padding: 15px;
                    margin-bottom: 15px;
                    background: #fffaf6;
                    border-radius: 8px;
                    transition: 0.2s;
                 "
                 onmouseover="this.style.transform='scale(1.01)'"
                 onmouseout="this.style.transform='scale(1)'">

                <p style="margin:4px 0;">
                    <strong>👤 Customer:</strong>
                    {{ $order->user->name ?? 'Unknown' }}
                </p>

                <p style="margin:4px 0;">
                    <strong>📦 Item:</strong>
                    {{ $order->product->name ?? 'Deleted Product' }}
                </p>

                <p style="margin:4px 0; color:#dd0d22;">
                    <strong>💰 Total:</strong>
                    ₱{{ number_format($order->total_price, 2) }}
                </p>

                <p style="margin:4px 0;">
                    <strong>Status:</strong>
                    <span style="
                    padding: 3px 10px;
                    border-radius: 12px;
                    font-size: 0.8rem;
                    font-weight: bold;
                    @if($order->status == 'completed') background: #d4edda; color: #155724;
                    @elseif($order->status == 'cancelled') background: #f8d7da; color: #721c24;
                    @else background: #fff3cd; color: #856404;
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </span>
                </p>

                <small style="color:#888;">
                    🕒 {{ $order->created_at->diffForHumans() }}
                </small>

            </div>
        @empty
            <div style="text-align:center; padding:25px;">
                <p style="color:#999; font-size:0.9rem;">
                    📭 No orders yet.<br>
                    Keep promoting your products!
                </p>
            </div>
        @endforelse

        @if($orders->count())
            <a href="{{ route('seller.orders') }}"
               style="
                    display:block;
                    text-align:center;
                    font-size:0.85rem;
                    color:#dd0d22;
                    text-decoration:none;
                    margin-top:10px;
                    font-weight:bold;
               ">
                View All Orders →
            </a>
        @endif
    </div>

</div>

<!-- MESSUI COMPONENT INSIDE THE LAYOUT -->
<x-messui/>

</x-sellerDash>