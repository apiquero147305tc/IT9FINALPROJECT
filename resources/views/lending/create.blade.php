<x-buyerDash>

<div style="max-width: 600px; margin: 0 auto;">

    <h1 style="color: #dd0d22; margin-bottom: 10px;">📋 Borrow Request</h1>
    <p style="color: #666; margin-bottom: 30px;">Request to borrow <strong>{{ $product->name }}</strong></p>

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); margin-bottom: 30px;">
        <h3 style="color: #1f2937; margin-top: 0;">Product Details</h3>
        @if($product->images->count() > 0)
            <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
        @endif
        <p><strong>Name:</strong> {{ $product->name }}</p>
        <p><strong>Owner:</strong> {{ $product->user->name }}</p>
        <p><strong>Available Stock:</strong> {{ $product->stock }}</p>
        <p><strong>Price:</strong> ₱{{ number_format($product->price, 2) }}</p>
    </div>

    <form action="{{ route('lending.store') }}" method="POST" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
        @csrf
        
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #4b5563;">Quantity to Borrow</label>
            <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" required 
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #4b5563;">Collateral Item (Your Product)</label>
            <select name="collateral_product_id" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px;">
                <option value="">Select your collateral item...</option>
                @foreach($myProducts as $myProduct)
                    <option value="{{ $myProduct->id }}">
                        {{ $myProduct->name }} (Stock: {{ $myProduct->stock }})
                    </option>
                @endforeach
            </select>
            <p style="font-size: 0.85rem; color: #666; margin-top: 5px;">
                ⚠️ This item will be held as collateral. If the borrowed item is damaged, your collateral may be kept as replacement.
            </p>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #4b5563;">Borrow Date</label>
            <input type="date" name="borrow_date" min="{{ date('Y-m-d') }}" required 
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #4b5563;">Return Date</label>
            <input type="date" name="return_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required 
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #4b5563;">Purpose of Borrowing</label>
            <textarea name="purpose" rows="3" required placeholder="Why do you need to borrow this item?"
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; resize: vertical;"></textarea>
        </div>

        <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <p style="margin: 0; color: #856404; font-size: 0.9rem;">
                <strong>📌 Collateral Agreement:</strong><br>
                By submitting this request, you agree that your selected collateral item will be held until the borrowed item is returned in good condition. If the borrowed item is damaged or lost, your collateral may be forfeited as replacement.
            </p>
        </div>

        <button type="submit" style="width: 100%; background: linear-gradient(to right, #dd0d22, #ff6a00); color: white; border: none; padding: 15px; border-radius: 25px; cursor: pointer; font-weight: bold; font-size: 1.1rem;">
            Submit Borrow Request
        </button>

        <a href="{{ route('lending.index') }}" style="display: block; text-align: center; margin-top: 15px; color: #dd0d22;">
            ← Cancel and Go Back
        </a>
    </form>

</div>

</x-buyerDash>