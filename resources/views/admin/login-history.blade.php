<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('api-config.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <title>Login History — AUSHVERA Admin</title>
    <link rel="stylesheet" href="{{ asset('responsive.css') }}">
</head>
<body>
    <div class="flex h-screen">
        <aside class="sidebar">
            <div class="sidebar-header">AUSHVERA Admin</div>
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
                <h1 class="page-title">Login History</h1>
            </header>
            <div class="page-content">
                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Login Time</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody id="loginHistoryTable">
                            <tr><td colspan="5" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script>
        async AdminApp.logout() {
            try { await api.logout(); } catch(e) {}
            localStorage.removeItem('auth_token');
            localStorage.removeItem('currentUser');
            window.location.href = '{{ url("/profile") }}';
        }
        
        const user = JSON.parse(localStorage.getItem('user'));
        if (!user || user.role !== 'admin') {
            document.getElementById('loginModal').classList.add('active');
        }

        async function loadLoginHistory() {
            try {
                const response = await fetch('http://localhost:8000/api/admin/login-history');
                const data = await response.json();
                
                const tbody = document.getElementById('loginHistoryTable');
                if (!data || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center p-4">No login history found</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.map(log => `
                    <tr>
                        <td>${log.name}</td>
                        <td>${log.email}</td>
                        <td><span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; ${log.role === 'admin' ? 'background: #fee2e2; color: #991b1b;' : 'background: #dbeafe; color: #1e40af;'}">${log.role}</span></td>
                        <td>${new Date(log.login_time).toLocaleString()}</td>
                        <td>${log.ip_address || 'N/A'}</td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('loginHistoryTable').innerHTML = '<tr><td colspan="5" class="text-center p-4 text-red-500">Error loading login history</td></tr>';
            }
        }

        loadLoginHistory();
    </script>
</body>
</html>
