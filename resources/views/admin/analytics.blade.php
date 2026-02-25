@extends('layouts.admin')
@section('title', 'Analytics')
@section('page-title', 'Analytics & Reports')

@section('content')
<div class="admin-card" style="margin-bottom:24px;">
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;">
        <button onclick="loadSalesReport('day')" class="btn btn-primary" id="btn-day">Today</button>
        <button onclick="loadSalesReport('week')" class="btn btn-primary" id="btn-week">Last 7 Days</button>
        <button onclick="loadSalesReport('month')" class="btn btn-primary" id="btn-month">This Month</button>
        <button onclick="loadSalesReport('year')" class="btn btn-primary" id="btn-year">This Year</button>
        <div style="margin-left:auto;display:flex;gap:8px;">
            <a href="{{ url('/api/admin/export/orders') }}" class="btn" style="background:#059669;color:white;">📥 Export Orders</a>
            <a href="{{ url('/api/admin/export/users') }}" class="btn" style="background:#7c3aed;color:white;">📥 Export Users</a>
            <a href="{{ url('/api/admin/export/products') }}" class="btn" style="background:#b45309;color:white;">📥 Export Products</a>
        </div>
    </div>

    <h2 style="font-size:1rem;font-weight:600;margin-bottom:12px;">Sales Report</h2>
    <div id="salesTable" style="min-height:80px;">
        <p style="color:#6b7280;">Loading sales data...</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <div class="admin-card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:12px;">🏆 Top Products</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Units Sold</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody id="topProductsTable">
                <tr><td colspan="4" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="admin-card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:12px;">👥 Top Customers</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                </tr>
            </thead>
            <tbody id="topCustomersTable">
                <tr><td colspan="4" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const token = api.getToken();
const headers = { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' };

async function loadSalesReport(period = 'month') {
    // Highlight active button
    ['day', 'week', 'month', 'year'].forEach(p => {
        document.getElementById('btn-' + p).style.opacity = p === period ? '1' : '0.5';
    });

    try {
        const res = await fetch(`{{ url('/api/admin/analytics/sales-report') }}?period=${period}`, { headers });
        const data = await res.json();
        const rows = data.sales_data || [];
        const container = document.getElementById('salesTable');

        if (!rows.length) {
            container.innerHTML = '<p style="color:#6b7280;">No sales data for this period.</p>';
            return;
        }

        container.innerHTML = `
            <table class="admin-table">
                <thead><tr><th>Period</th><th>Orders</th><th>Revenue (₹)</th></tr></thead>
                <tbody>
                    ${rows.map(r => `
                        <tr>
                            <td>${r.period}</td>
                            <td>${r.orders}</td>
                            <td>₹${parseFloat(r.revenue || 0).toFixed(2)}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    } catch (e) {
        document.getElementById('salesTable').innerHTML = '<p style="color:#ef4444;">Failed to load sales data.</p>';
    }
}

async function loadTopProducts() {
    try {
        const res = await fetch(`{{ url('/api/admin/analytics/top-products') }}`, { headers });
        const data = await res.json();
        const rows = data.top_products || [];
        const tbody = document.getElementById('topProductsTable');

        tbody.innerHTML = rows.length
            ? rows.map((p, i) => `
                <tr>
                    <td>${i + 1}</td>
                    <td>${p.name}</td>
                    <td>${p.total_sold}</td>
                    <td>₹${parseFloat(p.total_revenue || 0).toFixed(2)}</td>
                </tr>
            `).join('')
            : '<tr><td colspan="4" class="text-center">No data yet</td></tr>';
    } catch (e) {
        document.getElementById('topProductsTable').innerHTML = '<tr><td colspan="4" class="text-center">Error loading</td></tr>';
    }
}

async function loadTopCustomers() {
    try {
        const res = await fetch(`{{ url('/api/admin/analytics/top-customers') }}`, { headers });
        const data = await res.json();
        const rows = data.top_customers || [];
        const tbody = document.getElementById('topCustomersTable');

        tbody.innerHTML = rows.length
            ? rows.map((c, i) => `
                <tr>
                    <td>${i + 1}</td>
                    <td>${c.user?.name || 'Unknown'}<br><small style="color:#6b7280;">${c.user?.email || ''}</small></td>
                    <td>${c.order_count}</td>
                    <td>₹${parseFloat(c.total_spent || 0).toFixed(2)}</td>
                </tr>
            `).join('')
            : '<tr><td colspan="4" class="text-center">No data yet</td></tr>';
    } catch (e) {
        document.getElementById('topCustomersTable').innerHTML = '<tr><td colspan="4" class="text-center">Error loading</td></tr>';
    }
}

loadSalesReport('month');
loadTopProducts();
loadTopCustomers();
</script>
@endpush
