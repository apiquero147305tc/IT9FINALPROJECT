@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div style="max-width: 1100px; margin: auto; padding: 20px;">
    <h2 style="color: var(--crave-red); margin-bottom: 25px;">Seller Studio <span style="font-size: 0.9rem; color: #666; font-weight: normal;">| Merchant Command Center</span></h2>

    <div class="stats-container" style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div class="stat-box" style="flex: 1; background: white; padding: 20px; border-radius: 12px; border-left: 5px solid var(--crave-red); box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <h4 style="margin: 0; color: #555;">Total Revenue</h4>
            <p style="font-size: 1.8rem; font-weight: bold; color: var(--crave-red); margin: 10px 0;">₱0.00</p>
        </div>
        
        <div class="stat-box" style="flex: 1; background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #3498db; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h4 style="margin: 0; color: #555;">Items Lent</h4>
                    <p style="font-size: 1.8rem; font-weight: bold; color: #3498db; margin: 10px 0;">0</p>
                </div>
                <i class="fas fa-hand-holding-heart" style="font-size: 1.5rem; color: #3498db; opacity: 0.5;"></i>
            </div>
        </div>

        <div class="stat-box" style="flex: 1; background: white; padding: 20px; border-radius: 12px; border-left: 5px solid var(--crave-orange); box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <h4 style="margin: 0; color: #555;">Active Listings</h4>
            <p style="font-size: 1.8rem; font-weight: bold; color: var(--crave-orange); margin: 10px 0;">{{ $myProducts->count() }}</p>
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 15px; margin-bottom: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid var(--crave-pink);">
        <h3 style="margin-top: 0; color: var(--crave-red); border-bottom: 2px solid var(--crave-cream); padding-bottom: 10px;">List a New Product</h3>
        
        <form action="{{ route('seller.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
                <div class="form-group">
                    <label style="font-weight: bold; color: #444;">Product Name</label>
                    <input type="text" name="name" placeholder="e.g. School Supplies" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-weight: bold; color: #444;">Price (₱)</label>
                    <input type="number" step="0.01" name="price" placeholder="0.00" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 8px;">
                </div>
                <div class="form-group">
                    <label style="font-weight: bold; color: #444;">Category</label>
                    <select name="category" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 8px;">
                        <option value="General">General</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Food">Food</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="font-weight: bold; color: #444;">Image URL</label>
                    <input type="text" name="image" placeholder="Paste image link" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 8px;">
                </div>
            </div>
            <button type="submit" class="btn-action" style="margin-top: 25px; width: 220px; padding: 15px;">🚀 Post Product</button>
        </form>
    </div>

    <h3 style="color: var(--crave-orange); margin-bottom: 15px;">My Inventory</h3>
    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <table class="inventory-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--crave-orange); color: white;">
                    <th style="padding: 15px; text-align: left;">Image</th>
                    <th style="padding: 15px; text-align: left;">Product</th>
                    <th style="padding: 15px; text-align: left;">Price</th>
                    <th style="padding: 15px; text-align: left;">Category</th>
                    <th style="padding: 15px; text-align: left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myProducts as $item)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;"><img src="{{ $item->image ?? 'https://via.placeholder.com/50' }}" width="50" height="50" style="border-radius: 8px; object-fit: cover;"></td>
                    <td style="padding: 15px; font-weight: bold;">{{ $item->name }}</td>
                    <td style="padding: 15px; color: var(--crave-red); font-weight: bold;">₱{{ number_format($item->price, 2) }}</td>
                    <td style="padding: 15px;"><span style="background: var(--crave-cream); padding: 5px 10px; border-radius: 20px; font-size: 0.8rem;">{{ $item->category }}</span></td>
                    <td style="padding: 15px;">
                        @if($item->is_lent ?? false)
                            <span style="color: #3498db; font-weight: bold;"><i class="fas fa-clock"></i> Lent Out</span>
                        @else
                            <span style="color: green; font-weight: bold;"><i class="fas fa-check-circle"></i> Available</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($myProducts->isEmpty())
        <div style="text-align: center; padding: 60px; background: white; border-radius: 15px; margin-top: 20px; border: 2px dashed var(--crave-pink);">
            <p style="color: #888; font-size: 1.1rem;">Your inventory is empty. Use the form above to add your first product!</p>
        </div>
    @endif
</div>
@endsection