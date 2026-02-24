@extends('layouts.admin')
@section('title', 'Coupons')
@section('page-title', 'Coupon Management')

@section('header-actions')
<button class="bg-green-600" onclick="openAddModal()">+ Add Coupon</button>
@endsection

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Discount</th>
                <th>Type</th>
                <th>Expires</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="couponsTable">
            <tr><td colspan="6" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>

<div id="couponModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-xl w-full mx-4">
        <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h2 class="text-xl font-bold">Add Coupon</h2>
            <button onclick="closeModal()" class="text-2xl">&times;</button>
        </div>
        <form id="couponForm" class="p-6">
            <div class="form-group">
                <label>Coupon Code</label>
                <input type="text" id="couponCode" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label>Discount Value</label>
                    <input type="number" id="couponDiscount" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select id="couponType">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Expiry Date</label>
                <input type="date" id="couponExpiry">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal()" class="btn bg-gray-500 text-white">Cancel</button>
                <button type="submit" class="btn bg-blue-600 text-white">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function loadCoupons() {
    try {
        const token = api.getToken();
        const response = await fetch('{{ url("/api/admin/coupons") }}', {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        const data = await response.json();
        const coupons = data.coupons || data.data || [];
        const tbody = document.getElementById('couponsTable');
        
        if (coupons.length > 0) {
            tbody.innerHTML = coupons.map(c => `
                <tr>
                    <td><strong>${c.code}</strong></td>
                    <td>${c.value}${c.type === 'percentage' ? '%' : '₹'}</td>
                    <td>${c.type}</td>
                    <td>${c.valid_until ? new Date(c.valid_until).toLocaleDateString() : 'No expiry'}</td>
                    <td><span class="badge badge-${c.is_active ? 'delivered' : 'cancelled'}">${c.is_active ? 'Active' : 'Inactive'}</span></td>
                    <td>
                        <button class="btn ${c.is_active ? 'bg-gray-500' : 'btn-success'}" onclick="toggleCoupon(${c.id}, ${c.is_active})">${c.is_active ? 'Deactivate' : 'Activate'}</button>
                        <button class="btn btn-danger" onclick="deleteCoupon(${c.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No coupons found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading coupons:', error);
        document.getElementById('couponsTable').innerHTML = '<tr><td colspan="6" class="text-center">No coupons found</td></tr>';
    }
}

function openAddModal() {
    document.getElementById('couponModal').classList.remove('hidden');
    document.getElementById('couponModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('couponModal').classList.add('hidden');
    document.getElementById('couponModal').classList.remove('flex');
}

document.getElementById('couponForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = {
        code: document.getElementById('couponCode').value,
        type: document.getElementById('couponType').value,
        value: document.getElementById('couponDiscount').value,
        valid_until: document.getElementById('couponExpiry').value || null,
        is_active: true
    };
    
    try {
        const token = api.getToken();
        const response = await fetch('{{ url("/api/admin/coupons") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(data)
        });
        
        if (response.ok) {
            alert('Coupon added successfully');
            closeModal();
            loadCoupons();
        } else {
            alert('Failed to add coupon');
        }
    } catch (error) {
        alert('Error adding coupon');
    }
});

async function deleteCoupon(id) {
    if (!confirm('Delete this coupon?')) return;
    
    try {
        const token = api.getToken();
        await fetch(`{{ url("/api/admin/coupons") }}/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}` }
        });
        alert('Coupon deleted');
        loadCoupons();
    } catch (error) {
        alert('Error deleting coupon');
    }
}

async function toggleCoupon(id, currentStatus) {
    try {
        const token = api.getToken();
        await fetch(`{{ url("/api/admin/coupons") }}/${id}/toggle`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({ is_active: !currentStatus })
        });
        alert('Coupon status updated');
        loadCoupons();
    } catch (error) {
        alert('Error updating coupon');
    }
}

loadCoupons();
</script>
@endpush
