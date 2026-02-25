@extends('layouts.app')
@section('title', 'Our Collection — AUSHVERA')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@300;400;500&family=Playfair+Display:ital,wght@0,300;0,400;1,300;1,400&family=EB+Garamond:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

<style>
/* ─── CSS Variables matching brand ─── */
:root {
    --gold:     #B8964C;
    --gold-lt:  #D4AF6F;
    --cream:    #F7F4EE;
    --dark:     #1a1a1a;
    --mid:      #5a5244;
    --border:   #E0D9CC;
}

/* ─── Page wrapper ─── */
.collection-page {
    background: var(--cream);
    min-height: 80vh;
}

/* ─── Hero banner ─── */
.collection-hero {
    position: relative;
    background: var(--dark);
    overflow: hidden;
    padding: 100px 24px 80px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

.collection-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 20% 50%, rgba(184,150,76,0.12) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 50%, rgba(184,150,76,0.08) 0%, transparent 60%);
    pointer-events: none;
}

.collection-hero-eyebrow {
    font-family: 'Cinzel', serif;
    font-size: 0.7rem;
    letter-spacing: 0.35em;
    text-transform: uppercase;
    color: var(--gold);
    opacity: 0.9;
}

.collection-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 6vw, 4rem);
    font-weight: 300;
    color: #F7F4EE;
    letter-spacing: 0.04em;
    line-height: 1.2;
    margin: 0;
}

.collection-hero h1 em {
    color: var(--gold);
    font-style: italic;
}

.collection-hero-sub {
    font-family: 'EB Garamond', serif;
    font-size: 1.05rem;
    font-weight: 300;
    color: rgba(247,244,238,0.6);
    letter-spacing: 0.08em;
    max-width: 520px;
    line-height: 1.7;
}

/* gold ornament line */
.gold-divider {
    display: flex;
    align-items: center;
    gap: 14px;
    color: var(--gold);
    opacity: 0.7;
    width: 160px;
    margin: 4px auto;
}
.gold-divider::before,
.gold-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--gold);
    opacity: 0.4;
}
.gold-divider-dot { font-size: 0.5rem; }

/* ─── Filter & search strip ─── */
.collection-controls {
    background: #fff;
    border-bottom: 1px solid var(--border);
    padding: 18px 40px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    position: sticky;
    top: 0;
    z-index: 10;
    backdrop-filter: blur(8px);
}

.collection-search {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.collection-search svg {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gold);
    opacity: 0.7;
    pointer-events: none;
}

.collection-search input {
    width: 100%;
    padding: 11px 16px 11px 40px;
    border: 1px solid var(--border);
    background: var(--cream);
    font-family: 'EB Garamond', serif;
    font-size: 0.95rem;
    letter-spacing: 0.04em;
    color: var(--dark);
    outline: none;
    transition: border-color 0.2s, background 0.2s;
}

.collection-search input::placeholder { color: #a09880; }

.collection-search input:focus {
    border-color: var(--gold);
    background: #fff;
}

.collection-sort {
    padding: 11px 20px;
    border: 1px solid var(--border);
    background: var(--cream);
    font-family: 'EB Garamond', serif;
    font-size: 0.95rem;
    letter-spacing: 0.04em;
    color: var(--dark);
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23B8964C' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 38px;
    transition: border-color 0.2s;
}
.collection-sort:focus { border-color: var(--gold); }

.collection-count {
    font-family: 'Cinzel', serif;
    font-size: 0.68rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--gold);
    white-space: nowrap;
}

/* ─── Grid ─── */
.collection-inner {
    padding: 56px 40px 80px;
    max-width: 1280px;
    margin: 0 auto;
}

.collection-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 36px;
}

/* ─── Product card ─── */
.pc-card {
    background: #fff;
    border: 1px solid var(--border);
    cursor: pointer;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    overflow: hidden;
}

.pc-card:hover {
    box-shadow: 0 16px 60px rgba(0,0,0,0.12);
    transform: translateY(-6px);
}

