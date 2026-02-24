<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — AUSHVERA</title>
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('api-config.js') }}"></script>
</head>
<body>
    <nav class="nav-inner">
        <div class="nav-container">
            <div class="nav-left">
                <ul class="nav-links">
                    <li><a href="{{ url('/') }}">HOME</a></li>
                    <li><a href="{{ url('/admin') }}" class="active">ADMIN</a></li>
                </ul>
            </div>
            <a class="nav-center" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="AUSHVERA Logo" class="nav-logo">
                <span>AUSHVERA</span>
            </a>
            <div class="nav-right">
                <ul class="nav-links">
                    <li><a href="#" id="logoutBtn">LOGOUT</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <span class="admin-label">ADMIN PANEL</span>
            </div>
            <nav class="sidebar-nav">
                <a href="#dashboard" class="nav-item active" data-section="dashboard">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="#products" class="nav-item" data-section="products">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 7h-9M14 17H5M6 3v4M10 17v4M12 3v14"/>
                    </svg>
                    <span class="nav-text">Products</span>
                </a>
                <a href="#orders" class="nav-item" data-section="orders">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                    </svg>
                    <span class="nav-text">Orders</span>
                </a>
                <a href="#users" class="nav-item" data-section="users">
                    <span class="nav-indicator"></span>
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span class="nav-text">Users</span>
                </a>
            </nav>
        </aside>

        <main class="admin-main">
            <section id="dashboard-section" class="admin-section active">
                <div class="content-header">
                    <h1>Dashboard</h1>
                    <p class="content-subtitle">Overview of your store performance</p>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Total Orders</span>
                            <span class="stat-value" id="totalOrders">0</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 7h-9M14 17H5M6 3v4M10 17v4M12 3v14"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Total Products</span>
                            <span class="stat-value" id="totalProducts">0</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Total Users</span>
                            <span class="stat-value" id="totalUsers">0</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Revenue</span>
                            <span class="stat-value" id="totalRevenue">₹0</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="products-section" class="admin-section">
                <div class="content-header">
                    <h1>Products</h1>
                    <button class="btn-primary" onclick="showAddProduct()">Add Product</button>
                </div>
                <div class="data-table">
                    <table id="productsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <section id="orders-section" class="admin-section">
                <div class="content-header">
                    <h1>Orders</h1>
                </div>
                <div class="data-table">
                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>

            <section id="users-section" class="admin-section">
                <div class="content-header">
                    <h1>Users</h1>
                </div>
                <div class="data-table">
                    <table id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeProductModal()">&times;</span>
            <h2 id="modalTitle">Add Product</h2>
            <form id="productForm">
                <input type="hidden" id="productId">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" id="productName" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="productDescription" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" id="productPrice" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" id="productStock" required>
                </div>
                <button type="submit" class="btn-primary">Save Product</button>
            </form>
        </div>
    </div>

    <script>
        let currentSection = 'dashboard';

        // Check admin auth
        async function checkAdminAuth() {
            const token = api.getToken();
            if (!token) {
                window.location.href = '{{ url("/profile") }}';
                return;
            }
            try {
                const response = await api.getUser();
                if (response.data.role !== 'admin') {
                    window.location.href = '{{ url("/") }}';
                }
            } catch (error) {
                window.location.href = '{{ url("/profile") }}';
            }
        }

        // Navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const section = item.dataset.section;
                switchSection(section);
            });
        });

        function switchSection(section) {
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));
            document.querySelector(`[data-section="${section}"]`).classList.add('active');
            document.getElementById(`${section}-section`).classList.add('active');
            currentSection = section;
            loadSectionData(section);
        }

        async function loadSectionData(section) {
            switch(section) {
                case 'dashboard': await loadDashboard(); break;
                case 'products': await loadProducts(); break;
                case 'orders': await loadOrders(); break;
                case 'users': await loadUsers(); break;
            }
        }

        async function loadDashboard() {
            try {
                const [products, orders, users] = await Promise.all([
                    api.getProducts(),
                    fetch(`${API_BASE_URL}/admin/orders`, {
                        headers: { 'Authorization': `Bearer ${api.getToken()}` }
                    }).then(r => r.json()).catch(() => ({data: []})),
                    fetch(`${API_BASE_URL}/admin/users`, {
                        headers: { 'Authorization': `Bearer ${api.getToken()}` }
                    }).then(r => r.json()).catch(() => ({data: []}))
                ]);

                document.getElementById('totalProducts').textContent = products.data?.length || 0;
                document.getElementById('totalOrders').textContent = orders.data?.length || 0;
                document.getElementById('totalUsers').textContent = users.data?.length || 0;
                
                const revenue = orders.data?.reduce((sum, order) => sum + parseFloat(order.total || 0), 0) || 0;
                document.getElementById('totalRevenue').textContent = `₹${revenue.toFixed(2)}`;
            } catch (error) {
                console.error('Dashboard load error:', error);
            }
        }

        async function loadProducts() {
            try {
                const response = await api.getProducts();
                const tbody = document.querySelector('#productsTable tbody');
                tbody.innerHTML = response.data.map(p => `
                    <tr>
                        <td>${p.id}</td>
                        <td>${p.name}</td>
                        <td>₹${p.price}</td>
                        <td>${p.stock_quantity || 0}</td>
                        <td>
                            <button class="btn-edit" onclick="editProduct(${p.id})">Edit</button>
                            <button class="btn-delete" onclick="deleteProduct(${p.id})">Delete</button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Products load error:', error);
            }
        }

        async function loadOrders() {
            try {
                const response = await fetch(`${API_BASE_URL}/admin/orders`, {
                    headers: { 'Authorization': `Bearer ${api.getToken()}` }
                }).then(r => r.json());
                
                const tbody = document.querySelector('#ordersTable tbody');
                tbody.innerHTML = response.data?.map(o => `
                    <tr>
                        <td>#${o.id}</td>
                        <td>${o.user?.name || 'N/A'}</td>
                        <td>₹${o.total}</td>
                        <td><span class="status-badge status-${o.status}">${o.status}</span></td>
                        <td>${new Date(o.created_at).toLocaleDateString()}</td>
                    </tr>
                `).join('') || '<tr><td colspan="5">No orders found</td></tr>';
            } catch (error) {
                document.querySelector('#ordersTable tbody').innerHTML = '<tr><td colspan="5">No orders found</td></tr>';
            }
        }

        async function loadUsers() {
            try {
                const response = await fetch(`${API_BASE_URL}/admin/users`, {
                    headers: { 'Authorization': `Bearer ${api.getToken()}` }
                }).then(r => r.json());
                
                const tbody = document.querySelector('#usersTable tbody');
                tbody.innerHTML = response.data?.map(u => `
                    <tr>
                        <td>${u.id}</td>
                        <td>${u.name}</td>
                        <td>${u.email}</td>
                        <td><span class="role-badge role-${u.role}">${u.role}</span></td>
                        <td>${new Date(u.created_at).toLocaleDateString()}</td>
                    </tr>
                `).join('') || '<tr><td colspan="5">No users found</td></tr>';
            } catch (error) {
                document.querySelector('#usersTable tbody').innerHTML = '<tr><td colspan="5">No users found</td></tr>';
            }
        }

        function showAddProduct() {
            document.getElementById('modalTitle').textContent = 'Add Product';
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('productModal').style.display = 'flex';
        }

        async function editProduct(id) {
            try {
                const response = await api.getProduct(id);
                const product = response.data;
                document.getElementById('modalTitle').textContent = 'Edit Product';
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.name;
                document.getElementById('productDescription').value = product.description;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productStock').value = product.stock_quantity || 0;
                document.getElementById('productModal').style.display = 'flex';
            } catch (error) {
                alert('Error loading product');
            }
        }

        async function deleteProduct(id) {
            if (!confirm('Delete this product?')) return;
            try {
                await fetch(`${API_BASE_URL}/products/${id}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': `Bearer ${api.getToken()}` }
                });
                loadProducts();
            } catch (error) {
                alert('Error deleting product');
            }
        }

        function closeProductModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        document.getElementById('productForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('productId').value;
            const data = {
                name: document.getElementById('productName').value,
                description: document.getElementById('productDescription').value,
                price: document.getElementById('productPrice').value,
                stock_quantity: document.getElementById('productStock').value
            };

            try {
                if (id) {
                    await fetch(`${API_BASE_URL}/products/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${api.getToken()}`
                        },
                        body: JSON.stringify(data)
                    });
                } else {
                    await fetch(`${API_BASE_URL}/products`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${api.getToken()}`
                        },
                        body: JSON.stringify(data)
                    });
                }
                closeProductModal();
                loadProducts();
            } catch (error) {
                alert('Error saving product');
            }
        });

        document.getElementById('logoutBtn').addEventListener('click', async (e) => {
            e.preventDefault();
            try {
                await api.logout();
            } catch (error) {}
            localStorage.removeItem('token');
            window.location.href = '{{ url("/") }}';
        });

        checkAdminAuth();
        loadDashboard();
    </script>
</body>
</html>
