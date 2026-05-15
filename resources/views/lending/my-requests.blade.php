<x-buyerDash>

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #333; margin-bottom: 10px;">📋 My Borrowing Requests</h2>
    <p style="color: #666; margin-bottom: 30px;">Track your lending requests and active borrowings</p>

    @forelse($requests as $request)
        <div style="background: white; border-radius: 15px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="display: flex; gap: 20px; align-items: start;">

                <div style="flex-shrink: 0;">
                    @if($request->product->images && $request->product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $request->product->images[0]->image_path) }}" 
                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                    @else
                        <div style="width: 100px; height: 100px; background: #f3e3cb; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            📦
                        </div>
                    @endif
                </div>

                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <div>
                            <h3 style="margin: 0; color: #333;">{{ $request->product->name }}</h3>
                            <p style="margin: 5px 0; color: #666; font-size: 0.9rem;">
                                🏪 {{ $request->lender->shop_name ?? $request->lender->name }}
                            </p>
                        </div>
                        <span style="
                            padding: 5px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: bold;
                            @if($request->status == 'pending') background: #fff3cd; color: #856404;
                            @elseif($request->status == 'approved') background: #d4edda; color: #155724;
                            @elseif($request->status == 'rejected') background: #f8d7da; color: #721c24;
                            @elseif($request->status == 'returned') background: #cce5ff; color: #004085;
                            @elseif($request->status == 'overdue') background: #f8d7da; color: #721c24;
                            @endif
                        ">{{ ucfirst($request->status) }}</span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin: 15px 0;">
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <span style="color: #999; font-size: 0.8rem;">Duration</span>
                            <p style="margin: 5px 0; font-weight: bold; color: #333;">{{ $request->duration_days }} days</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <span style="color: #999; font-size: 0.8rem;">Due Date</span>
                            <p style="margin: 5px 0; font-weight: bold; color: #333;">{{ $request->due_date->format('M d, Y') }}</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <span style="color: #999; font-size: 0.8rem;">Lending Fee</span>
                            <p style="margin: 5px 0; font-weight: bold; color: #dd0d22;">₱{{ number_format($request->lending_fee, 2) }}</p>
                        </div>
                    </div>

                    @if($request->isOverdue())
                        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-top: 10px;">
                            ⚠️ <strong>Overdue!</strong> This item was due {{ $request->due_date->diffForHumans() }}. Please return it immediately.
                        </div>
                    @elseif($request->status == 'approved' && $request->daysRemaining() <= 2)
                        <div style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 8px; margin-top: 10px;">
                            ⏰ <strong>Due soon!</strong> {{ $request->daysRemaining() }} day(s) remaining.
                        </div>
                    @endif

                    <div style="margin-top: 15px; padding: 10px; background: #e7f3ff; border-radius: 8px;">
                        <span style="color: #004085; font-size: 0.85rem;">
                            🔒 Collateral: {{ ucfirst($request->collateral_type) }} - {{ $request->collateral_description }} (₱{{ number_format($request->collateral_value, 2) }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 60px 20px;">
            <div style="font-size: 4rem; margin-bottom: 20px;">📭</div>
            <h3 style="color: #666;">No Requests Yet</h3>
            <p style="color: #999;">You haven't made any borrowing requests yet.</p>
            <a href="{{ route('lending.index') }}" 
               style="display: inline-block; margin-top: 15px; padding: 12px 25px; background: #dd0d22; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">
                Browse Lendable Products
            </a>
        </div>
    @endforelse
</div>

</x-buyerDash>