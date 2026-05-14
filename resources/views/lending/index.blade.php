@ -1,154 +0,0 @@
<x-buyerDash>

<div style="max-width: 1200px; margin: 0 auto;">

    <h1 style="color: #dd0d22; margin-bottom: 10px;">💡 Product Lending</h1>
    <p style="color: #666; margin-bottom: 30px;">Borrow products from others using your own items as collateral.</p>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('warning') }}
        </div>
    @endif

    {{-- AVAILABLE PRODUCTS TO BORROW --}}
    <section style="margin-bottom: 40px;">
        <h2 style="color: #1f2937; margin-bottom: 20px;">📦 Available to Borrow</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            @forelse($availableProducts as $product)
                <div style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                    @if($product->images->count() > 0)
                        <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                    @else
                        <img src="https://via.placeholder.com/250x150" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                    @endif
                    
                    <h3 style="margin: 10px 0 5px;">{{ $product->name }}</h3>
                    <p style="color: #666; font-size: 0.9rem;">Owner: {{ $product->user->name }}</p>
                    <p style="color: #dd0d22; font-weight: bold;">Stock: {{ $product->stock }}</p>
                    
                    <a href="{{ route('lending.create', $product->id) }}" style="display: block; text-align: center; background: linear-gradient(to right, #dd0d22, #ff6a00); color: white; padding: 10px; border-radius: 25px; text-decoration: none; margin-top: 10px;">
                        Request to Borrow
                    </a>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                    <p>No products available to borrow at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- MY ACTIVE BORROWINGS --}}
    <section style="margin-bottom: 40px;">
        <h2 style="color: #1f2937; margin-bottom: 20px;">📥 My Borrowings</h2>
        
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @forelse($myBorrowings as $borrowing)
                <div style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3>{{ $borrowing->product->name }} (x{{ $borrowing->quantity }})</h3>
                        <p style="color: #666; font-size: 0.9rem;">From: {{ $borrowing->lender->name }}</p>
                        <p style="color: #666; font-size: 0.9rem;">Borrow: {{ $borrowing->borrow_date->format('M d, Y') }} → Return: {{ $borrowing->return_date->format('M d, Y') }}</p>
                        <p style="color: #666; font-size: 0.9rem;">Collateral: {{ $borrowing->collateralProduct->name }}</p>
                        
                        @if($borrowing->status === 'pending')
                            <span style="background: #fff3cd; color: #856404; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">⏳ Pending Approval</span>
                        @elseif($borrowing->status === 'active')
                            <span style="background: #d4edda; color: #155724; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">✅ Active</span>
                        @elseif($borrowing->status === 'returned')
                            <span style="background: #cce5ff; color: #004085; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">↩️ Returned</span>
                        @elseif($borrowing->status === 'damaged')
                            <span style="background: #f8d7da; color: #721c24; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">⚠️ Damaged - Collateral Kept</span>
                        @elseif($borrowing->status === 'rejected')
                            <span style="background: #e2e3e5; color: #383d41; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">❌ Rejected</span>
                        @endif
                    </div>

                    @if($borrowing->status === 'active')
                        <form action="{{ route('lending.return', $borrowing->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                            @csrf
                            <select name="condition" required style="padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
                                <option value="">Select condition...</option>
                                <option value="good">Good Condition</option>
                                <option value="damaged">Damaged</option>
                                <option value="lost">Lost</option>
                            </select>
                            <textarea name="damage_description" placeholder="Describe any damage (optional)" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd; resize: vertical;"></textarea>
                            <button type="submit" style="background: #dd0d22; color: white; border: none; padding: 10px 20px; border-radius: 25px; cursor: pointer;">
                                Return Item
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p style="text-align: center; color: #666;">You haven't borrowed any products yet.</p>
            @endforelse
        </div>
    </section>

    {{-- MY LENDINGS (ITEMS I OWN THAT OTHERS BORROWED) --}}
    <section style="margin-bottom: 40px;">
        <h2 style="color: #1f2937; margin-bottom: 20px;">📤 My Lendings</h2>
        
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @forelse($myLendings as $lending)
                <div style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3>{{ $lending->product->name }} (x{{ $lending->quantity }})</h3>
                        <p style="color: #666; font-size: 0.9rem;">Borrower: {{ $lending->borrower->name }}</p>
                        <p style="color: #666; font-size: 0.9rem;">Borrow: {{ $lending->borrow_date->format('M d, Y') }} → Return: {{ $lending->return_date->format('M d, Y') }}</p>
                        <p style="color: #666; font-size: 0.9rem;">Collateral: {{ $lending->collateralProduct->name }}</p>
                        
                        @if($lending->status === 'pending')
                            <span style="background: #fff3cd; color: #856404; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">⏳ Pending Your Approval</span>
                        @elseif($lending->status === 'active')
                            <span style="background: #d4edda; color: #155724; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">✅ Active</span>
                        @elseif($lending->status === 'returned')
                            <span style="background: #cce5ff; color: #004085; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">↩️ Returned</span>
                        @elseif($lending->status === 'damaged')
                            <span style="background: #f8d7da; color: #721c24; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">⚠️ Damaged - Collateral Kept</span>
                        @elseif($lending->status === 'rejected')
                            <span style="background: #e2e3e5; color: #383d41; padding: 3px 10px; border-radius: 15px; font-size: 0.8rem;">❌ Rejected</span>
                        @endif
                    </div>

                    @if($lending->status === 'pending')
                        <div style="display: flex; gap: 10px;">
                            <form action="{{ route('lending.approve', $lending->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 25px; cursor: pointer;">
                                    ✅ Approve
                                </button>
                            </form>
                            <form action="{{ route('lending.reject', $lending->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 25px; cursor: pointer;">
                                    ❌ Reject
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p style="text-align: center; color: #666;">No one has borrowed your products yet.</p>
            @endforelse
        </div>
    </section>

</div>

</x-buyerDash>