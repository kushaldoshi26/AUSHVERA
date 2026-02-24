<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h2>AUSHVERA</h2>
        <p>Admin Panel</p>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ url('/admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
            <span>📊</span> Dashboard
        </a>
        
        <div class="nav-section">
            <div class="nav-section-title" onclick="toggleSection(this)">Products</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/products') }}" class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}">
                    <span>📦</span> All Products
                </a>
                <a href="{{ url('/admin/inventory') }}" class="nav-link {{ request()->is('admin/inventory') ? 'active' : '' }}">
                    <span>📋</span> Inventory
                </a>
                <a href="{{ url('/admin/pricing') }}" class="nav-link {{ request()->is('admin/pricing') ? 'active' : '' }}">
                    <span>💰</span> Pricing
                </a>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title" onclick="toggleSection(this)">Orders</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/orders') }}" class="nav-link {{ request()->is('admin/orders') ? 'active' : '' }}">
                    <span>🛒</span> All Orders
                </a>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title" onclick="toggleSection(this)">Users</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                    <span>👥</span> All Users
                </a>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title" onclick="toggleSection(this)">Marketing</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/banners') }}" class="nav-link {{ request()->is('admin/banners') ? 'active' : '' }}">
                    <span>🎨</span> Banners
                </a>
                <a href="{{ url('/admin/coupons') }}" class="nav-link {{ request()->is('admin/coupons') ? 'active' : '' }}">
                    <span>🎟️</span> Coupons
                </a>
                <a href="{{ url('/admin/reviews') }}" class="nav-link {{ request()->is('admin/reviews') ? 'active' : '' }}">
                    <span>⭐</span> Reviews
                </a>
            </div>
        </div>
        
        <a href="{{ url('/') }}" class="nav-link">
            <span>🏠</span> Back to Site
        </a>
        
        <button onclick="logout()" class="nav-link logout-btn">
            <span>🚪</span> Logout
        </button>
    </nav>
</aside>

<script>
function toggleSection(element) {
    const section = element.parentElement;
    section.classList.toggle('open');
}

function logout() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('currentUser');
    window.location.href = '{{ url("/") }}';
}
</script>
