<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('api-config.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <title>Products Management — AUSHVERA Admin</title>
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
                <h1 class="page-title">Products Management</h1>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <input type="text" id="searchInput" placeholder="Search products..." style="padding: 0.5rem 1rem; border: 1px solid #dee2e6; border-radius: 6px; width: 250px;">
                    <select id="categoryFilter" style="padding: 0.5rem 1rem; border: 1px solid #dee2e6; border-radius: 6px;">
                        <option value="">All Categories</option>
                        <option value="Ayurvedic">Ayurvedic</option>
                        <option value="Tea">Tea</option>
                        <option value="Wellness">Wellness</option>
                    </select>
                    <button onclick="openAddModal()" class="bg-green-600">+ Add Product</button>
                </div>
            </header>
            <div class="page-content">
                <div class="section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div style="color: #6c757d; font-size: 14px;">
                            Total Products: <strong id="totalProducts">0</strong>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <button onclick="exportProducts()" class="btn btn-success" style="font-size: 13px; padding: 0.5rem 1rem;">📥 Export CSV</button>
                            <button onclick="refreshProducts()" class="btn btn-primary" style="font-size: 13px; padding: 0.5rem 1rem;">🔄 Refresh</button>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productsTable">
                            <tr><td colspan="7" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Product Modal -->
    <div id="productModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h2 class="text-xl font-bold" id="modalTitle">Add Product</h2>
                <button onclick="closeModal()" class="text-2xl hover:text-gray-300">&times;</button>
            </div>
            <form id="productForm" class="page-content">
                <input type="hidden" id="productId">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-2">Product Name</label>
                        <input type="text" id="productName" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-2">Description</label>
                        <textarea id="productDescription" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Price (₹)</label>
                        <input type="number" id="productPrice" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Original Price (₹)</label>
                        <input type="number" id="productOriginalPrice" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Discount (%)</label>
                        <input type="number" id="productDiscount" class="w-full border rounded px-3 py-2" min="0" max="100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Stock</label>
                        <input type="number" id="productStock" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-2">Category</label>
                        <select id="productCategory" class="w-full border rounded px-3 py-2">
                            <option value="Ayurvedic">Ayurvedic</option>
                            <option value="Tea">Tea</option>
                            <option value="Wellness">Wellness</option>
                            <option value="Herbal">Herbal</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-2">Card Image (for listings)</label>
                        <input type="file" id="cardImageFile" accept="image/*" class="w-full border rounded px-3 py-2">
                        <input type="hidden" id="cardImage">
                        <div id="cardImagePreview" class="mt-3" style="display:none;">
                            <img id="cardPreviewImg" style="max-width: 100%; height: 200px; object-fit: contain; border: 2px solid #e5e7eb; border-radius: 8px; padding: 8px; background: #f9fafb;">
                        </div>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-2">Display Images (for product page)</label>
                        <input type="file" id="displayImagesFile" accept="image/*" multiple class="w-full border rounded px-3 py-2">
                        <input type="hidden" id="displayImages">
                        <div id="displayImagesPreview" class="mt-2 grid grid-cols-4 gap-2" style="display:none;"></div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let allProducts = [];

        async AdminApp.logout() {
            try { await api.logout(); } catch(e) {}
            localStorage.removeItem('auth_token');
            localStorage.removeItem('currentUser');
            window.location.href = '{{ url("/") }}';
        }
        
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '{{ url("/profile") }}';
        }

        async function loadProducts() {
            try {
                const response = await api.getProducts();
                const products = response.data;
                allProducts = products;
                
                const tbody = document.getElementById('productsTable');
                if (!products || products.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center p-4">No products found</td></tr>';
                    return;
                }
                
                tbody.innerHTML = products.map(p => `
                    <tr>
                        <td><img src="${p.image && p.image.length < 100 ? p.image : 'assets/img/product.jpeg'}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;" onerror="this.src='assets/img/product.jpeg'"></td>
                        <td>${p.id}</td>
                        <td>${p.name}</td>
                        <td>₹${p.price}</td>
                        <td>${p.stock} ${p.stock < 10 ? '<span style="color: #ef4444; font-size: 11px;">⚠️ Low</span>' : ''}</td>
                        <td>${p.category || 'Ayurvedic'}</td>
                        <td>
                            <button onclick="viewProduct(${p.id})" class="btn" style="background: #6c757d; color: white; padding: 0.4rem 0.8rem; font-size: 12px;">👁️ View</button>
                            <button onclick="editProduct(${p.id})" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 12px;">✏️ Edit</button>
                            <button onclick="deleteProduct(${p.id})" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 12px;">🗑️ Delete</button>
                        </td>
                    </tr>
                `).join('');
                
                document.getElementById('totalProducts').textContent = products.length;
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('productsTable').innerHTML = '<tr><td colspan="7" class="text-center p-4 text-red-500">Error loading products</td></tr>';
            }
        }

        document.getElementById('searchInput').addEventListener('input', filterProducts);
        document.getElementById('categoryFilter').addEventListener('change', filterProducts);

        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value;
            
            let filtered = allProducts.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(searchTerm) || 
                                     (p.description && p.description.toLowerCase().includes(searchTerm));
                const matchesCategory = !category || p.category === category;
                return matchesSearch && matchesCategory;
            });
            
            const tbody = document.getElementById('productsTable');
            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center p-4">No products found</td></tr>';
                return;
            }
            
            tbody.innerHTML = filtered.map(p => `
                <tr>
                    <td><img src="${p.image && p.image.length < 100 ? p.image : 'assets/img/product.jpeg'}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;" onerror="this.src='assets/img/product.jpeg'"></td>
                    <td>${p.id}</td>
                    <td>${p.name}</td>
                    <td>₹${p.price}</td>
                    <td>${p.stock} ${p.stock < 10 ? '<span style="color: #ef4444; font-size: 11px;">⚠️ Low</span>' : ''}</td>
                    <td>${p.category || 'Ayurvedic'}</td>
                    <td>
                        <button onclick="viewProduct(${p.id})" class="btn" style="background: #6c757d; color: white; padding: 0.4rem 0.8rem; font-size: 12px;">👁️ View</button>
                        <button onclick="editProduct(${p.id})" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 12px;">✏️ Edit</button>
                        <button onclick="deleteProduct(${p.id})" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 12px;">🗑️ Delete</button>
                    </td>
                </tr>
            `).join('');
            document.getElementById('totalProducts').textContent = filtered.length;
        }

        async function refreshProducts() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            await loadProducts();
        }

        function viewProduct(id) {
            window.open(`product.html?id=${id}`, '_blank');
        }

        function exportProducts() {
            if (allProducts.length === 0) {
                alert('No products to export');
                return;
            }
            
            const csv = [
                ['ID', 'Name', 'Description', 'Price', 'Original Price', 'Discount', 'Stock', 'Category'],
                ...allProducts.map(p => [
                    p.id,
                    `"${p.name}"`,
                    `"${p.description || ''}"`,
                    p.price,
                    p.original_price || '',
                    p.discount || '',
                    p.stock,
                    p.category || 'Ayurvedic'
                ])
            ].map(row => row.join(',')).join('\n');
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `products_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
            window.URL.revokeObjectURL(url);
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Product';
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('cardImage').value = '';
            document.getElementById('displayImages').value = '';
            document.getElementById('cardImagePreview').style.display = 'none';
            document.getElementById('displayImagesPreview').style.display = 'none';
            document.getElementById('productModal').classList.remove('hidden');
        }

        async function editProduct(id) {
            try {
                const response = await fetch(`http://localhost:8000/api/products/${id}`);
                const result = await response.json();
                const product = result.data || result;
                
                document.getElementById('modalTitle').textContent = 'Edit Product';
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.name;
                document.getElementById('productDescription').value = product.description;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productOriginalPrice').value = product.original_price || '';
                document.getElementById('productDiscount').value = product.discount || '';
                document.getElementById('productStock').value = product.stock;
                document.getElementById('productCategory').value = product.category || 'Ayurvedic';
                document.getElementById('cardImage').value = product.image || '';
                document.getElementById('displayImages').value = product.display_images || '';
                
                if (product.image && product.image.length < 100) {
                    document.getElementById('cardPreviewImg').src = product.image;
                    document.getElementById('cardImagePreview').style.display = 'block';
                }
                
                if (product.display_images) {
                    try {
                        const images = JSON.parse(product.display_images);
                        const preview = document.getElementById('displayImagesPreview');
                        preview.innerHTML = '';
                        images.forEach((img, index) => {
                            const div = document.createElement('div');
                            div.className = 'relative';
                            div.innerHTML = `
                                <img src="${img}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                                <button type="button" onclick="removeDisplayImage(${index})" class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-xs">×</button>
                            `;
                            preview.appendChild(div);
                        });
                        preview.style.display = 'grid';
                    } catch (e) {
                        console.error('Error parsing display images:', e);
                    }
                }
                
                document.getElementById('productModal').classList.remove('hidden');
            } catch (error) {
                alert('Error loading product details');
            }
        }

        async function deleteProduct(id) {
            if (!confirm('Are you sure you want to delete this product?')) return;
            
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`http://localhost:8000/api/admin/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                
                if (response.ok) {
                    alert('Product deleted successfully');
                    loadProducts();
                } else {
                    alert('Failed to delete product');
                }
            } catch (error) {
                alert('Error deleting product');
            }
        }

        function closeModal() {
            document.getElementById('productModal').classList.add('hidden');
        }

        document.getElementById('cardImageFile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cardImage').value = e.target.result;
                    document.getElementById('cardPreviewImg').src = e.target.result;
                    document.getElementById('cardImagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('cardImagePreview').style.display = 'none';
            }
        });

        document.getElementById('displayImagesFile').addEventListener('change', function(e) {
            const files = e.target.files;
            const images = [];
            const preview = document.getElementById('displayImagesPreview');
            preview.innerHTML = '';
            
            if (files.length > 0) {
                let loaded = 0;
                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        images.push(e.target.result);
                        
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                            <button type="button" onclick="removeDisplayImage(${index})" class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-xs">×</button>
                            <button type="button" onclick="setPrimaryImage(${index})" class="absolute bottom-1 left-1 bg-blue-600 text-white rounded px-2 py-1 text-xs">Primary</button>
                        `;
                        preview.appendChild(div);
                        
                        loaded++;
                        if (loaded === files.length) {
                            document.getElementById('displayImages').value = JSON.stringify(images);
                            preview.style.display = 'grid';
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        window.removeDisplayImage = function(index) {
            const images = JSON.parse(document.getElementById('displayImages').value || '[]');
            images.splice(index, 1);
            document.getElementById('displayImages').value = JSON.stringify(images);
            
            const preview = document.getElementById('displayImagesPreview');
            preview.children[index].remove();
            if (images.length === 0) preview.style.display = 'none';
        };

        window.setPrimaryImage = function(index) {
            const images = JSON.parse(document.getElementById('displayImages').value || '[]');
            const primary = images.splice(index, 1)[0];
            images.unshift(primary);
            document.getElementById('displayImages').value = JSON.stringify(images);
            
            const preview = document.getElementById('displayImagesPreview');
            const firstChild = preview.children[index];
            preview.insertBefore(firstChild, preview.firstChild);
            alert('Set as primary image');
        };

        document.getElementById('productForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const productId = document.getElementById('productId').value;
            const data = {
                name: document.getElementById('productName').value,
                description: document.getElementById('productDescription').value,
                price: parseFloat(document.getElementById('productPrice').value),
                original_price: document.getElementById('productOriginalPrice').value || null,
                discount: document.getElementById('productDiscount').value || null,
                stock: parseInt(document.getElementById('productStock').value),
                category: document.getElementById('productCategory').value || 'Ayurvedic',
                image: document.getElementById('cardImage').value || null,
                display_images: document.getElementById('displayImages').value || null
            };

            try {
                const token = localStorage.getItem('auth_token');
                const url = productId 
                    ? `http://localhost:8000/api/admin/products/${productId}`
                    : 'http://localhost:8000/api/admin/products';
                
                const response = await fetch(url, {
                    method: productId ? 'PUT' : 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
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
                console.error('Error:', error);
                alert('Error saving product: ' + error.message);
            }
        });

        loadProducts();
    </script>
</body>
</html>
