<nav class="nav-{{ $navType ?? 'home' }}">
    <div class="nav-container">
        <div class="nav-left">
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">HOME</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">ABOUT</a></li>
                <li><a href="{{ route('philosophy') }}" class="{{ request()->routeIs('philosophy') ? 'active' : '' }}">PHILOSOPHY</a></li>
            </ul>
        </div>
        <a class="nav-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="AUSHVERA Logo" class="nav-logo">
            <span>AUSHVERA</span>
        </a>
        <div class="nav-right">
            <ul class="nav-links">
                <li><a href="{{ route('product') }}" class="{{ request()->routeIs('product') ? 'active' : '' }}">PRODUCT</a></li>
                <li><a href="{{ route('ritual') }}" class="{{ request()->routeIs('ritual') ? 'active' : '' }}">RITUAL</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">CONTACT</a></li>
            </ul>
            <a href="{{ route('cart') }}" class="cart-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span class="cart-count">0</span>
            </a>
            <a href="{{ route('profile') }}" class="nav-icon" id="profileIcon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                </svg>
            </a>
        </div>
    </div>
</nav>
