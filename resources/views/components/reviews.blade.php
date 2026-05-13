<div class="reviews-section mt-5">
    <h3>Customer Reviews</h3>

    <!-- Average Rating -->
    <div class="mb-4">
        <h5>Average Rating: 
            <span class="badge badge-info">{{ number_format($product->getAverageRating(), 1) }}/5</span>
            ({{ $product->getReviewCount() }} reviews)
        </h5>
    </div>

    <!-- Add Review Form (for authenticated users) -->
    @auth
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Leave a Review</h5>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select name="rating" id="rating" class="form-control" required>
                            <option value="">Select rating...</option>
                            <option value="5">5 Stars - Excellent</option>
                            <option value="4">4 Stars - Good</option>
                            <option value="3">3 Stars - Average</option>
                            <option value="2">2 Stars - Poor</option>
                            <option value="1">1 Star - Very Poor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comment (Optional)</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>
    @endauth

    <!-- Display Reviews -->
    <div class="reviews-list">
        @forelse($product->approvedReviews()->paginate(5) as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-2">{{ $review->user->name }}</h6>
                            <span class="badge badge-warning">{{ str_repeat('★', $review->rating) }}</span>
                        </div>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="card-text mt-2">{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <p>No reviews yet. Be the first to review!</p>
        @endforelse
    </div>
</div>
