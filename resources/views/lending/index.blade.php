<x-buyerDash>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #333; margin-bottom: 10px;">📚 Product Lending Hub</h2>
    <p style="color: #666; margin-bottom: 30px;">Browse items available for short-term borrowing</p>

    <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">

        @forelse($products as $product)
            <div class="card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.2s;">

                <div style="height: 180px; overflow: hidden;">
                    @if($product->images && $product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images[0]->image_path) }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: #f3e3cb; display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                            📦
                        </div>
                    @endif
                </div>

                <div style="padding: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                        <h3 style="margin: 0; font-size: 1rem; color: #333;">{{ $product->name }}</h3>
                        <span style="background: #d4edda; color: #155724; padding: 3px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: bold;">
                            ✓ Lendable
                        </span>
                    </div>

                    <p style="color: #666; font-size: 0.85rem; margin: 5px 0;">
                        🏪 {{ $product->user->shop_name ?? $product->user->name }}
                    </p>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                        <div>
                            <span style="color: #dd0d22; font-weight: bold; font-size: 1.1rem;">
                                ₱{{ number_format($product->price, 2) }}
                            </span>
                            <span style="color: #999; font-size: 0.8rem;">value</span>
                        </div>
                        <span style="color: #28a745; font-size: 0.85rem;">
                            Stock: {{ $product->stock }}
                        </span>
                    </div>

                    <div style="background: #fff3cd; padding: 8px; border-radius: 8px; margin-top: 10px;">
                        <span style="color: #856404; font-size: 0.8rem;">
                            💰 Est. fee: ₱{{ number_format($product->price * 0.10, 2) }}/week
                        </span>
                    </div>

                    <a href="{{ route('lending.create', $product->id) }}" 
                       style="display: block; text-align: center; margin-top: 12px; padding: 10px; background: #dd0d22; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 0.9rem;">
                        📋 Request to Borrow
                    </a>
                </div>
            </div>

        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                <div style="font-size: 4rem; margin-bottom: 20px;">📭</div>
                <h3 style="color: #666;">No Lendable Products</h3>
                <p style="color: #999;">No products are currently available for lending.</p>
            </div>
        @endforelse
    </div>
</div>

</x-buyerDash>