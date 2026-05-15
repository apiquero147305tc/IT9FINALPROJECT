<x-sellerDash>

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #333; margin-bottom: 10px;">📚 Lending Management</h2>
    <p style="color: #666; margin-bottom: 30px;">Manage borrowing requests for your products</p>

    @forelse($lendings as $lending)
        <div style="background: white; border-radius: 15px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="display: flex; gap: 20px; align-items: start;">

                <div style="flex-shrink: 0;">
                    @if($lending->product->images && $lending->product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $lending->product->images[0]->image_path) }}" 
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
                            <h3 style="margin: 0; color: #333;">{{ $lending->product->name }}</h3>
                            <p style="margin: 5px 0; color: #666; font-size: 0.9rem;">
                                👤 Borrower: {{ $lending->borrower->name }} ({{ $lending->borrower->email }})
                            </p>
                        </div>
                        <span style="
                            padding: 5px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: bold;
                            @if($lending->status == 'pending') background: #fff3cd; color: #856404;
                            @elseif($lending->status == 'approved') background: #d4edda; color: #155724;
                            @elseif($lending->status == 'rejected') background: #f8d7da; color: #721c24;
                            @elseif($lending->status == 'returned') background: #cce5ff; color: #004085;
                            @elseif($lending->status == 'overdue') background: #f8d7da; color: #721c24;
                            @endif
                        ">{{ ucfirst($lending->status) }}</span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin: 15px 0;">
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <span style="color: #999; font-size: 0.8rem;">Duration</span>
                            <p style="margin: 5px 0; font-weight: bold; color: #333;">{{ $lending->duration_days }} days</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <span style="color: #999; font-size: 0.8rem;">Due Date</span>
                            <p style="margin: 5px 0; font-weight: bold; color: #333;">{{ $lending->due_date->format('M d, Y') }}</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <span style="color: #999; font-size: 0.8rem;">Lending Fee</span>
                            <p style="margin: 5px 0; font-weight: bold; color: #dd0d22;">₱{{ number_format($lending->lending_fee, 2) }}</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <span style="color: #999; font-size: 0.8rem;">Collateral Value</span>
                            <p style="margin: 5px 0; font-weight: bold; color: #28a745;">₱{{ number_format($lending->collateral_value, 2) }}</p>
                        </div>
                    </div>

                    <div style="margin: 15px 0; padding: 12px; background: #e7f3ff; border-radius: 8px;">
                        <strong style="color: #004085;">🔒 Collateral:</strong>
                        <span style="color: #004085; font-size: 0.9rem;">
                            {{ ucfirst($lending->collateral_type) }} - {{ $lending->collateral_description }}
                        </span>
                    </div>

                    @if($lending->purpose)
                        <div style="margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                            <strong style="color: #666;">📝 Purpose:</strong>
                            <span style="color: #666; font-size: 0.9rem;">{{ $lending->purpose }}</span>
                        </div>
                    @endif

                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        @if($lending->status == 'pending')
                            <form action="{{ route('lending.update-status', $lending->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" 
                                        style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
                                    ✓ Approve
                                </button>
                            </form>
                            <form action="{{ route('lending.update-status', $lending->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" 
                                        style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
                                    ✕ Reject
                                </button>
                            </form>
                        @elseif($lending->status == 'approved')
                            <form action="{{ route('lending.update-status', $lending->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="returned">
                                <button type="submit" 
                                        style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
                                    ↩ Mark Returned
                                </button>
                            </form>
                            @if($lending->isOverdue())
                                <form action="{{ route('lending.update-status', $lending->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="overdue">
                                    <button type="submit" 
                                            style="padding: 10px 20px; background: #ffc107; color: #333; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
                                        ⚠ Confirm Overdue
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>

                    @if($lending->isOverdue())
                        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-top: 10px;">
                            ⚠️ <strong>Overdue!</strong> Item was due {{ $lending->due_date->diffForHumans() }}.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 60px 20px;">
            <div style="font-size: 4rem; margin-bottom: 20px;">📭</div>
            <h3 style="color: #666;">No Lending Requests</h3>
            <p style="color: #999;">No one has requested to borrow your products yet.</p>
        </div>
    @endforelse
</div>

</x-sellerDash>