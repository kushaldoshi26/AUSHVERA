@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories Management')

@section('header-actions')
<button onclick="openAddModal()" style="background:#059669;color:white;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;font-weight:500;">+ Add Category</button>
@endsection

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="categoriesTable">
            <tr><td colspan="4" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>

<!-- Add/Edit Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h2 class="text-xl font-bold" id="modalTitle">Add Category</h2>
            <button onclick="closeModal()" class="text-2xl hover:text-gray-300">&times;</button>
        </div>
        <form id="categoryForm" class="p-6">
            <input type="hidden" id="categoryId">

            <div class="form-group" style="margin-bottom:16px;">
                <label style="display:block;font-weight:500;margin-bottom:6px;">Category Name</label>
                <input type="text" id="categoryName" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
            </div>

            <div class="form-group" style="margin-bottom:16px;">
                <label style="display:block;font-weight:500;margin-bottom:6px;">Description</label>
                <textarea id="categoryDescription" rows="3" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;resize:vertical;"></textarea>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:16px;">
                <button type="button" onclick="closeModal()" style="padding:8px 16px;background:#6b7280;color:white;border:none;border-radius:6px;cursor:pointer;">Cancel</button>
                <button type="submit" style="padding:8px 16px;background:#2563eb;color:white;border:none;border-radius:6px;cursor:pointer;">Save Category</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const token = api.getToken();
const headers = { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' };

async function loadCategories() {
    try {
        const res = await fetch('{{ url("/api/categories") }}');
        const data = await res.json();
        const categories = data.data || data || [];
        const tbody = document.getElementById('categoriesTable');

        if (categories.length > 0) {
            tbody.innerHTML = categories.map(c => `
                <tr>
                    <td>${c.id}</td>
                    <td>${c.name}</td>
                    <td>${c.description || '<span style="color:#9ca3af;">—</span>'}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editCategory(${c.id}, '${(c.name||'').replace(/'/g,"\\'")}', '${(c.description||'').replace(/'/g,"\\'")}')">Edit</button>
                        <button class="btn btn-danger" onclick="deleteCategory(${c.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No categories found. Add your first one!</td></tr>';
        }
    } catch (e) {
        document.getElementById('categoriesTable').innerHTML = '<tr><td colspan="4" class="text-center">Error loading categories</td></tr>';
    }
}

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add Category';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    showModal();
}

function editCategory(id, name, description) {
    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
    document.getElementById('categoryDescription').value = description;
    showModal();
}

async function deleteCategory(id) {
    if (!confirm('Are you sure you want to delete this category?')) return;
    try {
        const res = await fetch(`{{ url('/api/admin/categories') }}/${id}`, {
            method: 'DELETE',
            headers
        });
        if (res.ok) {
            alert('Category deleted successfully');
            loadCategories();
        } else {
            const err = await res.json();
            alert('Failed to delete: ' + (err.message || 'Unknown error'));
        }
    } catch (e) {
        alert('Error deleting category');
    }
}

function showModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('categoryModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('categoryModal').classList.remove('flex');
}

document.getElementById('categoryForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('categoryId').value;
    const payload = {
        name: document.getElementById('categoryName').value,
        description: document.getElementById('categoryDescription').value || null,
    };

    const url = id
        ? `{{ url('/api/admin/categories') }}/${id}`
        : '{{ url('/api/admin/categories') }}';

    try {
        const res = await fetch(url, {
            method: id ? 'PUT' : 'POST',
            headers: { ...headers, 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (res.ok) {
            alert(id ? 'Category updated!' : 'Category created!');
            closeModal();
            loadCategories();
        } else {
            const err = await res.json();
            alert('Failed: ' + (err.message || JSON.stringify(err.errors || {})));
        }
    } catch (e) {
        alert('Error saving category');
    }
});

loadCategories();
</script>
@endpush
