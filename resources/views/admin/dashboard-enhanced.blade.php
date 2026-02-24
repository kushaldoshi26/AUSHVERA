<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('api-config.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Dashboard — AUSHVERA</title>
    <link rel="stylesheet" href="{{ asset('responsive.css') }}">
</head>
<body>
    <div class="flex h-screen">
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
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <div class="header-actions">
                    <button class="btn btn-success" onclick="window.location.href='admin-products.html'">+ Add Product</button>
                </div>
            </header>
            <div class="page-content">
                <!-- Quick Stats -->
                <div class="grid">
                    <div class="card">
                        <h3>Today's Revenue</h3>
                        <p id="todayRevenue">₹0</p>
                    </div>
                    <div class="card">
                        <h3>This Month</h3>
                        <p id="monthRevenue">₹0</p>
                    </div>
                    <div class="card">
                        <h3>Total Orders</h3>
                        <p id="totalOrders">0</p>
                    </div>
                    <div class="card">
                        <h3>Low Stock Alert</h3>
                        <p id="lowStockCount" style="color: #ef4444;">0</p>
                    </div>
                </div>

                <!-- Charts Row -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div class="section">
                        <h2>Revenue Trend (Last 7 Days)</h2>
                        <canvas id="revenueChart" height="200"></canvas>
                    </div>
                    <div class="section">
                        <h2>Orders Trend (Last 7 Days)</h2>
                        <canvas id="ordersChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Top Products & Recent Orders -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="section">
                        <h2>Top Selling Products</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Sales</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody id="topProducts">
                                <tr><td colspan="3" class="text-center">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="section">
                        <h2>Recent Orders</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrders">
                                <tr><td colspan="3" class="text-center">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        let revenueChart, ordersChart;

        async function logout() {
            try { await api.logout(); } catch(e) {}
            localStorage.removeItem('auth_token');
            localStorage.removeItem('currentUser');
            window.location.href = '{{ url("/profile") }}';
        }
        
        async function checkAdmin() {
            const token = api.getToken();
            if (!token) {
                window.location.href = '{{ url("/profile") }}';
                return false;
            }
            
            try {
                const response = await api.getUser();
                if (response.data.role !== 'admin') {
                    alert('Access denied. Admin only.');
                    window.location.href = '{{ url("/") }}';
                    return false;
                }
                return true;
            } catch (error) {
                window.location.href = '{{ url("/profile") }}';
                return false;
            }
        }
        
        async function loadDashboard() {
            const token = localStorage.getItem('auth_token');
            
            try {
                // Load orders
                const ordersRes = await fetch('http://localhost:8000/api/admin/orders', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const ordersData = await ordersRes.json();
                const orders = ordersData.orders || [];
                
                // Calculate stats
                const today = new Date().toDateString();
                const todayOrders = orders.filter(o => new Date(o.created_at).toDateString() === today);
                const todayRevenue = todayOrders.reduce((sum, o) => sum + parseFloat(o.total_amount || 0), 0);
                
                const thisMonth = new Date().getMonth();
                const monthOrders = orders.filter(o => new Date(o.created_at).getMonth() === thisMonth);
                const monthRevenue = monthOrders.reduce((sum, o) => sum + parseFloat(o.total_amount || 0), 0);
                
                document.getElementById('todayRevenue').textContent = '₹' + todayRevenue.toFixed(2);
                document.getElementById('monthRevenue').textContent = '₹' + monthRevenue.toFixed(2);
                document.getElementById('totalOrders').textContent = orders.length;
                
                // Load low stock
                const inventoryRes = await fetch('http://localhost:8000/api/admin/inventory/low-stock', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const inventoryData = await inventoryRes.json();
                document.getElementById('lowStockCount').textContent = inventoryData.count || 0;
                
                // Load charts
                loadCharts(orders);
                
                // Load top products
                loadTopProducts(token);
                
                // Show recent orders
                const recentOrdersTbody = document.getElementById('recentOrders');
                if (orders.length === 0) {
                    recentOrdersTbody.innerHTML = '<tr><td colspan="3" class="text-center">No orders yet</td></tr>';
                } else {
                    recentOrdersTbody.innerHTML = orders.slice(0, 5).map(order => `
                        <tr>
                            <td>#${order.id}</td>
                            <td>₹${order.total_amount}</td>
                            <td><span class="badge badge-${order.status === 'completed' ? 'success' : 'warning'}">${order.status}</span></td>
                        </tr>
                    `).join('');
                }
            } catch (error) {
                console.error('Error loading dashboard:', error);
            }
        }
        
        function loadCharts(orders) {
            // Last 7 days data
            const last7Days = [];
            const revenueData = [];
            const ordersData = [];
            
            for (let i = 6; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                const dateStr = date.toDateString();
                last7Days.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                
                const dayOrders = orders.filter(o => new Date(o.created_at).toDateString() === dateStr);
                const dayRevenue = dayOrders.reduce((sum, o) => sum + parseFloat(o.total_amount || 0), 0);
                
                revenueData.push(dayRevenue);
                ordersData.push(dayOrders.length);
            }
            
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            if (revenueChart) revenueChart.destroy();
            revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: last7Days,
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: revenueData,
                        borderColor: '#C6A75E',
                        backgroundColor: 'rgba(198, 167, 94, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
            
            // Orders Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            if (ordersChart) ordersChart.destroy();
            ordersChart = new Chart(ordersCtx, {
                type: 'bar',
                data: {
                    labels: last7Days,
                    datasets: [{
                        label: 'Orders',
                        data: ordersData,
                        backgroundColor: '#10b981'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }
        
        async function loadTopProducts(token) {
            try {
                const response = await fetch('http://localhost:8000/api/admin/analytics/top-products', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await response.json();
                
                const tbody = document.getElementById('topProducts');
                if (data.products && data.products.length > 0) {
                    tbody.innerHTML = data.products.slice(0, 5).map(p => `
                        <tr>
                            <td>${p.name}</td>
                            <td>${p.total_sold}</td>
                            <td>₹${p.total_revenue}</td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center">No data yet</td></tr>';
                }
            } catch (error) {
                console.error('Error loading top products:', error);
            }
        }
        
        async function init() {
            if (await checkAdmin()) {
                loadDashboard();
            }
        }
        
        init();
    </script>
</body>
</html>
