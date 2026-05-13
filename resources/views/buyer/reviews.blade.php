{{-- resources/views/buyer/reviews.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reviews – {{ $product->name }} | CraveCart</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --orange: #EE4D2D;
    --orange-light: #fff3f0;
    --gray-bg: #f5f5f5;
    --gray-border: #e8e8e8;
    --gray-text: #999;
    --dark: #222;
    --white: #fff;
    --star: #FFD700;
  }

  body { font-family: 'Nunito', sans-serif; background: var(--gray-bg); min-height: 100vh; }

  /* ─── TOP BAR ─── */
  .top-bar {
    background: var(--orange);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(238,77,45,0.3);
  }
  .back-btn {
    background: none; border: none; color: white;
    font-size: 20px; cursor: pointer; line-height: 1;
    text-decoration: none;
  }
  .top-bar-title { color: white; font-size: 16px; font-weight: 800; }

  /* ─── FLASH MESSAGES ─── */
  .flash {
    padding: 12px 16px; font-size: 13px; font-weight: 700;
    display: flex; align-items: center; gap: 8px;
  }
  .flash.success { background: #e6f9f0; color: #1a7a4a; }
  .flash.error   { background: #fde8e8; color: #c0392b; }

  /* ─── RATING HEADER ─── */
  .rating-header {
    background: white; padding: 16px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--gray-border);
  }
  .rating-summary { display: flex; align-items: center; gap: 8px; }
  .big-score { font-size: 32px; font-weight: 800; color: var(--dark); line-height: 1; }
  .header-star { font-size: 22px; color: var(--star); }
  .rating-label-text { font-size: 15px; font-weight: 700; color: var(--dark); }
  .rating-count { font-size: 14px; color: var(--gray-text); font-weight: 600; }

  /* ─── SEARCH ─── */
  .search-reviews { background: white; padding: 10px 16px 14px; border-bottom: 8px solid var(--gray-bg); }
  .review-search-form { display: flex; align-items: center; gap: 8px;
    border: 1.5px solid var(--gray-border); border-radius: 20px; padding: 9px 14px; background: #fafafa; }
  .review-search-form svg { width: 16px; height: 16px; fill: none; stroke: #bbb; stroke-width: 2.5; flex-shrink: 0; }
  .review-search-form input { flex: 1; border: none; background: none; outline: none;
    font-family: 'Nunito', sans-serif; font-size: 13.5px; color: var(--dark); }
  .review-search-form input::placeholder { color: #bbb; }
  .review-search-form button { background: none; border: none; cursor: pointer; color: var(--orange); font-weight: 800; font-size: 13px; }

  /* ─── FILTER CHIPS ─── */
  .filter-chips {
    background: white; padding: 10px 16px;
    display: flex; gap: 8px; overflow-x: auto;
    border-bottom: 8px solid var(--gray-bg); scrollbar-width: none;
  }
  .filter-chips::-webkit-scrollbar { display: none; }
  .r-chip {
    flex-shrink: 0; padding: 6px 14px;
    border: 1.5px solid var(--gray-border); border-radius: 20px;
    font-size: 12.5px; font-weight: 700; color: #666; background: white;
    text-decoration: none; display: flex; align-items: center; gap: 4px; transition: all 0.15s;
  }
  .r-chip .s { color: var(--star); font-size: 13px; }
  .r-chip.active { border-color: var(--orange); background: var(--orange-light); color: var(--orange); }
  .r-chip:hover { border-color: var(--orange); color: var(--orange); }

  /* ─── REVIEWS LIST ─── */
  .reviews-list { display: flex; flex-direction: column; gap: 2px; }

  .review-card { background: white; padding: 16px; border-bottom: 1px solid var(--gray-border); }
  .review-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
  .reviewer { display: flex; align-items: center; gap: 10px; }
  .avatar {
    width: 36px; height: 36px; border-radius: 50%; background: #e0e0e0;
    display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
  }
  .reviewer-name { font-size: 14px; font-weight: 700; color: var(--dark); }

  /* helpful form button */
  .helpful-form { display: inline; }
  .helpful-btn {
    display: flex; align-items: center; gap: 5px;
    font-size: 13px; color: var(--gray-text); font-weight: 600;
    background: none; border: none; cursor: pointer; font-family: 'Nunito', sans-serif;
  }
  .helpful-btn:hover { color: var(--orange); }
  .helpful-btn svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; }

  .review-stars { display: flex; gap: 2px; margin-bottom: 4px; }
  .review-stars .star { font-size: 15px; color: var(--star); }
  .review-stars .star.empty { color: #ddd; }

  .review-variation { font-size: 12px; color: var(--gray-text); font-weight: 600; margin-bottom: 8px; }
  .review-text { font-size: 14px; color: #444; line-height: 1.6; margin-bottom: 8px; }
  .review-date { font-size: 11.5px; color: #bbb; font-weight: 600; }

  .empty-state { text-align: center; padding: 40px 16px; color: #bbb; font-size: 14px; font-weight: 700; background: white; }

  /* ─── WRITE REVIEW SECTION ─── */
  .write-review-section {
    background: white; padding: 20px 16px; margin-top: 8px;
    border-top: 4px solid var(--orange-light);
  }
  .write-review-section h3 { font-size: 16px; font-weight: 800; color: var(--dark); margin-bottom: 14px; }

  .star-picker-input { display: flex; gap: 6px; margin-bottom: 8px; }
  .star-opt { display: none; }
  .star-lbl {
    font-size: 32px; cursor: pointer; color: #ddd;
    transition: color 0.15s, transform 0.1s; user-select: none;
  }
  /* highlight selected and all before it */
  #star1:checked ~ .star-picker-input label[for="star1"],
  #star2:checked ~ .star-picker-input label[for="star1"],
  #star2:checked ~ .star-picker-input label[for="star2"],
  #star3:checked ~ .star-picker-input label[for="star1"],
  #star3:checked ~ .star-picker-input label[for="star2"],
  #star3:checked ~ .star-picker-input label[for="star3"],
  #star4:checked ~ .star-picker-input label[for="star1"],
  #star4:checked ~ .star-picker-input label[for="star2"],
  #star4:checked ~ .star-picker-input label[for="star3"],
  #star4:checked ~ .star-picker-input label[for="star4"],
  #star5:checked ~ .star-picker-input label[for="star1"],
  #star5:checked ~ .star-picker-input label[for="star2"],
  #star5:checked ~ .star-picker-input label[for="star3"],
  #star5:checked ~ .star-picker-input label[for="star4"],
  #star5:checked ~ .star-picker-input label[for="star5"] { color: var(--star); }

  .review-form-textarea {
    width: 100%; padding: 12px; border: 1.5px solid var(--gray-border); border-radius: 8px;
    font-family: 'Nunito', sans-serif; font-size: 14px; resize: none; outline: none;
    color: var(--dark); margin-bottom: 12px; transition: border-color 0.15s;
  }
  .review-form-textarea:focus { border-color: var(--orange); }

  .submit-btn {
    width: 100%; background: var(--orange); color: white; border: none;
    border-radius: 8px; padding: 13px; font-family: 'Nunito', sans-serif;
    font-size: 15px; font-weight: 800; cursor: pointer; transition: background 0.15s;
  }
  .submit-btn:hover { background: #d43d1f; }

  /* ─── OTHER REVIEWS ROW ─── */
  .other-reviews-row {
    background: white; padding: 16px; margin-top: 8px;
    display: flex; align-items: center; justify-content: space-between; cursor: pointer;
  }
  .other-reviews-row span { font-size: 15px; font-weight: 800; color: var(--dark); }
  .other-reviews-row svg { width: 18px; height: 18px; fill: none; stroke: #bbb; stroke-width: 2.5; }
</style>
</head>
<body>

{{-- TOP BAR --}}
<div class="top-bar">
  <a href="{{ url()->previous() }}" class="back-btn">&#8592;</a>
  <span class="top-bar-title">{{ $product->name }}</span>
</div>

{{-- FLASH MESSAGES --}}
@if(session('success'))
  <div class="flash success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="flash error">⚠️ {{ session('error') }}</div>
@endif

{{-- RATING HEADER --}}
<div class="rating-header">
  <div class="rating-summary">
    <span class="big-score">{{ number_format($avgRating, 1) }}</span>
    <span class="header-star">★</span>
    <div>
      <div class="rating-label-text">Product Ratings</div>
      <div class="rating-count">({{ $totalCount }}) reviews</div>
    </div>
  </div>
</div>

{{-- SEARCH REVIEWS --}}
<div class="search-reviews">
  <form method="GET" action="{{ route('reviews.index', $product) }}" class="review-search-form">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="22" y2="22"/></svg>
    <input type="text" name="search" placeholder="Search What Others Said"
           value="{{ request('search') }}">
    {{-- keep active star filter --}}
    @if(request('stars'))
      <input type="hidden" name="stars" value="{{ request('stars') }}">
    @endif
    <button type="submit">Go</button>
  </form>
</div>

{{-- FILTER CHIPS --}}
<div class="filter-chips">
  @php
    $activeStars = request('stars', 'all');
    $baseParams  = request('search') ? ['search' => request('search')] : [];
  @endphp

  <a href="{{ route('reviews.index', array_merge([$product], $baseParams)) }}"
     class="r-chip {{ $activeStars === 'all' ? 'active' : '' }}">All</a>

  @foreach([5,4,3,2,1] as $s)
    <a href="{{ route('reviews.index', array_merge([$product], $baseParams, ['stars' => $s])) }}"
       class="r-chip {{ $activeStars == $s ? 'active' : '' }}">
      <span class="s">★</span> {{ $s }}
    </a>
  @endforeach
</div>

{{-- REVIEWS LIST --}}
<div class="reviews-list">
  @forelse($reviews as $review)
    <div class="review-card">
      <div class="review-top">
        <div class="reviewer">
          <div class="avatar">👤</div>
          <div class="reviewer-name">{{ $review->masked_name }}</div>
        </div>

        {{-- Helpful button --}}
        <form action="{{ route('reviews.helpful', $review) }}" method="POST" class="helpful-form">
          @csrf
          <button type="submit" class="helpful-btn">
            Helpful ({{ $review->helpful }})
            <svg viewBox="0 0 24 24">
              <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14z"/>
              <path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/>
            </svg>
          </button>
        </form>
      </div>

      {{-- Stars --}}
      <div class="review-stars">
        @for($i = 1; $i <= 5; $i++)
          <span class="star {{ $i > $review->stars ? 'empty' : '' }}">★</span>
        @endfor
      </div>

      <div class="review-variation">Product: {{ $product->name }}</div>
      <div class="review-text">{{ $review->body }}</div>
      <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
    </div>
  @empty
    <div class="empty-state">No reviews yet. Be the first! 🍽️</div>
  @endforelse
</div>

{{-- WRITE A REVIEW --}}
@auth
<div class="write-review-section">
  <h3>✍️ Write a Review</h3>
  <form action="{{ route('reviews.store', $product) }}" method="POST">
    @csrf

    {{-- Star picker using CSS radio trick --}}
    <input type="radio" name="stars" id="star1" value="1" class="star-opt" required>
    <input type="radio" name="stars" id="star2" value="2" class="star-opt">
    <input type="radio" name="stars" id="star3" value="3" class="star-opt">
    <input type="radio" name="stars" id="star4" value="4" class="star-opt">
    <input type="radio" name="stars" id="star5" value="5" class="star-opt">

    <div class="star-picker-input">
      <label for="star1" class="star-lbl" title="Poor">★</label>
      <label for="star2" class="star-lbl" title="Fair">★</label>
      <label for="star3" class="star-lbl" title="Good">★</label>
      <label for="star4" class="star-lbl" title="Very Good">★</label>
      <label for="star5" class="star-lbl" title="Excellent">★</label>
    </div>

    @error('stars')
      <p style="color:#c0392b;font-size:12px;margin-bottom:8px;">{{ $message }}</p>
    @enderror

    <textarea name="body" class="review-form-textarea" rows="4"
              placeholder="Share your experience with this product..."
              required>{{ old('body') }}</textarea>

    @error('body')
      <p style="color:#c0392b;font-size:12px;margin-bottom:8px;">{{ $message }}</p>
    @enderror

    <button type="submit" class="submit-btn">Submit Review</button>
  </form>
</div>
@else
<div class="write-review-section" style="text-align:center;">
  <p style="font-size:14px;color:#666;font-weight:600;">
    <a href="{{ route('login') }}" style="color:var(--orange);font-weight:800;">Log in</a>
    to write a review.
  </p>
</div>
@endauth

{{-- OTHER REVIEWS ROW --}}
<div class="other-reviews-row">
  <span>Other Product Reviews in Shop</span>
  <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
</div>

</body>
</html>