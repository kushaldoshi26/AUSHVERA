@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'Orders Management')

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="ordersTable">
            <tr><td colspan="7" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>

<!-- Order Details Modal -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h2 class="text-xl font-bold">Order Details</h2>
            <button onclick="closeModal()" class="text-2xl hover:text-gray-300">&times;</button>
        </div>
        <div class="p-6">
            <div id="orderDetails"></div>
            
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label>Order Status</label>
                    <select id="orderStatus" class="w-full">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Payment Status</label>
                    <select id="paymentStatus" class="w-full">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end gap-2 mt-6">
                <button onclick="closeModal()" class="btn bg-gray-500 text-white hover:bg-gray-600">Close</button>
                <button onclick="updateOrderStatus()" class="btn bg-blue-600 text-white hover:bg-blue-700">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let orders = [];
let currentOrderId = null;

async function loadOrders() {
    try {
        const token = api.getToken();
        const response = await fetch('{{ url("/api/admin/orders") }}', {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        const data = await response.json();
        orders = data.orders || data.data || [];
        const tbody = document.getElementById('ordersTable');
        
        if (orders.length > 0) {
            tbody.innerHTML = orders.map(o => `
                <tr>
                    <td>#${o.id}</td>
                    <td>${o.user?.name || 'N/A'}</td>
                    <td>₹${o.total_amount || o.total || 0}</td>
                    <td><span class="badge badge-${o.status}">${o.status}</span></td>
                    <td><span class="badge badge-${o.payment_status || 'pending'}">${o.payment_status || 'pending'}</span></td>
                    <td>${new Date(o.created_at).toLocaleDateString()}</td>
                    <td>
                        <button class="btn btn-primary" onclick="viewOrder(${o.id})">View</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No orders found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading orders:', error);
        document.getElementById('ordersTable').innerHTML = '<tr><td colspan="7" class="text-center">Error loading orders</td></tr>';
    }
}

async function viewOrder(id) {
    try {
        currentOrderId = id;
        const token = api.getToken();
        const response = await fetch(`{{ url("/api/admin/orders") }}/${id}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        const data = await response.json();
        const order = data.order || data.data;
        
        let itemsHtml = '';
        if (order.items && order.items.length > 0) {
            itemsHtml = `
                <h3 class="font-bold mb-2 mt-4">Order Items:</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${order.items.map(item => `
                            <tr>
                                <td>${item.product?.name || 'N/A'}</td>
                                <td>${item.quantity}</td>
                                <td>₹${item.price}</td>
                                <td>₹${item.quantity * item.price}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        }
        
        document.getElementById('orderDetails').innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <div><strong>Order ID:</strong> #${order.id}</div>
                <div><strong>Date:</strong> ${new Date(order.created_at).toLocaleString()}</div>
                <div><strong>Customer:</strong> ${order.user?.name || 'N/A'}</div>
                <div><strong>Email:</strong> ${order.user?.email || 'N/A'}</div>
                <div><strong>Phone:</strong> ${order.user?.phone || 'N/A'}</div>
                <div><strong>Total Amount:</strong> ₹${order.total_amount || order.total}</div>
            </div>
            ${itemsHtml}
        `;
        
        document.getElementById('orderStatus').value = order.status;
        document.getElementById('paymentStatus').value = order.payment_status || 'pending';
        
        document.getElementById('orderModal').classList.remove('hidden');
        document.getElementById('orderModal').classList.add('flex');
    } catch (error) {
        alert('Error loading order details');
        console.error(error);
    }
}

async function updateOrderStatus() {
    if (!currentOrderId) return;
    
    const newStatus = document.getElementById('orderStatus').value;
    const paymentStatus = document.getElementById('paymentStatus').value;
    
    try {
        const token = api.getToken();
        const response = await fetch(`{{ url("/api/admin/orders") }}/${currentOrderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus,
                payment_status: paymentStatus
            })
        });
        
        if (response.ok) {
            alert('Order status updated successfully');
            closeModal();
            loadOrders();
        } else {
            const error = await response.json();
            alert('Failed to update order: ' + (error.message || 'Unknown error'));
        }
    } catch (error) {
        alert('Error updating order status');
        console.error(error);
    }
}

function closeModal() {
    document.getElementById('orderModal').classList.add('hidden');
    document.getElementById('orderModal').classList.remove('flex');
    currentOrderId = null;
}

loadOrders();
</script>
@endpush
