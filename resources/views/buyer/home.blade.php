<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CraveCart – Shop</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --orange: #EE4D2D;
    --orange-light: #fff3f0;
    --orange-mid: #ffd5cc;
    --gray-bg: #f5f5f5;
    --gray-border: #e0e0e0;
    --gray-text: #888;
    --dark: #222;
    --white: #fff;
    --radius: 8px;
  }

  body { font-family: 'Nunito', sans-serif; background: var(--gray-bg); min-height: 100vh; padding-bottom: 80px; }

  .top-bar {
    background: var(--orange);
    padding: 10px 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(238,77,45,0.3);
  }

  .search-form {
    flex: 1;
    display: flex;
    align-items: center;
    background: white;
    border-radius: 4px;
    overflow: hidden;
    height: 40px;
  }

  .search-form input {
    flex: 1;
    border: none;
    outline: none;
    padding: 0 12px;
    font-family: 'Nunito', sans-serif;
    font-size: 14px;
    color: var(--dark);
    height: 100%;
  }
  .search-form input::placeholder { color: #bbb; }

  .search-submit-btn {
    background: var(--orange);
    border: none;
    height: 100%;
    width: 44px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.15s;
  }
  .search-submit-btn:hover { background: #d43d1f; }
  .search-submit-btn svg { width: 18px; height: 18px; fill: none; stroke: white; stroke-width: 2.5; }

  .filter-toggle {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    font-family: 'Nunito', sans-serif;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
    padding: 4px 0;
    white-space: nowrap;
  }
  .filter-toggle svg { width: 18px; height: 18px; fill: none; stroke: white; stroke-width: 2.5; }

  .filter-overlay {
    position: fixed;
    inset: 0;
    z-index: 200;
    display: flex;
    pointer-events: none;
  }
  .filter-backdrop {
    flex: 0 0 75px;
    background: rgba(0,0,0,0.45);
    opacity: 0;
    transition: opacity 0.25s;
    pointer-events: none;
  }
  .filter-panel {
    flex: 1;
    background: white;
    transform: translateX(100%);
    transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
    display: flex;
    flex-direction: column;
    max-height: 100vh;
    pointer-events: none;
  }
  .filter-overlay.open { pointer-events: all; }
  .filter-overlay.open .filter-backdrop { opacity: 1; pointer-events: all; }
  .filter-overlay.open .filter-panel { transform: translateX(0); pointer-events: all; }

  .filter-layout { display: flex; flex: 1; overflow: hidden; }

  .filter-sidebar {
    width: 100px;
    background: #fafafa;
    border-right: 1px solid var(--gray-border);
    overflow-y: auto;
    flex-shrink: 0;
  }
  .sidebar-item {
    padding: 16px 10px;
    font-size: 12.5px;
    color: var(--gray-text);
    cursor: pointer;
    border-left: 3px solid transparent;
    font-weight: 600;
    line-height: 1.3;
    transition: all 0.15s;
  }
  .sidebar-item.active { color: var(--orange); border-left-color: var(--orange); background: var(--orange-light); }
  .sidebar-item:hover:not(.active) { background: #f0f0f0; }

  .filter-content { flex: 1; overflow-y: auto; padding: 16px; }
  .filter-section { display: none; }
  .filter-section.active { display: block; }
  .filter-section h3 { font-size: 15px; font-weight: 800; color: var(--dark); margin-bottom: 12px; }

  .chip-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px; }
  .chip {
    padding: 9px 8px;
    border: 1.5px solid var(--gray-border);
    border-radius: var(--radius);
    font-size: 12.5px;
    font-family: 'Nunito', sans-serif;
    font-weight: 600;
    color: var(--dark);
    background: white;
    cursor: pointer;
    text-align: center;
    transition: all 0.15s;
    line-height: 1.3;
  }
  .chip:hover { border-color: var(--orange); color: var(--orange); }
  .chip.selected { border-color: var(--orange); background: var(--orange-light); color: var(--orange); }

  .show-more-btn {
    display: flex; align-items: center; justify-content: center; gap: 4px;
    font-size: 13px; color: var(--gray-text); cursor: pointer; padding: 6px 0 12px;
    font-weight: 600; background: none; border: none; width: 100%; font-family: 'Nunito', sans-serif;
  }
  .show-more-btn svg { width: 14px; height: 14px; transition: transform 0.2s; fill: none; stroke: currentColor; stroke-width: 2.5; }
  .show-more-btn.expanded svg { transform: rotate(180deg); }

  .price-inputs { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
  .price-inputs input {
    flex: 1; padding: 9px 10px; border: 1.5px solid var(--gray-border);
    border-radius: var(--radius); font-family: 'Nunito', sans-serif; font-size: 13px;
    color: var(--dark); outline: none; transition: border-color 0.15s;
  }
  .price-inputs input:focus { border-color: var(--orange); }
  .price-sep { color: var(--gray-text); font-size: 18px; flex-shrink: 0; }

  .rating-row {
    display: flex; align-items: center; gap: 8px; padding: 10px 0;
    cursor: pointer; border-bottom: 1px solid #f5f5f5;
  }
  .rating-row:last-child { border-bottom: none; }
  .stars { display: flex; gap: 2px; }
  .star { font-size: 16px; color: #FFD700; }
  .star.empty { color: #ddd; }
  .rating-label { font-size: 13px; color: var(--gray-text); font-weight: 600; }
  .rating-row.sel .rating-label { color: var(--orange); }
  .radio-dot {
    width: 18px; height: 18px; border: 2px solid var(--gray-border); border-radius: 50%;
    margin-left: auto; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    transition: border-color 0.15s;
  }
  .radio-dot::after { content: ''; width: 9px; height: 9px; border-radius: 50%; background: var(--orange); opacity: 0; transition: opacity 0.15s; }
  .rating-row.sel .radio-dot { border-color: var(--orange); }
  .rating-row.sel .radio-dot::after { opacity: 1; }

  .filter-footer { display: flex; border-top: 1px solid var(--gray-border); background: white; }
  .btn-reset {
    flex: 1; padding: 16px; background: white; border: none; color: var(--orange);
    font-family: 'Nunito', sans-serif; font-size: 15px; font-weight: 800; cursor: pointer;
  }
  .btn-reset:hover { background: var(--orange-light); }
  .btn-apply {
    flex: 2; padding: 16px; background: var(--orange); border: none; color: white;
    font-family: 'Nunito', sans-serif; font-size: 15px; font-weight: 800; cursor: pointer;
  }
  .btn-apply:hover { background: #d43d1f; }

  .active-filters-bar {
    display: flex; gap: 6px; flex-wrap: wrap;
    padding: 10px 12px 0;
  }
  .filter-tag {
    display: flex; align-items: center; gap: 4px;
    background: var(--orange-light); border: 1.5px solid var(--orange-mid);
    color: var(--orange); border-radius: 20px; padding: 3px 10px;
    font-size: 12px; font-weight: 700; text-decoration: none;
  }
  .filter-tag span { font-size: 15px; line-height: 1; }

  .results-bar {
    padding: 10px 12px 6px;
    font-size: 13px; color: var(--gray-text); font-weight: 600;
  }
  .results-bar b { color: var(--orange); }

  .product-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    padding: 6px 12px 12px;
  }

  .product-card {
    background: white;
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    text-decoration: none;
    display: block;
    transition: transform 0.15s, box-shadow 0.15s;
  }
  .product-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.12); }

  .product-img {
    width: 100%; aspect-ratio: 1; object-fit: cover;
    background: #f0f0f0; display: block;
  }
  .product-img-placeholder {
    width: 100%; aspect-ratio: 1; background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
    display: flex; align-items: center; justify-content: center; font-size: 40px;
  }

  .product-info { padding: 8px; }
  .product-name {
    font-size: 13px; font-weight: 700; color: var(--dark);
    margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .product-price { color: var(--orange); font-size: 15px; font-weight: 800; }
  .product-cat { font-size: 11px; color: var(--gray-text); font-weight: 600; margin-top: 2px; }

  .view-reviews-link {
    display: inline-block;
    margin-top: 5px;
    font-size: 11px;
    font-weight: 700;
    color: var(--orange);
    text-decoration: none;
  }
  .view-reviews-link:hover { text-decoration: underline; }

  .add-to-cart-btn {
    display: block; width: 100%; background: var(--orange); color: white; border: none;
    padding: 7px 0; font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 800;
    cursor: pointer; text-align: center; text-decoration: none; margin-top: 6px; border-radius: 4px;
    transition: background 0.15s;
  }
  .add-to-cart-btn:hover { background: #d43d1f; }

  .empty-state {
    grid-column: 1 / -1; text-align: center; padding: 50px 20px;
    color: var(--gray-text); font-size: 14px; font-weight: 700;
  }
  .empty-state .icon { font-size: 48px; display: block; margin-bottom: 10px; }
</style>
</head>
<body>

<div class="top-bar">
  <form method="GET" action="{{ route('buyer.home') }}" class="search-form" id="searchForm">
    @if(request('category'))
      <input type="hidden" name="category" value="{{ request('category') }}">
    @endif
    @if(request('min_price'))
      <input type="hidden" name="min_price" value="{{ request('min_price') }}">
    @endif
    @if(request('max_price'))
      <input type="hidden" name="max_price" value="{{ request('max_price') }}">
    @endif
    @if(request('stars'))
      <input type="hidden" name="stars" value="{{ request('stars') }}">
    @endif

    <input
      type="text"
      name="search"
      id="searchInput"
      placeholder="Search CraveCart..."
      value="{{ $search ?? '' }}"
      autocomplete="off"
    >
    <button type="submit" class="search-submit-btn">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="22" y2="22"/></svg>
    </button>
  </form>

  <button class="filter-toggle" onclick="openFilter()">
    <svg viewBox="0 0 24 24"><line x1="4" y1="6" x2="20" y2="6"/><line x1="7" y1="12" x2="17" y2="12"/><line x1="10" y1="18" x2="14" y2="18"/></svg>
    Filter
  </button>
</div>

<div class="filter-overlay" id="filterOverlay">
  <div class="filter-backdrop" onclick="closeFilter()"></div>
  <div class="filter-panel">
    <div class="filter-layout">

      <div class="filter-sidebar">
        <div class="sidebar-item active" onclick="switchTab(this,'tab-category')">Category</div>
        <div class="sidebar-item" onclick="switchTab(this,'tab-price')">Price Range</div>
        <div class="sidebar-item" onclick="switchTab(this,'tab-rating')">Rating</div>
        <div class="sidebar-item" onclick="switchTab(this,'tab-shipping')">Shipping</div>
      </div>

      <div class="filter-content">

        <div class="filter-section active" id="tab-category">
          <h3>Category</h3>
          <div class="chip-grid" id="catGrid">
            @php
              $categories = ['Rice Meals','Burgers','Pasta','BBQ','Snacks','Drinks','Desserts','Silog'];
              $activeCategory = $category ?? 'All';
            @endphp
            <button type="button" class="chip {{ $activeCategory === 'All' ? 'selected' : '' }}"
                    onclick="selectCategory(this,'All')">All</button>
            @foreach($categories as $i => $cat)
              <button type="button"
                      class="chip extra-cat {{ $i >= 4 ? 'hidden-cat' : '' }} {{ $activeCategory === $cat ? 'selected' : '' }}"
                      onclick="selectCategory(this,'{{ $cat }}')"
                      @if($i >= 4) style="display:none" @endif>
                {{ $cat }}
              </button>
            @endforeach
          </div>
          <button type="button" class="show-more-btn" id="catMoreBtn" onclick="toggleCatMore()">
            Show More
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
        </div>

        <div class="filter-section" id="tab-price">
          <h3>Price Range</h3>
          <div class="price-inputs">
            <input type="number" id="minPrice" placeholder="Min (₱)" min="0" value="{{ request('min_price') }}">
            <span class="price-sep">–</span>
            <input type="number" id="maxPrice" placeholder="Max (₱)" min="0" value="{{ request('max_price') }}">
          </div>
          <div class="chip-grid">
            <button type="button" class="chip" onclick="setPrice(this,0,100)">Under ₱100</button>
            <button type="button" class="chip" onclick="setPrice(this,100,200)">₱100–200</button>
            <button type="button" class="chip" onclick="setPrice(this,200,500)">₱200–500</button>
            <button type="button" class="chip" onclick="setPrice(this,500,9999)">₱500+</button>
          </div>
        </div>

        <div class="filter-section" id="tab-rating">
          <h3>Rating</h3>
          @php $activeStars = request('stars'); @endphp
          @foreach([5,4,3,2,1] as $s)
            <div class="rating-row {{ $activeStars == $s ? 'sel' : '' }}" onclick="selectRating(this,{{ $s }})">
              <div class="stars">
                @for($i=1;$i<=5;$i++)
                  <span class="star {{ $i > $s ? 'empty' : '' }}">★</span>
                @endfor
              </div>
              <span class="rating-label">{{ $s }} star{{ $s < 5 ? 's & up' : '' }}</span>
              <div class="radio-dot"></div>
            </div>
          @endforeach
        </div>

        <div class="filter-section" id="tab-shipping">
          <h3>Shipping Option</h3>
          <div class="chip-grid">
            <button type="button" class="chip" onclick="toggleChip(this)">Free Shipping</button>
            <button type="button" class="chip" onclick="toggleChip(this)">Same Day</button>
            <button type="button" class="chip" onclick="toggleChip(this)">COD</button>
            <button type="button" class="chip" onclick="toggleChip(this)">Express</button>
          </div>
        </div>

      </div>
    </div>

    <div class="filter-footer">
      <button class="btn-reset" onclick="resetFilters()">Reset</button>
      <button class="btn-apply" onclick="applyFilters()">Apply</button>
    </div>
  </div>
</div>

<div class="active-filters-bar">
  @if(!empty($search))
    <a href="{{ route('buyer.home', array_diff_key(request()->query(), ['search' => ''])) }}" class="filter-tag">
      "{{ $search }}" <span>×</span>
    </a>
  @endif
  @if(!empty($category) && $category !== 'All')
    <a href="{{ route('buyer.home', array_diff_key(request()->query(), ['category' => ''])) }}" class="filter-tag">
      {{ $category }} <span>×</span>
    </a>
  @endif
  @if(request('min_price') || request('max_price'))
    <a href="{{ route('buyer.home', array_diff_key(request()->query(), ['min_price' => '', 'max_price' => ''])) }}" class="filter-tag">
      ₱{{ request('min_price',0) }}–₱{{ request('max_price','∞') }} <span>×</span>
    </a>
  @endif
  @if(request('stars'))
    <a href="{{ route('buyer.home', array_diff_key(request()->query(), ['stars' => ''])) }}" class="filter-tag">
      {{ request('stars') }}★ & up <span>×</span>
    </a>
  @endif
</div>

<div class="results-bar">
  <b>{{ $products->count() }}</b> result{{ $products->count() !== 1 ? 's' : '' }}
  @if(!empty($search)) for "<b>{{ $search }}</b>" @endif
</div>

<div class="product-grid">
  @forelse($products as $product)
    <a href="{{ route('reviews.index', $product) }}" class="product-card">
      @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
      @else
        <div class="product-img-placeholder">🍽️</div>
      @endif
      <div class="product-info">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
        <div class="product-cat">{{ $product->category }}</div>
        <a href="{{ route('reviews.index', $product) }}"
           class="view-reviews-link"
           onclick="event.stopPropagation()">
          ⭐ View Reviews ({{ $product->reviews->count() }})
        </a>
      </div>
      <form action="{{ route('cart.add') }}" method="POST" onclick="event.stopPropagation()">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
      </form>
    </a>
  @empty
    <div class="empty-state">
      <span class="icon">🔍</span>
      No products found. Try a different search or filter.
    </div>
  @endforelse
</div>

<script>
  function openFilter() {
    document.getElementById('filterOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeFilter() {
    document.getElementById('filterOverlay').classList.remove('open');
    document.body.style.overflow = '';
  }

  function switchTab(el, tabId) {
    document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.filter-section').forEach(s => s.classList.remove('active'));
    el.classList.add('active');
    document.getElementById(tabId).classList.add('active');
  }

  let selectedCategory = '{{ $category ?? 'All' }}';
  function selectCategory(el, val) {
    document.querySelectorAll('#catGrid .chip').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedCategory = val;
  }

  let catExpanded = false;
  function toggleCatMore() {
    catExpanded = !catExpanded;
    document.querySelectorAll('.hidden-cat').forEach(c => c.style.display = catExpanded ? '' : 'none');
    const btn = document.getElementById('catMoreBtn');
    btn.firstChild.textContent = catExpanded ? 'Show Less' : 'Show More';
    btn.classList.toggle('expanded', catExpanded);
  }

  function setPrice(el, min, max) {
    document.querySelectorAll('#tab-price .chip').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('minPrice').value = min > 0 ? min : '';
    document.getElementById('maxPrice').value = max < 9999 ? max : '';
  }

  let selectedRating = '{{ request('stars') ?? '' }}';
  function selectRating(el, stars) {
    document.querySelectorAll('.rating-row').forEach(r => r.classList.remove('sel'));
    if (selectedRating == stars) {
      selectedRating = '';
    } else {
      el.classList.add('sel');
      selectedRating = stars;
    }
  }

  function toggleChip(el) { el.classList.toggle('selected'); }

  function applyFilters() {
    const url = new URL(window.location.href.split('?')[0]);
    const search = document.getElementById('searchInput').value.trim();
    if (search) url.searchParams.set('search', search);
    if (selectedCategory && selectedCategory !== 'All') url.searchParams.set('category', selectedCategory);
    const min = document.getElementById('minPrice').value;
    const max = document.getElementById('maxPrice').value;
    if (min) url.searchParams.set('min_price', min);
    if (max) url.searchParams.set('max_price', max);
    if (selectedRating) url.searchParams.set('stars', selectedRating);
    window.location.href = url.toString();
  }

  function resetFilters() {
    window.location.href = window.location.href.split('?')[0];
  }

  document.querySelectorAll('#catGrid .chip').forEach(c => {
    if (c.textContent.trim() === selectedCategory) c.classList.add('selected');
  });
</script>
</body>
</html>