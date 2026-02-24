@extends('layouts.admin')
@section('title', 'Inventory')
@section('page-title', 'Inventory Management')

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Current Stock</th>
                <th>Update Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="inventoryTable">
            <tr><td colspan="5" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
async function loadInventory() {
    try {
        const response = await api.getProducts();
        const products = response.data || [];
        const tbody = document.getElementById('inventoryTable');
        
        if (products.length > 0) {
            tbody.innerHTML = products.map(p => `
                <tr>
                    <td>${p.id}</td>
                    <td>${p.name}</td>
                    <td><span class="badge ${p.stock < 10 ? 'badge-cancelled' : 'badge-delivered'}">${p.stock || 0}</span></td>
                    <td><input type="number" id="stock-${p.id}" value="${p.stock || 0}" min="0" style="width:100px;padding:0.5rem;border:1px solid #dee2e6;border-radius:4px;"></td>
                    <td>
                        <button class="btn btn-primary" onclick="updateStock(${p.id})">Update</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No products found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading inventory:', error);
        document.getElementById('inventoryTable').innerHTML = '<tr><td colspan="5" class="text-center text-red-500">Error loading inventory</td></tr>';
    }
}

async function updateStock(productId) {
    const newStock = document.getElementById(`stock-${productId}`).value;
    
    try {
        const token = api.getToken();
        const response = await fetch(`{{ url('/api/admin/products') }}/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ stock: parseInt(newStock) })
        });
        
        if (response.ok) {
            alert('Stock updated successfully');
            loadInventory();
        } else {
            alert('Failed to update stock');
        }
    } catch (error) {
        alert('Error updating stock');
        console.error(error);
    }
}

loadInventory();
</script>
@endpush
