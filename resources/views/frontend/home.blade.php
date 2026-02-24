@extends('layouts.app')

@section('title', 'AUSHVERA — Wellness, Refined by Nature')

@section('content')
    <section class="hero">
        <div class="banner-slider">
            <div class="banner-slide active">
                <img src="{{ asset('assets/img/banner1.png') }}" alt="Aushvera Banner 1">
            </div>
            <div class="banner-slide">
                <img src="{{ asset('assets/img/banner2.png') }}" alt="Aushvera Banner 2">
            </div>
            <div class="banner-slide">
                <img src="{{ asset('assets/img/banner3.png') }}" alt="Aushvera Banner 3">
            </div>
        </div>
        <div class="hero-content">
            <div class="hero-slide-content active">
                <div class="hero-text">
                    <div class="ornamental-divider">
                        <img src="{{ asset('assets/img/pattern.png') }}" alt="" style="width: 500px; height: auto;">
                    </div>
                    <h1>Discover The<br><span style="color: #B8964C; font-size: 72px; font-family: 'Playfair Display', serif; font-style: italic;">Healing Wisdom</span><br>of Ayurveda</h1>
                    <div class="ornamental-divider">
                        <img src="{{ asset('assets/img/pattern.png') }}" alt="" style="width: 500px; height: auto; transform: scaleY(-1);">
                    </div>
                    <a href="{{ url('product') }}" class="cta-primary" style="margin-top: 2rem;">SHOP NOW</a>
                </div>
            </div>
            <div class="hero-slide-content">
                <div class="hero-text">
                    <div class="ornamental-divider">
                        <img src="{{ asset('assets/img/pattern.png') }}" alt="" style="width: 500px; height: auto;">
                    </div>
                    <h1>Embrace<br><span style="color: #B8964C; font-size: 72px; font-family: 'Playfair Display', serif; font-style: italic;">Ancient Rituals</span><br>for Modern Life</h1>
                    <div class="ornamental-divider">
                        <img src="{{ asset('assets/img/pattern.png') }}" alt="" style="width: 500px; height: auto; transform: scaleY(-1);">
                    </div>
                    <a href="{{ url('ritual') }}" class="cta-primary" style="margin-top: 2rem;">EXPLORE RITUALS</a>
                </div>
            </div>
            <div class="hero-slide-content">
                <div class="hero-text">
                    <h1 style="font-family: 'Cinzel', serif; font-size: 60px; color: var(--cream); letter-spacing: 0.05em; line-height: 1.1; margin-bottom: 32px;">Wellness,<br>Refined by Nature.</h1>
                    <p style="font-size: 16px; color: rgba(247, 244, 238, 0.75); font-weight: 300; line-height: 1.7; max-width: 550px; margin-bottom: 48px;">Rooted in ancient botanical wisdom, crafted for the modern world.</p>
                    <a href="{{ url('ritual') }}" class="cta-primary">Explore the Ritual</a>
                </div>
            </div>
        </div>
    </section>

    <section class="heritage fade-in">
        <div class="heritage-grid">
            <div class="heritage-text">
                <h2>Honoring Heritage, Refining Wellness.</h2>
                <p>For centuries, botanical rituals have sustained vitality across cultures. AUSHVERA honors this wisdom—not by replicating the past, but by refining it for the present.</p>
                <p>Each formulation is a study in restraint: only what serves, nothing more. Clean ingredients. Timeless presentation. Quiet confidence.</p>
                <p>Improve respiratory health and digestion.</p>
                <a href="{{ url('about') }}" class="btn-outline">Our Story</a>
            </div>
            <div class="heritage-image">
                <img src="{{ asset('assets/img/ritual-image.png') }}" alt="Ritual Scene" style="width: 80%; height: 80%; object-fit: contain;">
            </div>
        </div>
    </section>

    <section class="philosophy-section fade-in">
        <h2>The Aushvera Philosophy</h2>
        <div class="pillars">
            <div class="pillar">
                <div class="pillar-icon">
                    <img src="{{ asset('assets/img/purity.png') }}" alt="Purity" style="width: 100px; height: 100px; object-fit: contain;">
                </div>
                <h3>Plant-First Formulation</h3>
                <p>Botanicals chosen for their time-tested efficacy, not trends.</p>
            </div>
            <div class="pillar">
                <div class="pillar-icon">
                    <img src="{{ asset('assets/img/legacy.png') }}" alt="Legacy" style="width: 100px; height: 100px; object-fit: contain;">
                </div>
                <h3>Clean-Label Integrity</h3>
                <p>Every ingredient listed. No proprietary blends. Total transparency.</p>
            </div>
            <div class="pillar">
                <div class="pillar-icon">
                    <img src="{{ asset('assets/img/precision.png') }}" alt="Precision" style="width: 100px; height: 100px; object-fit: contain;">
                </div>
                <h3>Timeless Presentation</h3>
                <p>Designed to endure beyond seasons, campaigns, and hype.</p>
            </div>
        </div>
    </section>

    <section class="purity-section fade-in">
        <div class="container-narrow">
            <h2>Purity & Sourcing</h2>
            <div class="divider-gold"></div>
            <p class="section-intro">Every ingredient is traced, tested, and transparently sourced from ethical partners who share our commitment to botanical integrity.</p>
            <div class="purity-grid">
                <div class="purity-item">
                    <h3>Water-Based Extraction</h3>
                    <p>No harsh chemicals. Only pure water extraction to preserve the natural essence of each botanical.</p>
                </div>
                <div class="purity-item">
                    <h3>Third-Party Tested</h3>
                    <p>Every batch undergoes rigorous testing for purity, potency, and safety by independent laboratories.</p>
                </div>
                <div class="purity-item">
                    <h3>Sustainable Sourcing</h3>
                    <p>We partner with regenerative farms that honor the earth and support local communities.</p>
                </div>
                <div class="purity-item">
                    <h3>No Artificial Additives</h3>
                    <p>Zero preservatives, fillers, or synthetic ingredients. Only what nature intended.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="product-carousel-section fade-in">
        <h2>Our Wellness Collection</h2>
        <div class="carousel-container">
            <div class="carousel-track">
                <div class="carousel-item" onclick="window.location.href='{{ url('product?id=1') }}'" style="cursor:pointer">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('assets/img/product.jpeg') }}" alt="Ashvattha Tea">
                        </div>
                        <h3>Ashvattha™ Tea</h3>
                        <p>Sacred leaf wellness</p>
                    </div>
                </div>
                <div class="carousel-item" onclick="window.location.href='{{ url('product?id=2') }}'" style="cursor:pointer">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('assets/img/ritual-1.jpeg') }}" alt="Herbal Elixir">
                        </div>
                        <h3>Herbal Elixir</h3>
                        <p>Daily vitality blend</p>
                    </div>
                </div>
                <div class="carousel-item" onclick="window.location.href='{{ url('product?id=3') }}'" style="cursor:pointer">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('assets/img/ritual-2.jpeg') }}" alt="Botanical Tonic">
                        </div>
                        <h3>Botanical Tonic</h3>
                        <p>Restorative formula</p>
                    </div>
                </div>
                <div class="carousel-item" onclick="window.location.href='{{ url('product?id=4') }}'" style="cursor:pointer">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('assets/img/ritual-3.jpeg') }}" alt="Wellness Drops">
                        </div>
                        <h3>Wellness Drops</h3>
                        <p>Concentrated essence</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-showcase-section fade-in">
        <div class="product-showcase-grid">
            <div class="product-text">
                <h2>Ashvattha Classic</h2>
                <p class="product-tagline">A Sacred Leaf. A Modern Ritual.</p>
                <ul class="product-benefits">
                    <li>Naturally calming</li>
                    <li>Traditionally respected</li>
                    <li>Designed for daily rituals</li>
                </ul>
                <a href="#" onclick="navigateToProducts(event)" class="cta-primary">Discover More</a>
            </div>
            <div class="product-image-container">
                <img src="{{ asset('assets/img/Ashvattha Classic.jpeg') }}" alt="Ashvattha Classic" class="showcase-product-image">
            </div>
        </div>
    </section>

    <section class="ritual-section fade-in" id="ritual">
        <h2>Your Daily Ritual</h2>
        <div class="ritual-steps-grid">
            <div class="ritual-step">
                <div class="ritual-number">1</div>
                <h3>Morning Intention</h3>
                <p>Begin each day with a moment of stillness and a cup of Ashvattha™.</p>
            </div>
            <div class="ritual-step">
                <div class="ritual-number">2</div>
                <h3>Mindful Preparation</h3>
                <p>Steep with care. Let the ritual slow you down, even for a moment.</p>
            </div>
            <div class="ritual-step">
                <div class="ritual-number">3</div>
                <h3>Consistent Practice</h3>
                <p>Wellness unfolds over time. Commit to the practice, not the promise.</p>
            </div>
        </div>
        <div class="ritual-cta">
            <a href="{{ url('ritual') }}" class="btn-outline">Discover Ashvattha™</a>
        </div>
    </section>

    <div id="cartModal" class="cart-modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2>Added to Cart!</h2>
            <p>Product has been added to your cart.</p>
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
        let cartCount = 0;
        
        async function updateCartDisplay() {
            const cartCountElement = document.querySelector('.cart-count');
            if (!cartCountElement) return;
            
            if (api.getToken()) {
                try {
                    const response = await api.getCartCount();
                    cartCount = response.data.count;
                } catch (error) {
                    cartCount = 0;
                }
            } else {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            }
            
            cartCountElement.textContent = cartCount;
            cartCountElement.style.display = cartCount > 0 ? 'flex' : 'none';
        }
        
        updateCartDisplay();

        function addToCart() {
            const product = {
                id: 'essential-elixir',
                name: 'The Essential Elixir',
                description: '60ml / 2 fl oz',
                price: 29.00,
                image: '{{ asset('assets/img/product.jpeg') }}',
                quantity: 1
            };
            
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push(product);
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            localStorage.setItem('cartCount', cartCount);
            updateCartDisplay();
            showModal();
        }

        function showModal() {
            document.getElementById('cartModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('cartModal').style.display = 'none';
        }

        function checkout() {
            window.location.href = '{{ url('chart') }}';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('cartModal');
            if (event.target == modal) {
                closeModal();
            }
        }
        
        let currentSlide = 0;
        const slides = document.querySelectorAll('.banner-slide');
        const textSlides = document.querySelectorAll('.hero-slide-content');
        let rotationTime = 5000;
        let rotationInterval;
        
        async function loadBanners() {
            try {
                const response = await fetch('{{ url("/api/banners") }}');
                const data = await response.json();
                const banners = (data.data || []).filter(b => b.is_active);
                
                if (banners.length > 0) {
                    const sliderContainer = document.querySelector('.banner-slider');
                    sliderContainer.innerHTML = banners.sort((a, b) => (a.display_order || 0) - (b.display_order || 0)).map((b, i) => `
                        <div class="banner-slide ${i === 0 ? 'active' : ''}" data-rotation="${b.rotation_time || 5}">
                            ${b.link_url ? `<a href="${b.link_url}" target="_blank">` : ''}
                            <img src="${b.image_url}" alt="${b.title}" style="width:100%;" onerror="this.src='{{ asset('assets/img/banner1.png') }}'">
                            ${b.link_url ? '</a>' : ''}
                        </div>
                    `).join('');
                    
                    rotationTime = (banners[0].rotation_time || 5) * 1000;
                    startBannerRotation();
                }
            } catch (error) {
                console.error('Error loading banners:', error);
            }
        }
        
        function startBannerRotation() {
            if (rotationInterval) clearInterval(rotationInterval);
            const slides = document.querySelectorAll('.banner-slide');
            if (slides.length <= 1) return;
            
            rotationInterval = setInterval(() => {
                const currentRotation = parseInt(slides[currentSlide].dataset.rotation || 5) * 1000;
                nextSlide();
            }, rotationTime);
        }
        
        function nextSlide() {
            const slides = document.querySelectorAll('.banner-slide');
            const textSlides = document.querySelectorAll('.hero-slide-content');
            
            slides[currentSlide].classList.remove('active');
            if (textSlides[currentSlide]) textSlides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
            if (textSlides[currentSlide]) textSlides[currentSlide].classList.add('active');
            
            rotationTime = (parseInt(slides[currentSlide].dataset.rotation || 5)) * 1000;
            startBannerRotation();
        }
        
        loadBanners();

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
        
        async function checkAuthState() {
            const token = api.getToken();
            const profileIcon = document.getElementById('profileIcon');
            
            if (token) {
                try {
                    const response = await api.getUser();
                    const user = response.data;
                    
                    if (user.role === 'admin') {
                        profileIcon.href = '{{ url('admin') }}';
                        profileIcon.title = 'Admin Dashboard';
                    } else {
                        profileIcon.href = '{{ url('profile') }}';
                        profileIcon.title = 'My Profile';
                    }
                } catch (error) {
                    profileIcon.href = '{{ url('profile') }}';
                    profileIcon.title = 'Profile';
                }
            } else {
                profileIcon.href = '{{ url('profile') }}';
                profileIcon.title = 'Profile';
            }
        }
        
        checkAuthState();

        async function navigateToProducts(e) {
            e.preventDefault();
            try {
                const response = await api.getProducts();
                if (response.data && response.data.length === 1) {
                    window.location.href = '{{ url('product') }}?id=' + response.data[0].id;
                } else {
                    window.location.href = '{{ url('products') }}';
                }
            } catch (error) {
                window.location.href = '{{ url('products') }}';
            }
        }
    </script>
@endpush
