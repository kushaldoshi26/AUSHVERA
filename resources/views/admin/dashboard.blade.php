@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-content">
            <span class="stat-label">Total Products</span>
            <span class="stat-value" id="totalProducts">0</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🛒</div>
        <div class="stat-content">
            <span class="stat-label">Total Orders</span>
            <span class="stat-value" id="totalOrders">0</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
            <span class="stat-label">Total Users</span>
            <span class="stat-value" id="totalUsers">0</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-content">
            <span class="stat-label">Revenue</span>
            <span class="stat-value" id="totalRevenue">₹0</span>
        </div>
    </div>
</div>

<div class="admin-card mt-30">
    <h2>Recent Orders</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="recentOrders">
            <tr><td colspan="5" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
async function loadDashboard() {
    try {
        const [products, orders, users] = await Promise.all([
            api.getProducts(),
            fetch('{{ url("/api/admin/orders") }}', {
                headers: { 'Authorization': `Bearer ${api.getToken()}` }
            }).then(r => r.json()).catch(() => ({data: []})),
            fetch('{{ url("/api/admin/users") }}', {
                headers: { 'Authorization': `Bearer ${api.getToken()}` }
            }).then(r => r.json()).catch(() => ({data: []}))
        ]);

        document.getElementById('totalProducts').textContent = products.data?.length || 0;
        document.getElementById('totalOrders').textContent = orders.data?.length || 0;
        document.getElementById('totalUsers').textContent = users.data?.length || 0;
        
        const revenue = orders.data?.reduce((sum, order) => sum + parseFloat(order.total_amount || 0), 0) || 0;
        document.getElementById('totalRevenue').textContent = `₹${revenue.toFixed(2)}`;
        
        const tbody = document.getElementById('recentOrders');
        if (orders.data?.length) {
            tbody.innerHTML = orders.data.slice(0, 5).map(o => `
                <tr>
                    <td>#${o.id}</td>
                    <td>${o.user?.name || 'N/A'}</td>
                    <td>₹${o.total_amount}</td>
                    <td><span class="badge badge-${o.status}">${o.status}</span></td>
                    <td>${new Date(o.created_at).toLocaleDateString()}</td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No orders yet</td></tr>';
        }
    } catch (error) {
        console.error('Dashboard load error:', error);
    }
}

loadDashboard();
</script>
@endpush
