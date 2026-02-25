@extends('layouts.app')

@section('title', 'Product — AUSHVERA')

@section('content')
    <div class="nav-divider"></div>

    <section class="product-hero">
        <div class="product-container">
            <div class="product-image-section">
                <div class="product-gallery">
                    <div class="main-product-image" onclick="openImageModal()" style="cursor: zoom-in;">
                        <img src="{{ asset('assets/img/product.jpeg') }}" alt="The Essential Elixir" class="active-image" id="mainImage">
                    </div>
                    <div class="thumbnail-gallery">
                        <img src="{{ asset('assets/img/product.jpeg') }}" alt="Product view 1" class="thumbnail active" onclick="changeImage(this)">
                        <img src="{{ asset('assets/img/ritual-1.jpeg') }}" alt="Product view 2" class="thumbnail" onclick="changeImage(this)">
                        <img src="{{ asset('assets/img/ritual-2.jpeg') }}" alt="Product view 3" class="thumbnail" onclick="changeImage(this)">
                    </div>
                </div>
            </div>

            <div class="product-info-section">
                <h1 class="product-title">Ashvattha Classic</h1>
                
                <div class="product-rating">
                    <div class="stars">
                        <span class="star filled">★</span>
                        <span class="star filled">★</span>
                        <span class="star filled">★</span>
                        <span class="star filled">★</span>
                        <span class="star filled">★</span>
                    </div>
                    <span class="rating-text">4.8 (1,248 reviews)</span>
                </div>
                
                <p class="product-subtitle">A singular formulation. Years in refinement.</p>
                
                <div class="title-divider"></div>
                
                <p class="product-description">
                    A concentrated botanical essence designed to support vitality from within. 
                    Formulated with adaptogens and time-honored herbs, this elixir embodies 
                    the quiet power of nature—refined for modern rituals.
                </p>

                <div class="price-section">
                    <div class="current-price">₹1,899</div>
                    <div class="original-price">₹2,299</div>
                    <div class="savings">Save ₹400</div>
                </div>

                <div class="purchase-options">
                    <div class="purchase-type">
                        <label class="radio-option">
                            <input type="radio" name="purchase-type" value="onetime" checked>
                            <span>One-time purchase</span>
                        </label>
                        <label class="radio-option subscribe">
                            <input type="radio" name="purchase-type" value="subscribe">
                            <span>Subscribe & Save 10%</span>
                            <span class="subscribe-price">₹1,709</span>
                        </label>
                    </div>
                    <div class="delivery-frequency" id="deliveryFrequency" style="display: none;">
                        <label>Deliver every:</label>
                        <select>
                            <option>30 days</option>
                            <option>60 days</option>
                            <option>90 days</option>
                        </select>
                    </div>
                </div>

                <div class="quantity-section">
                    <label>Quantity:</label>
                    <div class="quantity-selector">
                        <button class="qty-btn" onclick="decreaseQty()">−</button>
                        <input type="number" id="quantity" value="1" min="1" readonly>
                        <button class="qty-btn" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <div class="bundle-offers">
                    <div class="offer-tag">🔥 Buy 2 Get 5% Off</div>
                    <div class="offer-tag">🔥 Buy 3 Get 10% Off</div>
                </div>

                <div class="action-buttons">
                    <button class="buy-now-btn" onclick="addToCart()">ADD TO CART</button>
                    <button class="wishlist-btn" onclick="toggleWishlist()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </button>
                </div>
                <button class="add-to-cart-btn-full" onclick="buyNow()">BUY NOW</button>

                <div class="delivery-info">
                    <div class="delivery-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="3" width="15" height="13"/>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                            <circle cx="5.5" cy="18.5" r="2.5"/>
                            <circle cx="18.5" cy="18.5" r="2.5"/>
                        </svg>
                        <span>Free Shipping across India</span>
                    </div>
                    <div class="delivery-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>Delivery in 2–4 business days</span>
                    </div>
                </div>

                <div class="trust-signals">
                    <div class="trust-item">✓ Secure Checkout</div>
                    <div class="trust-item">✓ 100% Authentic</div>
                    <div class="trust-item">✓ Lab Tested</div>
                    <div class="trust-item">✓ COD Available</div>
                </div>
            </div>
        </div>
    </section>

    <section class="benefits-section">
        <h2>What It Does</h2>
        <div class="benefits-list">
            <div class="benefit-item">
                <div class="benefit-bullet"></div>
                <p>Supports Cellular Vitality</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-bullet"></div>
                <p>Balances Stress Response</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-bullet"></div>
                <p>Designed for Daily Rituals</p>
            </div>
        </div>
    </section>

    <section class="reviews-section">
        <h2 class="reviews-main-title">CUSTOMER REVIEWS</h2>
        
        <div class="reviews-boxes">
            <div class="reviews-box-left">
                <div class="rating-display">
                    <span class="rating-big" id="avgRating">4.8</span>
                    <span class="rating-stars-big" id="avgStars">★★★★★</span>
                </div>
                <p class="rating-text" id="totalReviews">Based on 128 reviews</p>
                
                <div class="rating-bars-list">
                    <div class="rating-bar-item">
                        <span class="bar-star-label">5 ★</span>
                        <div class="bar-outer"><div class="bar-inner" style="width:0%"></div></div>
                        <span class="bar-percentage">0%</span>
                    </div>
                    <div class="rating-bar-item">
                        <span class="bar-star-label">4 ★</span>
                        <div class="bar-outer"><div class="bar-inner" style="width:0%"></div></div>
                        <span class="bar-percentage">0%</span>
                    </div>
                    <div class="rating-bar-item">
                        <span class="bar-star-label">3 ★</span>
                        <div class="bar-outer"><div class="bar-inner" style="width:0%"></div></div>
                        <span class="bar-percentage">0%</span>
                    </div>
                    <div class="rating-bar-item">
                        <span class="bar-star-label">2 ★</span>
                        <div class="bar-outer"><div class="bar-inner" style="width:0%"></div></div>
                        <span class="bar-percentage">0%</span>
                    </div>
                    <div class="rating-bar-item">
                        <span class="bar-star-label">1 ★</span>
                        <div class="bar-outer"><div class="bar-inner" style="width:0%"></div></div>
                        <span class="bar-percentage">0%</span>
                    </div>
                </div>

                <div class="info-items">
                    <div class="info-item">
                        <span>📦</span>
                        <span>Free shipping</span>
                    </div>
                    <div class="info-item">
                        <span>✓</span>
                        <span>1,000+ Authentic</span>
                    </div>
                    <div class="info-item">
                        <span>🚚</span>
                        <span>Delivery in 2-4 business days</span>
                    </div>
                    <div class="info-item">
                        <span>✓</span>
                        <span>COD Available</span>
                    </div>
                </div>
            </div>

            <div class="reviews-box-right">
                <div class="write-review-form">
                    <form id="reviewForm">
                        <div class="star-input" id="starInput">
                            <span data-rating="1">★</span>
                            <span data-rating="2">★</span>
                            <span data-rating="3">★</span>
                            <span data-rating="4">★</span>
                            <span data-rating="5">★</span>
                        </div>
                        <input type="hidden" id="ratingValue" required>
                        <textarea id="reviewText" placeholder="Write your review..." required></textarea>
                        <button type="submit">Submit</button>
                    </form>
                </div>
                <div id="reviewsListBox"></div>
                <div id="loadMoreBox" style="display:none;text-align:center;margin-top:15px;">
                    <button class="load-more-btn" onclick="loadMoreReviews()">Load More</button>
                </div>
            </div>
        </div>
    </section>

    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <span class="close-image-modal" onclick="closeImageModal()">&times;</span>
        <img class="modal-image-content" id="modalImage">
        <div class="image-modal-thumbnails">
            <img src="{{ asset('assets/img/product.jpeg') }}" onclick="changeModalImage(this, event)" class="modal-thumb">
            <img src="{{ asset('assets/img/ritual-1.jpeg') }}" onclick="changeModalImage(this, event)" class="modal-thumb">
            <img src="{{ asset('assets/img/ritual-2.jpeg') }}" onclick="changeModalImage(this, event)" class="modal-thumb">
        </div>
    </div>

    <div id="cartModal" class="cart-modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2>Added to Cart!</h2>
            <p>The Essential Elixir has been added to your cart.</p>
            <div class="modal-buttons">
                <button class="btn-continue" onclick="closeModal()">Continue Shopping</button>
                <button class="btn-checkout" onclick="checkout()">Checkout</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/api-config.js') }}"></script>
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
        updateCartDisplay();

        function changeImage(thumbnail) {
            const mainImage = document.querySelector('.active-image');
            mainImage.src = thumbnail.src;
            
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        function openImageModal() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const mainImg = document.getElementById('mainImage');
            
            modal.style.display = 'flex';
            modalImg.src = mainImg.src;
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        function changeModalImage(thumb, event) {
            event.stopPropagation();
            document.getElementById('modalImage').src = thumb.src;
        }

        function increaseQty() {
            const qtyInput = document.getElementById('quantity');
            qtyInput.value = parseInt(qtyInput.value) + 1;
        }

        function decreaseQty() {
            const qtyInput = document.getElementById('quantity');
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
            }
        }

        function toggleWishlist() {
            const btn = document.querySelector('.wishlist-btn');
            btn.classList.toggle('active');
        }

        document.querySelectorAll('input[name="purchase-type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const deliveryFreq = document.getElementById('deliveryFrequency');
                if (this.value === 'subscribe') {
                    deliveryFreq.style.display = 'flex';
                } else {
                    deliveryFreq.style.display = 'none';
                }
            });
        });

        function buyNow() {
            const quantity = parseInt(document.getElementById('quantity').value);
            const product = {
                id: productId,
                name: currentProduct?.name || 'The Essential Elixir',
                description: currentProduct?.description || '60ml / 2 fl oz',
                price: currentProductPrice,
                image: currentProduct?.image || '{{ asset('assets/img/product.jpeg') }}',
                quantity: quantity
            };
            
            const existingItem = cart.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push(product);
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            localStorage.setItem('cartCount', cartCount);
            updateCartDisplay();
            
            window.location.href = '{{ url('cart') }}';
        }

        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);
            const product = {
                id: productId,
                name: currentProduct?.name || 'The Essential Elixir',
                description: currentProduct?.description || '60ml / 2 fl oz',
                price: currentProductPrice,
                image: currentProduct?.image || '{{ asset('assets/img/product.jpeg') }}',
                quantity: quantity
            };
            
            const existingItem = cart.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push(product);
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            localStorage.setItem('cartCount', cartCount);
            updateCartDisplay();
            showModal();
        }

        function updateCartDisplay() {
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = cartCount;
                cartCountElement.style.display = cartCount > 0 ? 'flex' : 'none';
            }
        }

        function showModal() {
            document.getElementById('cartModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('cartModal').style.display = 'none';
        }

        function checkout() {
            window.location.href = '{{ url('cart') }}';
        }

        window.onclick = function(event) {
            const cartModalEl = document.getElementById('cartModal');
            if (event.target == cartModalEl) {
                closeModal();
            }
        }

        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id') || 1;
        let currentPage = 1;
        let selectedRating = 0;

        document.querySelectorAll('#starInput span').forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = this.dataset.rating;
                document.getElementById('ratingValue').value = selectedRating;
                document.querySelectorAll('#starInput span').forEach((s, i) => {
                    s.classList.toggle('active', i < selectedRating);
                });
            });
        });

        document.getElementById('reviewForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const user = JSON.parse(localStorage.getItem('user'));
            if (!user) {
                alert('Please login to submit a review');
                window.location.href = '{{ url('profile') }}';
                return;
            }

            try {
                const response = await fetch('{{ url('/api/reviews') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'User': JSON.stringify(user) },
                    body: JSON.stringify({
                        product_id: productId,
                        rating: selectedRating,
                        title: null,
                        review_text: document.getElementById('reviewText').value
                    })
                });

                if (response.ok) {
                    alert('Review submitted successfully!');
                    document.getElementById('reviewForm').reset();
                    selectedRating = 0;
                    document.querySelectorAll('#starInput span').forEach(s => s.classList.remove('active'));
                    currentPage = 1;
                    loadReviews();
                } else {
                    alert('Failed to submit review');
                }
            } catch (error) {
                alert('Error submitting review');
            }
        });

        async function loadReviews() {
            try {
                const response = await fetch(`{{ url('/api/products') }}/${productId}/reviews?page=${currentPage}`);
                const data = await response.json();

                document.getElementById('avgRating').textContent = data.average_rating || '4.8';
                document.getElementById('avgStars').textContent = '★'.repeat(Math.round(data.average_rating || 5));
                document.getElementById('totalReviews').textContent = `Based on ${data.total_reviews} reviews`;

                const breakdown = data.rating_breakdown;
                const total = data.total_reviews;
                document.querySelectorAll('.rating-bar-item').forEach((item, index) => {
                    const rating = 5 - index;
                    const count = breakdown[rating] || 0;
                    const percentage = total > 0 ? (count / total * 100) : 0;
                    item.querySelector('.bar-inner').style.width = percentage + '%';
                    item.querySelector('.bar-percentage').textContent = Math.round(percentage) + '%';
                });

                const list = document.getElementById('reviewsListBox');
                if (currentPage === 1) list.innerHTML = '';

                data.reviews.data.forEach(review => {
                    const item = document.createElement('div');
                    item.className = 'review-item-box';
                    item.innerHTML = `
                        <div class="review-header-box">
                            <div>
                                <div class="review-name-box">${review.user.name}</div>
                                <div class="review-stars-box">${'★'.repeat(review.rating)}</div>
                            </div>
                            <div class="review-date-box">${new Date(review.created_at).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}</div>
                        </div>
                        ${review.title ? `<div class="review-title-box">${review.title}</div>` : ''}
                        <div class="review-text-box">${review.review_text}</div>
                    `;
                    list.appendChild(item);
                });

                document.getElementById('loadMoreBox').style.display = data.reviews.next_page_url ? 'block' : 'none';
            } catch (error) { console.error('Error:', error); }
        }

        function loadMoreReviews() {
            currentPage++;
            loadReviews();
        }

        loadReviews();

        let currentProductPrice = 1899;
        let currentProduct = null;
        async function loadProductPricing() {
            try {
                const response = await fetch(`{{ url('/api/products') }}/${productId}`);
                const result = await response.json();
                const product = result.data || result;
                currentProduct = product;
                
                document.querySelector('.product-title').textContent = product.name || 'Ashvattha Classic';
                document.querySelector('.product-description').textContent = product.description || 'A concentrated botanical essence designed to support vitality from within.';
                
                if (product.price) {
                    currentProductPrice = product.price;
                    document.querySelector('.current-price').textContent = `₹${product.price}`;
                }
                if (product.original_price) {
                    document.querySelector('.original-price').textContent = `₹${product.original_price}`;
                    const savings = product.original_price - product.price;
                    document.querySelector('.savings').textContent = `Save ₹${savings}`;
                } else {
                    document.querySelector('.original-price').style.display = 'none';
                    document.querySelector('.savings').style.display = 'none';
                }
                
                if (product.display_images) {
                    try {
                        const images = JSON.parse(product.display_images);
                        if (images.length > 0) {
                            document.getElementById('mainImage').src = images[0];
                            const thumbGallery = document.querySelector('.thumbnail-gallery');
                            thumbGallery.innerHTML = images.map(img => 
                                `<img src="${img}" alt="Product view" class="thumbnail" onclick="changeImage(this)">`
                            ).join('');
                            thumbGallery.querySelector('.thumbnail').classList.add('active');
                            
                            const modalThumbs = document.querySelector('.image-modal-thumbnails');
                            modalThumbs.innerHTML = images.map(img => 
                                `<img src="${img}" onclick="changeModalImage(this, event)" class="modal-thumb">`
                            ).join('');
                        }
                    } catch {
                        if (product.image) {
                            document.getElementById('mainImage').src = product.image;
                            document.querySelector('.thumbnail-gallery').innerHTML = `<img src="${product.image}" alt="Product view" class="thumbnail active" onclick="changeImage(this)">`;
                        }
                    }
                } else if (product.image) {
                    document.getElementById('mainImage').src = product.image;
                    document.querySelector('.thumbnail-gallery').innerHTML = `<img src="${product.image}" alt="Product view" class="thumbnail active" onclick="changeImage(this)">`;
                }
            } catch (error) {
                console.error('Error loading pricing:', error);
            }
        }

        loadProductPricing();

        async function navigateToProducts(e) {
            e.preventDefault();
            try {
                const response = await fetch('{{ url('/api/products') }}');
                const products = await response.json();
                if (products.length === 1) {
                    window.location.href = '{{ url('product') }}?id=' + products[0].id;
                } else {
                    window.location.href = '{{ url('products') }}';
                }
            } catch (error) {
                window.location.href = '{{ url('products') }}';
            }
        }
    </script>
@endpush
