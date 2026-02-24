@extends('layouts.admin')
@section('title', 'Banners')
@section('page-title', 'Banner Management')

@section('header-actions')
<button class="bg-green-600" onclick="openAddModal()">+ Add Banner</button>
@endsection

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Link</th>
                <th>Order</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="bannersTable">
            <tr><td colspan="7" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>

<div id="bannerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-xl w-full mx-4">
        <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h2 class="text-xl font-bold" id="modalTitle">Add Banner</h2>
            <button onclick="closeModal()" class="text-2xl">&times;</button>
        </div>
        <form id="bannerForm" class="p-6">
            <input type="hidden" id="bannerId">
            
            <div class="form-group">
                <label>Banner Title</label>
                <input type="text" id="bannerTitle" required>
            </div>
            
            <div class="form-group">
                <label>Link URL (optional)</label>
                <input type="text" id="bannerLink" placeholder="https://example.com">
            </div>
            
            <div class="form-group">
                <label>Display Order</label>
                <input type="number" id="bannerOrder" value="0" min="0">
            </div>
            
            <div class="form-group">
                <label>Rotation Time (seconds)</label>
                <input type="number" id="rotationTime" value="5" min="1" max="60">
            </div>
            
            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" id="bannerImageFile" accept="image/*" onchange="previewImage(this)" required>
                <input type="hidden" id="bannerImage">
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <img id="previewImg" style="max-width:100%;height:200px;object-fit:contain;border:2px solid #e5e7eb;border-radius:8px;padding:8px;">
                </div>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" id="bannerActive" checked>
                    Active
                </label>
            </div>
            
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal()" class="btn bg-gray-500 text-white">Cancel</button>
                <button type="submit" class="btn bg-blue-600 text-white">Save Banner</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let banners = [];

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('bannerImage').value = e.target.result;
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

async function loadBanners() {
    try {
        const token = api.getToken();
        const response = await fetch('{{ url("/api/admin/banners") }}', {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        const data = await response.json();
        banners = data.banners || data.data || [];
        const tbody = document.getElementById('bannersTable');
        
        if (banners.length > 0) {
            tbody.innerHTML = banners.map(b => `
                <tr>
                    <td>${b.id}</td>
                    <td><img src="${b.image_url}" style="width:100px;height:50px;object-fit:cover;border-radius:4px;" onerror="this.src='assets/img/placeholder.jpg'"></td>
                    <td>${b.title || 'N/A'}</td>
                    <td>${b.link_url ? '<a href="' + b.link_url + '" target="_blank">Link</a>' : 'N/A'}</td>
                    <td>${b.display_order || 0}</td>
                    <td>
                        <span class="badge badge-${b.is_active ? 'delivered' : 'cancelled'}">${b.is_active ? 'Active' : 'Inactive'}</span>
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="editBanner(${b.id})">Edit</button>
                        <button class="btn ${b.is_active ? 'bg-gray-500' : 'btn-success'}" onclick="toggleBanner(${b.id}, ${b.is_active})">${b.is_active ? 'Deactivate' : 'Activate'}</button>
                        <button class="btn btn-danger" onclick="deleteBanner(${b.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No banners found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading banners:', error);
        document.getElementById('bannersTable').innerHTML = '<tr><td colspan="7" class="text-center">No banners found</td></tr>';
    }
}

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add Banner';
    document.getElementById('bannerForm').reset();
    document.getElementById('bannerId').value = '';
    document.getElementById('bannerImage').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('bannerModal').classList.remove('hidden');
    document.getElementById('bannerModal').classList.add('flex');
}

function editBanner(id) {
    const banner = banners.find(b => b.id === id);
    if (!banner) return;
    
    document.getElementById('modalTitle').textContent = 'Edit Banner';
    document.getElementById('bannerId').value = banner.id;
    document.getElementById('bannerTitle').value = banner.title;
    document.getElementById('bannerLink').value = banner.link_url || '';
    document.getElementById('bannerOrder').value = banner.display_order || 0;
    document.getElementById('rotationTime').value = banner.rotation_time || 5;
    document.getElementById('bannerActive').checked = banner.is_active;
    document.getElementById('bannerImage').value = banner.image_url;
    
    if (banner.image_url) {
        document.getElementById('previewImg').src = banner.image_url;
        document.getElementById('imagePreview').style.display = 'block';
    }
    
    document.getElementById('bannerModal').classList.remove('hidden');
    document.getElementById('bannerModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('bannerModal').classList.add('hidden');
    document.getElementById('bannerModal').classList.remove('flex');
}

document.getElementById('bannerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const bannerId = document.getElementById('bannerId').value;
    const data = {
        title: document.getElementById('bannerTitle').value,
        image_url: document.getElementById('bannerImage').value,
        link_url: document.getElementById('bannerLink').value || null,
        display_order: parseInt(document.getElementById('bannerOrder').value),
        rotation_time: parseInt(document.getElementById('rotationTime').value),
        is_active: document.getElementById('bannerActive').checked
    };
    
    try {
        const token = api.getToken();
        const url = bannerId ? `{{ url("/api/admin/banners") }}/${bannerId}` : '{{ url("/api/admin/banners") }}';
        const response = await fetch(url, {
            method: bannerId ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(data)
        });
        
        if (response.ok) {
            alert(bannerId ? 'Banner updated successfully' : 'Banner added successfully');
            closeModal();
            loadBanners();
        } else {
            alert('Failed to save banner');
        }
    } catch (error) {
        alert('Error saving banner');
        console.error(error);
    }
});

async function toggleBanner(id, currentStatus) {
    try {
        const token = api.getToken();
        await fetch(`{{ url("/api/admin/banners") }}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({ is_active: !currentStatus })
        });
        alert('Banner status updated');
        loadBanners();
    } catch (error) {
        alert('Error updating banner');
    }
}

async function deleteBanner(id) {
    if (!confirm('Delete this banner?')) return;
    
    try {
        const token = api.getToken();
        await fetch(`{{ url("/api/admin/banners") }}/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}` }
        });
        alert('Banner deleted');
        loadBanners();
    } catch (error) {
        alert('Error deleting banner');
    }
}

loadBanners();
</script>
@endpush
