@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Products Management')

@section('header-actions')
<button class="bg-green-600" onclick="openAddModal()">+ Add Product</button>
@endsection

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productsTable">
            <tr><td colspan="6" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>

<!-- Add/Edit Product Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h2 class="text-xl font-bold" id="modalTitle">Add Product</h2>
            <button onclick="closeModal()" class="text-2xl hover:text-gray-300">&times;</button>
        </div>
        <form id="productForm" class="p-6">
            <input type="hidden" id="productId">
            
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" id="productName" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea id="productDescription" rows="3" required></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" id="productPrice" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" id="productStock" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Category</label>
                <select id="productCategory">
                    <option value="Ayurvedic">Ayurvedic</option>
                    <option value="Tea">Tea</option>
                    <option value="Wellness">Wellness</option>
                    <option value="Herbal">Herbal</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Product Image URL</label>
                <input type="text" id="productImage" placeholder="https://example.com/image.jpg">
            </div>
            
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal()" class="btn bg-gray-500 text-white hover:bg-gray-600">Cancel</button>
                <button type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700">Save Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let products = [];

async function loadProducts() {
    try {
        const response = await api.getProducts();
        products = response.data || [];
        const tbody = document.getElementById('productsTable');
        
        if (products.length > 0) {
            tbody.innerHTML = products.map(p => `
                <tr>
                    <td>${p.id}</td>
                    <td><img src="${p.image || '{{ asset('assets/img/product.jpeg') }}'}" style="width:50px;height:50px;object-fit:cover;border-radius:4px;" onerror="this.src='{{ asset('assets/img/product.jpeg') }}'"></td>
                    <td>${p.name}</td>
                    <td>₹${p.price}</td>
                    <td>${p.stock || 0}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editProduct(${p.id})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteProduct(${p.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No products found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading products:', error);
        document.getElementById('productsTable').innerHTML = '<tr><td colspan="6" class="text-center text-red-500">Error loading products</td></tr>';
    }
}

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add Product';
    document.getElementById('productForm').reset();
    document.getElementById('productId').value = '';
    document.getElementById('productModal').classList.remove('hidden');
    document.getElementById('productModal').classList.add('flex');
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
        document.getElementById('productStock').value = product.stock || 0;
        document.getElementById('productCategory').value = product.category || 'Ayurvedic';
        document.getElementById('productImage').value = product.image || '';
        
        document.getElementById('productModal').classList.remove('hidden');
        document.getElementById('productModal').classList.add('flex');
    } catch (error) {
        alert('Error loading product details');
        console.error(error);
    }
}

async function deleteProduct(id) {
    if (!confirm('Are you sure you want to delete this product?')) return;
    
    try {
        const token = api.getToken();
        const response = await fetch(`{{ url('/api/admin/products') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            alert('Product deleted successfully');
            loadProducts();
        } else {
            const error = await response.json();
            alert('Failed to delete product: ' + (error.message || 'Unknown error'));
        }
    } catch (error) {
        alert('Error deleting product');
        console.error(error);
    }
}

function closeModal() {
    document.getElementById('productModal').classList.add('hidden');
    document.getElementById('productModal').classList.remove('flex');
}

document.getElementById('productForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const productId = document.getElementById('productId').value;
    const data = {
        name: document.getElementById('productName').value,
        description: document.getElementById('productDescription').value,
        price: parseFloat(document.getElementById('productPrice').value),
        stock: parseInt(document.getElementById('productStock').value),
        category: document.getElementById('productCategory').value,
        image: document.getElementById('productImage').value || null
    };
    
    try {
        const token = api.getToken();
        const url = productId 
            ? `{{ url('/api/admin/products') }}/${productId}`
            : '{{ url('/api/admin/products') }}';
        
        const response = await fetch(url, {
            method: productId ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        if (response.ok) {
            alert(productId ? 'Product updated successfully' : 'Product added successfully');
            closeModal();
            loadProducts();
        } else {
            const error = await response.json();
            alert('Failed to save product: ' + (error.message || 'Unknown error'));
        }
    } catch (error) {
        alert('Error saving product');
        console.error(error);
    }
});

loadProducts();
</script>
@endpush