/* badge */
.pc-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    z-index: 2;
    font-family: 'Cinzel', serif;
    font-size: 0.58rem;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    padding: 5px 12px;
    color: #fff;
}
.pc-badge.new      { background: var(--dark); }
.pc-badge.low      { background: #92631e; }
.pc-badge.sold-out { background: #8b1a1a; }
.pc-badge.sale      { background: var(--gold); }

/* wishlist btn */
.pc-wish {
    position: absolute;
    top: 14px;
    right: 14px;
    z-index: 2;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    opacity: 0;
    transform: translateY(-4px);
    transition: opacity 0.2s, transform 0.2s;
    border: 1px solid var(--border);
    cursor: pointer;
}
.pc-card:hover .pc-wish {
    opacity: 1;
    transform: translateY(0);
}
.pc-wish svg { width: 15px; height: 15px; stroke: var(--gold); fill: none; }

/* image */
.pc-img-wrap {
    width: 100%;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: #f0ede8;
    flex-shrink: 0;
}

.pc-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.55s cubic-bezier(0.25,0.46,0.45,0.94);
}

.pc-card:hover .pc-img-wrap img {
    transform: scale(1.07);
}

/* overlay CTA */
.pc-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    /* sits over the image */
    top: 0;
    display: flex;
    align-items: flex-end;
    pointer-events: none;
}

.pc-overlay-btn {
    width: 100%;
    background: rgba(26,26,26,0.88);
    color: var(--cream);
    font-family: 'Cinzel', serif;
    font-size: 0.65rem;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    text-align: center;
    padding: 14px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
    pointer-events: auto;
}

.pc-card:hover .pc-overlay-btn {
    transform: translateY(0);
}

/* card body */
.pc-body {
    padding: 22px 20px 24px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.pc-category {
    font-family: 'Cinzel', serif;
    font-size: 0.6rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--gold);
}

.pc-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    font-weight: 400;
    color: var(--dark);
    letter-spacing: 0.02em;
    line-height: 1.35;
}

