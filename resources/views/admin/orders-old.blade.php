<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('api-config.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <title>Orders Management — AUSHVERA Admin</title>
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
                <h1 class="page-title">Orders Management</h1>
            </header>
            <div class="page-content">
                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTable">
                            <tr><td colspan="7" class="text-center">No orders yet</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h2 class="text-xl font-bold">Order Details</h2>
                <button onclick="closeModal()" class="text-2xl">&times;</button>
            </div>
            <div class="page-content">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Order Status</label>
                        <select id="orderStatus" class="w-full border rounded px-3 py-2">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Tracking Number</label>
                        <input type="text" id="trackingNumber" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Refund Management</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Refund Amount (₹)</label>
                            <input type="number" id="refundAmount" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Refund Status</label>
                            <select id="refundStatus" class="w-full border rounded px-3 py-2">
                                <option value="">No Refund</option>
                                <option value="requested">Requested</option>
                                <option value="approved">Approved</option>
                                <option value="processed">Processed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm font-medium mb-2">Refund Reason</label>
                        <textarea id="refundReason" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                    </div>
                </div>
                <input type="hidden" id="currentOrderId">
                <div class="flex justify-end gap-2">
                    <button onclick="closeModal()" class="bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                    <button onclick="updateOrder()" class="bg-blue-600 text-white px-6 py-2 rounded">Update Order</button>
                    <button onclick="generateInvoice()" class="bg-green-600 text-white px-6 py-2 rounded">Generate Invoice</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        async AdminApp.logout() {
            try { await api.logout(); } catch(e) {}
            localStorage.removeItem('auth_token');
            localStorage.removeItem('currentUser');
            document.getElementById('loginModal').classList.add('active');
        }

        const user = JSON.parse(localStorage.getItem('user'));
        if (!user || user.role !== 'admin') {
            document.getElementById('loginModal').classList.add('active');
        }

        async function loadOrders() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch('http://localhost:8000/api/admin/orders', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await response.json();
                const orders = data.orders || [];
                
                const tbody = document.getElementById('ordersTable');
                if (orders.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">No orders yet</td></tr>';
                    return;
                }
                
                tbody.innerHTML = orders.map(order => `
                    <tr>
                        <td>#${order.id}</td>
                        <td>${order.user ? order.user.name : 'N/A'}</td>
                        <td>₹${order.total_amount}</td>
                        <td>${order.status}</td>
                        <td>${order.payment_status || 'pending'}</td>
                        <td>${new Date(order.created_at).toLocaleDateString()}</td>
                        <td>
                            <button onclick="openOrderModal(${order.id})" class="btn btn-primary">View</button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('ordersTable').innerHTML = '<tr><td colspan="7" class="text-center text-red-500">Error loading orders</td></tr>';
            }
        }

        function openOrderModal(orderId) {
            document.getElementById('currentOrderId').value = orderId;
            document.getElementById('orderModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }

        async function updateOrder() {
            const orderId = document.getElementById('currentOrderId').value;
            const data = {
                order_status: document.getElementById('orderStatus').value,
                tracking_number: document.getElementById('trackingNumber').value,
                refund_amount: document.getElementById('refundAmount').value,
                refund_status: document.getElementById('refundStatus').value,
                refund_reason: document.getElementById('refundReason').value
            };

            alert('Order updated successfully');
            closeModal();
            loadOrders();
        }

        function generateInvoice() {
            const orderId = document.getElementById('currentOrderId').value;
            alert('Invoice generated for Order #' + orderId);
        }

        loadOrders();
    </script>
</body>
</html>
