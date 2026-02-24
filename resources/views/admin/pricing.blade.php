@extends('layouts.admin')
@section('title', 'Pricing')
@section('page-title', 'Pricing Management')

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Current Price</th>
                <th>New Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="pricingTable">
            <tr><td colspan="5" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
async function loadPricing() {
    try {
        const response = await api.getProducts();
        const products = response.data || [];
        const tbody = document.getElementById('pricingTable');
        
        if (products.length > 0) {
            tbody.innerHTML = products.map(p => `
                <tr>
                    <td>${p.id}</td>
                    <td>${p.name}</td>
                    <td>₹${p.price}</td>
                    <td><input type="number" id="price-${p.id}" value="${p.price}" min="0" step="0.01" style="width:120px;padding:0.5rem;border:1px solid #dee2e6;border-radius:4px;"></td>
                    <td>
                        <button class="btn btn-primary" onclick="updatePrice(${p.id})">Update</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No products found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading pricing:', error);
        document.getElementById('pricingTable').innerHTML = '<tr><td colspan="5" class="text-center text-red-500">Error loading pricing</td></tr>';
    }
}

async function updatePrice(productId) {
    const newPrice = document.getElementById(`price-${productId}`).value;
    
    try {
        const token = api.getToken();
        const response = await fetch(`{{ url('/api/admin/products') }}/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ price: parseFloat(newPrice) })
        });
        
        if (response.ok) {
            alert('Price updated successfully');
            loadPricing();
        } else {
            alert('Failed to update price');
        }
    } catch (error) {
        alert('Error updating price');
        console.error(error);
    }
}

loadPricing();
</script>
@endpush
