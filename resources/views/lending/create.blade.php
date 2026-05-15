<x-buyerDash>

<div style="max-width: 600px; margin: 40px auto; padding: 0 20px;">
    <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">

        <div style="border-bottom: 2px solid #f3e3cb; padding-bottom: 20px; margin-bottom: 25px;">
            <h2 style="color: #333; margin: 0;">📋 Borrow Request</h2>
            <p style="color: #666; margin: 5px 0 0 0;">{{ $product->name }}</p>
        </div>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 25px; display: flex; gap: 15px; align-items: center;">
            @if($product->images && $product->images->isNotEmpty())
                <img src="{{ asset('storage/' . $product->images[0]->image_path) }}" 
                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
            @else
                <div style="width: 80px; height: 80px; background: #f3e3cb; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    📦
                </div>
            @endif
            <div>
                <h4 style="margin: 0; color: #333;">{{ $product->name }}</h4>
                <p style="margin: 5px 0; color: #666; font-size: 0.9rem;">
                    🏪 {{ $product->user->shop_name ?? $product->user->name }}
                </p>
                <p style="margin: 0; color: #dd0d22; font-weight: bold;">
                    ₱{{ number_format($product->price, 2) }}
                </p>
            </div>
        </div>

        <form action="{{ route('lending.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px;">
                    ⏱️ Borrowing Duration (Days)
                </label>
                <input type="number" name="duration_days" min="1" max="30" value="7" required
                       style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem;">
                <span style="color: #999; font-size: 0.85rem;">Maximum 30 days</span>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px;">
                    📝 Purpose (Optional)
                </label>
                <textarea name="purpose" rows="3" placeholder="Why do you need this item?"
                          style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
            </div>

            <div style="background: #fff3cd; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                <h4 style="margin-top: 0; color: #856404;">🔒 Collateral Required</h4>
                <p style="color: #856404; font-size: 0.9rem; margin-bottom: 15px;">
                    The seller requires collateral to ensure safe return of the item.
                </p>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px;">
                        Collateral Type *
                    </label>
                    <select name="collateral_type" required
                            style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem;">
                        <option value="">Select type...</option>
                        <option value="cash">💵 Cash Deposit</option>
                        <option value="item">📱 Valuable Item</option>
                        <option value="id">🪪 Valid ID</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px;">
                        Collateral Description *
                    </label>
                    <textarea name="collateral_description" rows="2" required
                              placeholder="e.g., Cash ₱500, Samsung Galaxy phone, Driver's License..."
                              style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; color: #333; margin-bottom: 8px;">
                        Estimated Collateral Value (₱) *
                    </label>
                    <input type="number" name="collateral_value" min="0" step="0.01" required
                           placeholder="0.00"
                           style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem;">
                    <span style="color: #856404; font-size: 0.85rem;">
                        Should be equal or greater than item value (₱{{ number_format($product->price, 2) }})
                    </span>
                </div>
            </div>

            <div style="background: #d4edda; padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #155724; font-weight: bold;">Estimated Lending Fee:</span>
                    <span style="color: #155724; font-size: 1.2rem; font-weight: bold;">
                        ₱{{ number_format($product->price * 0.10, 2) }}/week
                    </span>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" 
                        style="flex: 1; padding: 14px; background: #dd0d22; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 1rem;">
                    📤 Submit Request
                </button>
                <a href="{{ route('lending.index') }}" 
                   style="padding: 14px 25px; background: #f3e3cb; color: #dd0d22; text-decoration: none; border-radius: 8px; font-weight: bold;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

</x-buyerDash>