.pc-desc {
    font-family: 'EB Garamond', serif;
    font-size: 0.9rem;
    color: var(--mid);
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pc-stars {
    color: var(--gold);
    font-size: 0.7rem;
    letter-spacing: 2px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.pc-stars span { font-family: 'EB Garamond', serif; font-size: 0.8rem; color: var(--mid); }

/* thin gold rule */
.pc-rule {
    height: 1px;
    background: linear-gradient(to right, transparent, var(--gold) 40%, transparent);
    opacity: 0.25;
    margin: 4px 0;
}

.pc-price-row {
    display: flex;
    align-items: baseline;
    gap: 8px;
}

.pc-price {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    color: var(--dark);
    letter-spacing: 0.04em;
}

.pc-original {
    font-family: 'EB Garamond', serif;
    font-size: 0.85rem;
    color: #b0a898;
    text-decoration: line-through;
}

.pc-saving {
    font-family: 'Cinzel', serif;
    font-size: 0.6rem;
    color: #92631e;
    letter-spacing: 0.1em;
    background: rgba(184,150,76,0.1);
    padding: 2px 8px;
    border-radius: 1px;
}

/* ─── Empty / loading states ─── */
.collection-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 24px;
    font-family: 'EB Garamond', serif;
    font-size: 1.1rem;
    color: var(--mid);
    letter-spacing: 0.06em;
}

.collection-loader {
    display: inline-block;
    width: 32px;
    height: 32px;
    border: 1px solid var(--gold);
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.9s linear infinite;
    margin: 0 auto 16px;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* ─── Fade-in ─── */
.fade-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.fade-up.visible {
    opacity: 1;
    transform: none;
}

/* ─── Responsive ─── */
@media (max-width: 768px) {
    .collection-controls { padding: 14px 20px; }
    .collection-inner { padding: 36px 20px 60px; }
    .collection-grid { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 24px; }
}
</style>
@endpush

@section('content')
<div class="nav-divider"></div>

<div class="collection-page">

    {{-- ── Hero ── --}}
    <div class="collection-hero">
        <div class="collection-hero-eyebrow">The AUSHVERA Collection</div>
        <div class="gold-divider"><span class="gold-divider-dot">◆</span></div>
        <h1>Wellness, <em>Refined.</em></h1>
        <p class="collection-hero-sub">
            Each formulation is a study in botanical restraint — only what serves, nothing more.
        </p>
    </div>

    {{-- ── Sticky filter bar ── --}}
    <div class="collection-controls">
        <div class="collection-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input
                type="text"
                id="searchInput"
                placeholder="Search the collection..."
                oninput="filterProducts()"
                autocomplete="off"
            >
        </div>

        <select class="collection-sort" id="sortSelect" onchange="filterProducts()">
            <option value="default">Featured</option>
            <option value="price-asc">Price — Low to High</option>
            <option value="price-desc">Price — High to Low</option>
            <option value="name-asc">Name — A to Z</option>
            <option value="rating">Top Rated</option>
        </select>

        <div class="collection-count" id="resultCount"></div>
    </div>

    {{-- ── Grid ── --}}
    <div class="collection-inner">
        <div class="collection-grid" id="productsGrid">
            <div class="collection-state">
                <div class="collection-loader"></div>
                <br>Curating your collection…
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let allProducts = [];

function starsHTML(rating) {
    if (!rating) return '';
    const n = Math.round(parseFloat(rating));
    return '★'.repeat(n) + '☆'.repeat(5 - n);
}

function badgeHTML(p) {
    if (p.track_inventory) {
        if (p.stock <= 0)
            return '<div class="pc-badge sold-out">Sold Out</div>';
        if (p.low_stock_threshold && p.stock <= p.low_stock_threshold)
            return '<div class="pc-badge low">Last Few</div>';
    }
    if (p.original_price && p.original_price > p.price)
        return '<div class="pc-badge sale">Sale</div>';
    return '<div class="pc-badge new">New</div>';
}

function cardHTML(p) {
    const img = p.image || '{{ asset("assets/img/product.jpeg") }}';
    const fallback = '{{ asset("assets/img/product.jpeg") }}';
    const hasDiscount = p.original_price && parseFloat(p.original_price) > parseFloat(p.price);
    const saving = hasDiscount
        ? Math.round(((p.original_price - p.price) / p.original_price) * 100)
        : 0;

    return `
        <div class="pc-card fade-up" onclick="goToProduct(${p.id})">

            ${badgeHTML(p)}

            <button class="pc-wish" onclick="event.stopPropagation()" title="Save to wishlist" aria-label="Wishlist">
                <svg viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                </svg>
            </button>

            <div class="pc-img-wrap">
                <img src="${img}" alt="${p.name}" onerror="this.src='${fallback}'" loading="lazy">
                <div class="pc-overlay">
                    <div class="pc-overlay-btn">View Details</div>
                </div>
            </div>

            <div class="pc-body">
                ${p.category ? `<div class="pc-category">${p.category}</div>` : ''}
                <div class="pc-name">${p.name}</div>
                ${p.description ? `<div class="pc-desc">${p.description}</div>` : ''}

                ${p.average_rating ? `
                    <div class="pc-stars">
                        ${starsHTML(p.average_rating)}
                        <span>(${p.reviews_count || 0})</span>
                    </div>` : ''}

                <div class="pc-rule"></div>

                <div class="pc-price-row">
                    <div class="pc-price">₹${parseFloat(p.price).toLocaleString('en-IN')}</div>
                    ${hasDiscount ? `<div class="pc-original">₹${parseFloat(p.original_price).toLocaleString('en-IN')}</div>` : ''}
                    ${saving ? `<div class="pc-saving">${saving}% off</div>` : ''}
                </div>
            </div>
        </div>
    `;
}

function renderProducts(products) {
    const grid = document.getElementById('productsGrid');
    const countEl = document.getElementById('resultCount');

    if (!products.length) {
        grid.innerHTML = '<div class="collection-state">No products found.</div>';
        countEl.textContent = '';
        return;
    }

    countEl.textContent = `${products.length} Item${products.length !== 1 ? 's' : ''}`;
    grid.innerHTML = products.map(cardHTML).join('');

    // Staggered fade-in
    grid.querySelectorAll('.fade-up').forEach((el, i) => {
        el.style.transitionDelay = `${i * 60}ms`;
        requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('visible')));
    });
}

function filterProducts() {
    const q    = document.getElementById('searchInput').value.toLowerCase().trim();
    const sort = document.getElementById('sortSelect').value;

    let list = allProducts.filter(p =>
        p.name.toLowerCase().includes(q) ||
        (p.description || '').toLowerCase().includes(q) ||
        (p.category || '').toLowerCase().includes(q)
    );

    if (sort === 'price-asc')  list.sort((a,b) => a.price - b.price);
    if (sort === 'price-desc') list.sort((a,b) => b.price - a.price);
    if (sort === 'name-asc')   list.sort((a,b) => a.name.localeCompare(b.name));
    if (sort === 'rating')     list.sort((a,b) => (b.average_rating||0) - (a.average_rating||0));

    renderProducts(list);
}

function goToProduct(id) {
    window.location.href = '{{ url('/product') }}?id=' + id;
}

async function loadProducts() {
    try {
        const res  = await fetch('{{ url('/api/products') }}');
        const data = await res.json();
        allProducts = Array.isArray(data) ? data : (data.data || []);
        filterProducts();
    } catch {
        document.getElementById('productsGrid').innerHTML =
            '<div class="collection-state">Unable to load products. Please try again.</div>';
    }
}

loadProducts();
</script>
@endpush
