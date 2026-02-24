<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('responsive.css') }}">
    <script src="{{ asset('api-config.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <title>Admin Dashboard — AUSHVERA</title>
</head>
<body>
    <div class="flex h-screen">
        <aside class="sidebar">
            <div class="sidebar-header">AUSHVERA</div>
<aside class="sidebar">
    <div class="sidebar-header">AUSHVERA Admin</div>
<aside class="sidebar">
    <div class="sidebar-header">AUSHVERA Admin</div>
    <nav class="sidebar-nav">
        <a href="{{ url('/admin') }}" class="nav-link" data-page="dashboard">Dashboard</a>
        
        <div class="nav-section">
            <div class="nav-section-title">Products</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/products') }}" class="nav-link nav-sub" data-page="products">All Products</a>
                <a href="{{ url('/admin/inventory') }}" class="nav-link nav-sub" data-page="inventory">Inventory</a>
                <a href="{{ url('/admin/pricing') }}" class="nav-link nav-sub" data-page="pricing">Pricing</a>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Orders</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/orders') }}" class="nav-link nav-sub" data-page="orders">All Orders</a>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Users</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/users') }}" class="nav-link nav-sub" data-page="users">All Users</a>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Marketing</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/banners') }}" class="nav-link nav-sub" data-page="banners">Banners</a>
                <a href="{{ url('/admin/coupons') }}" class="nav-link nav-sub" data-page="coupons">Coupons</a>
                <a href="{{ url('/admin/reviews') }}" class="nav-link nav-sub" data-page="reviews">Reviews</a>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Reports</div>
            <div class="nav-section-content">
                <a href="{{ url('/admin/login-history') }}" class="nav-link nav-sub" data-page="login-history">Login History</a>
            </div>
        </div>
        
        <a href="{{ url('/') }}" class="nav-link">Back to Site</a>
        <button onclick="logout()">Logout</button>
    </nav>
</aside>
</aside>
        </aside>
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <div class="header-actions">
                    <button class="btn btn-accent">+ Add New</button>
                </div>
            </header>
            <div class="page-content">
                <div class="grid">
                    <div class="card">
                        <h3>Total Orders</h3>
                        <p id="totalOrders">0</p>
                    </div>
                    <div class="card">
                        <h3>Total Revenue</h3>
                        <p id="totalRevenue">₹0</p>
                    </div>
                    <div class="card">
                        <h3>Total Users</h3>
                        <p id="totalUsers">0</p>
                    </div>
                    <div class="card">
                        <h3>Total Products</h3>
                        <p id="totalProducts">0</p>
                    </div>
                </div>
                <div class="section">
                    <h2>Recent Data</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                            <tr><td colspan="4" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Modal Title</h2>
                <button class="modal-close" onclick="AdminApp.hideModal('modal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="modalForm">
                    <div class="form-group">
                        <label>Field Name</label>
                        <input type="text" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" onclick="AdminApp.hideModal('modal')">Cancel</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>

    <script>
        AdminApp.setActiveNav('{{ url("/admin") }}');
        AdminApp.checkAdmin();
    </script>
</body>
</html>
