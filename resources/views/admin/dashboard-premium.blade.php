<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AUSHVERA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="admin-global.css">
    
    <style>
        .submenu { display: none; padding-left: 1rem; }
        .submenu.open { display: block; }
        .rotate-90 { transform: rotate(90deg); }
    </style>
</head>
<body style="background: #F7F4EE;">
    <div class="flex h-screen overflow-hidden">
        <!-- Premium Sidebar -->
        <aside class="w-64 text-white overflow-y-auto fixed h-screen" style="background: #0B1C2D; border-right: 1px solid rgba(198, 167, 94, 0.2);">
            <div class="p-4" style="border-bottom: 1px solid rgba(198, 167, 94, 0.2);">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="AUSHVERA" class="w-10 h-10">
                    <div>
                        <div style="color: #C6A75E; font-weight: bold; font-size: 1.125rem; letter-spacing: 0.1em;">AUSHVERA</div>
                        <div class="text-xs" style="color: #9CA3AF;">Admin Panel</div>
                    </div>
                </div>
            </div>
            
            <nav class="p-4">
                <!-- Dashboard -->
                <a href="admin-dashboard-premium.html" class="block py-2 px-4 rounded bg-[#C6A75E]/10 mb-2">
                    📊 Dashboard
                </a>

                <!-- Products -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>🛍️ Products</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/products') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">All Products</a></li>
                        <li><a href="{{ url('/admin/categories') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Categories</a></li>
                    </ul>
                </div>

                <!-- Orders -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📦 Orders</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/orders') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">All Orders</a></li>
                        <li><a href="admin-orders.html?status=pending" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Pending Orders</a></li>
                        <li><a href="admin-orders.html?status=completed" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Completed</a></li>
                    </ul>
                </div>

                <!-- Users -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>👥 Users</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/users') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">All Users</a></li>
                    </ul>
                </div>

                <!-- Inventory -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📦 Inventory</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/inventory') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Stock Management</a></li>
                    </ul>
                </div>

                <!-- Marketing -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📢 Marketing</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/banners') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Banners</a></li>
                        <li><a href="{{ url('/admin/coupons') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Coupons</a></li>
                    </ul>
                </div>

                <!-- Reports -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📈 Reports</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/analytics') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Analytics</a></li>
                        <li><a href="{{ url('/admin/analytics') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Sales Report</a></li>
                    </ul>
                </div>

                <!-- Admin Management -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>👑 Admin Management</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/management') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">All Admins</a></li>
                        <li><a href="admin-register.html" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">➕ Create Admin</a></li>
                        <li><a href="{{ url('/admin/activity-logs') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Activity Logs</a></li>
                    </ul>
                </div>

                <!-- Settings -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>⚙️ Settings</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/reviews') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Reviews</a></li>
                        <li><a href="{{ url('/admin/pricing') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Pricing</a></li>
                    </ul>
                </div>

                <hr class="my-4 border-[#C6A75E]/20">

                <a href="{{ url('/') }}" class="block py-2 px-4 rounded hover:bg-[#C6A75E]/10 mb-2">
                    🔙 Back to Site
                </a>
                <button onclick="logout()" class="w-full text-left block py-2 px-4 rounded hover:bg-red-800 text-red-400">
                    🚪 Logout
                </button>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto ml-64" style="background: #F7F4EE;">
            <header class="p-6 sticky top-0 z-10" style="background: #0B1C2D; border-bottom: 1px solid rgba(198, 167, 94, 0.2);">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold" style="color: #C6A75E;">Dashboard</h1>
                        <p class="text-sm mt-1" style="color: #9CA3AF;">Welcome back, <span id="adminName" style="color: #C6A75E;"></span></p>
                    </div>
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notificationBtn" class="relative p-2 text-gray-600 hover:text-gray-900">
                            🔔
                            <span id="notificationBadge" class="hidden absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                        </button>
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border z-50">
                            <div class="p-4 border-b">
                                <h3 class="font-bold">Notifications</h3>
                            </div>
                            <div id="notificationList" class="max-h-96 overflow-y-auto"></div>
                        </div>
                    </div>
                    <span id="adminName" class="text-sm text-gray-600"></span>
                    <span id="adminRoleTitle" class="text-sm font-semibold px-4 py-2 rounded-full" style="background: rgba(198, 167, 94, 0.15); color: #C6A75E; border: 1px solid rgba(198, 167, 94, 0.3);"></span><span id="adminRole" style="display:none;" class="text-xs bg-[#C6A75E]/20 text-[#C6A75E] px-2 py-1 rounded"></span>
                </div>
            </header>

            <div class="p-6">
                <!-- Alert Cards -->
                <div id="alerts" class="mb-6"></div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-4 gap-6 mb-6">
                    <div class="bg-gradient-to-br from-[#C6A75E] to-[#B8964C] text-white p-6 rounded-lg shadow">
                        <h3 class="text-sm mb-2 opacity-90">Today's Orders</h3>
                        <p class="text-3xl font-bold" id="todayOrders">0</p>
                        <p class="text-xs mt-2 opacity-75">↑ Live data</p>
                    </div>
                    <div class="bg-gradient-to-br from-[#C6A75E] to-[#B8964C] text-white p-6 rounded-lg shadow">
                        <h3 class="text-sm mb-2 opacity-90">Today's Revenue</h3>
                        <p class="text-3xl font-bold" id="todayRevenue">₹0</p>
                        <p class="text-xs mt-2 opacity-75">↑ Today</p>
                    </div>
                    <div class="bg-gradient-to-br from-[#C6A75E] to-[#B8964C] text-white p-6 rounded-lg shadow">
                        <h3 class="text-sm mb-2 opacity-90">Total Revenue</h3>
                        <p class="text-3xl font-bold" id="totalRevenue">₹0</p>
                        <p class="text-xs mt-2 opacity-75">All time</p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-6 rounded-lg shadow">
                        <h3 class="text-sm mb-2 opacity-90">Pending Orders</h3>
                        <p class="text-3xl font-bold" id="pendingOrders">0</p>
                        <p class="text-xs mt-2 opacity-75">⚠ Needs attention</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-4 gap-4">
                        <a href="{{ url('/admin/products') }}" class="bg-[#C6A75E] text-white p-4 rounded-lg text-center hover:bg-[#B8964C]">
                            <div class="text-2xl mb-2">➕</div>
                            <div>Add Product</div>
                        </a>
                        <a href="admin-orders.html?status=pending" class="bg-orange-600 text-white p-4 rounded-lg text-center hover:bg-orange-700">
                            <div class="text-2xl mb-2">📦</div>
                            <div>Pending Orders</div>
                        </a>
                        <a href="admin-register.html" class="bg-purple-600 text-white p-4 rounded-lg text-center hover:bg-purple-700">
                            <div class="text-2xl mb-2">👤</div>
                            <div>Create Admin</div>
                        </a>
                        <a href="{{ url('/admin/inventory') }}" class="bg-green-600 text-white p-4 rounded-lg text-center hover:bg-green-700">
                            <div class="text-2xl mb-2">📊</div>
                            <div>Inventory</div>
                        </a>
                    </div>
                </div>

                <!-- Revenue Chart & Top Products -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4">Monthly Revenue (Last 6 Months)</h2>
                        <canvas id="revenueChart" height="200"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4">Top Selling Products</h2>
                        <div id="topProducts">Loading...</div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
                    <div id="recentOrders">Loading...</div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user'));

        if (!user || user.role !== 'admin') {
            window.location.href = '{{ url("/profile") }}';
        }

        // Display admin info
        document.getElementById('adminName').textContent = user.name;
        const roleMap = {'super_admin': 'SUPER ADMIN', 'manager': 'MANAGER', 'support': 'SUPPORT'};
        document.getElementById('adminRoleTitle').textContent = roleMap[user.admin_role] || 'ADMIN';

        // Sidebar dropdown toggle
        document.querySelectorAll('.sidebar-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const submenu = this.nextElementSibling;
                const arrow = this.querySelector('.arrow');
                submenu.classList.toggle('open');
                arrow.classList.toggle('rotate-90');
            });
        });

        // Load dashboard data
        async function loadDashboard() {
            try {
                const res = await fetch(`${API_URL}/admin/dashboard`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await res.json();
                
                document.getElementById('todayOrders').textContent = data.today_orders || 0;
                document.getElementById('todayRevenue').textContent = '₹' + (data.today_revenue || 0);
                document.getElementById('totalRevenue').textContent = '₹' + (data.total_revenue || 0);
                document.getElementById('pendingOrders').textContent = data.pending_orders || 0;

                // Show inventory alerts
                const notifications = [];
                if (data.pending_orders > 0) {
                    notifications.push({
                        type: 'warning',
                        message: `${data.pending_orders} pending orders need attention`,
                        link: 'admin-orders.html?status=pending'
                    });
                }
                if (data.low_stock_products > 0) {
                    notifications.push({
                        type: 'warning',
                        message: `⚠️ ${data.low_stock_products} products have low stock (<10 units)`,
                        link: 'admin-inventory.html'
                    });
                }
                if (data.out_of_stock_products > 0) {
                    notifications.push({
                        type: 'danger',
                        message: `🔴 ${data.out_of_stock_products} products are out of stock`,
                        link: 'admin-inventory.html'
                    });
                }

                if (notifications.length > 0) {
                    document.getElementById('notificationBadge').textContent = notifications.length;
                    document.getElementById('notificationBadge').classList.remove('hidden');
                    
                    document.getElementById('notificationList').innerHTML = notifications.map(n => `
                        <a href="${n.link}" class="block p-4 hover:bg-gray-50 border-b">
                            <div class="flex items-start">
                                <span class="text-2xl mr-3">${n.type === 'danger' ? '🔴' : '⚠️'}</span>
                                <div>
                                    <p class="text-sm font-medium">${n.message}</p>
                                    <p class="text-xs text-gray-500 mt-1">Click to view</p>
                                </div>
                            </div>
                        </a>
                    `).join('');
                }

                // Show alerts
                if (data.pending_orders > 0 || data.low_stock_products > 0) {
                    let alertHtml = '';
                    if (data.pending_orders > 0) {
                        alertHtml += `
                            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 rounded mb-4">
                                <p class="font-bold">⚠ Attention Required</p>
                                <p>You have ${data.pending_orders} pending orders waiting for confirmation.</p>
                            </div>
                        `;
                    }
                    if (data.low_stock_products > 0 || data.out_of_stock_products > 0) {
                        alertHtml += `
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                                <p class="font-bold">🚨 Inventory Alert</p>
                                <p>${data.low_stock_products} products with low stock, ${data.out_of_stock_products} out of stock.</p>
                            </div>
                        `;
                    }
                    document.getElementById('alerts').innerHTML = alertHtml;
                }

                // Render revenue chart
                if (data.monthly_revenue && data.monthly_revenue.length > 0) {
                    const months = data.monthly_revenue.map(m => m.month);
                    const revenues = data.monthly_revenue.map(m => m.revenue);
                    
                    const ctx = document.getElementById('revenueChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Revenue (₹)',
                                data: revenues,
                                borderColor: '#C6A75E',
                                backgroundColor: 'rgba(198, 167, 94, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                }
            } catch (err) {
                console.error('Error loading dashboard:', err);
            }

            // Load top products
            try {
                const res = await fetch(`${API_URL}/products`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const result = await res.json();
                const products = (result.data || result).slice(0, 5);
                
                if (products.length === 0) {
                    document.getElementById('topProducts').innerHTML = '<p class="text-gray-500">No products yet</p>';
                } else {
                    document.getElementById('topProducts').innerHTML = products.map((p, i) => `
                        <div class="flex items-center justify-between py-3 border-b">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl font-bold text-[#C6A75E]">${i + 1}</span>
                                <div>
                                    <p class="font-medium">${p.name}</p>
                                    <p class="text-sm text-gray-500">Stock: ${p.stock}</p>
                                </div>
                            </div>
                            <span class="font-bold text-[#C6A75E]">₹${p.price}</span>
                        </div>
                    `).join('');
                }
            } catch (err) {
                document.getElementById('topProducts').innerHTML = '<p class="text-red-500">Error loading products</p>';
            }

            // Load recent orders
            try {
                const res = await fetch(`${API_URL}/admin/orders?per_page=5`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await res.json();
                const orders = data.data || [];
                
                if (orders.length === 0) {
                    document.getElementById('recentOrders').innerHTML = '<p class="text-gray-500">No orders yet</p>';
                } else {
                    document.getElementById('recentOrders').innerHTML = orders.map(order => `
                        <div class="border-b py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium">Order #${order.id}</p>
                                <p class="text-sm text-gray-500">${order.user?.name || 'Guest'}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">₹${order.total_amount}</p>
                                <span class="text-xs px-2 py-1 rounded ${order.status === 'pending' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800'}">
                                    ${order.status}
                                </span>
                            </div>
                        </div>
                    `).join('');
                }
            } catch (err) {
                document.getElementById('recentOrders').innerHTML = '<p class="text-red-500">Error loading orders</p>';
            }
        }

        // Notification dropdown toggle
        document.getElementById('notificationBtn').addEventListener('click', () => {
            document.getElementById('notificationDropdown').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#notificationBtn') && !e.target.closest('#notificationDropdown')) {
                document.getElementById('notificationDropdown').classList.add('hidden');
            }
        });

        function logout() {
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('isLoggedIn');
            window.location.href = '{{ url("/profile") }}';
        }

        loadDashboard();
    </script>
</body>
</html>
