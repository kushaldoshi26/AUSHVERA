@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Users Management')

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="usersTable">
            <tr><td colspan="8" class="text-center">Loading...</td></tr>
        </tbody>
    </table>
</div>

<!-- User Details Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h2 class="text-xl font-bold">User Details</h2>
            <button onclick="closeModal()" class="text-2xl hover:text-gray-300">&times;</button>
        </div>
        <div class="p-6">
            <div id="userDetails"></div>
            
            <div class="flex justify-end gap-2 mt-6">
                <button onclick="closeModal()" class="btn bg-gray-500 text-white hover:bg-gray-600">Close</button>
                <button id="blockBtn" onclick="toggleUserStatus()" class="btn bg-red-600 text-white hover:bg-red-700">Block User</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let users = [];
let currentUser = null;

async function loadUsers() {
    try {
        const token = api.getToken();
        const response = await fetch('{{ url("/api/admin/users") }}', {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        const data = await response.json();
        users = data.users || data.data || [];
        const tbody = document.getElementById('usersTable');
        
        if (users.length > 0) {
            tbody.innerHTML = users.map(u => `
                <tr>
                    <td>${u.id}</td>
                    <td>${u.name}</td>
                    <td>${u.email}</td>
                    <td>${u.phone || 'N/A'}</td>
                    <td><span class="badge badge-${u.role || 'user'}">${u.role || 'user'}</span></td>
                    <td><span class="badge badge-${u.is_active ? 'active' : 'blocked'}">${u.is_active !== false ? 'Active' : 'Blocked'}</span></td>
                    <td>${new Date(u.created_at).toLocaleDateString()}</td>
                    <td>
                        <button class="btn btn-primary" onclick="viewUser(${u.id})">View</button>
                        <button class="btn ${u.is_active !== false ? 'btn-danger' : 'btn-success'}" onclick="toggleUserStatus(${u.id}, ${u.is_active !== false})">${u.is_active !== false ? 'Block' : 'Unblock'}</button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">No users found</td></tr>';
        }
    } catch (error) {
        console.error('Error loading users:', error);
        document.getElementById('usersTable').innerHTML = '<tr><td colspan="8" class="text-center">Error loading users</td></tr>';
    }
}

async function viewUser(id) {
    try {
        const token = api.getToken();
        const response = await fetch(`{{ url("/api/admin/users") }}/${id}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        const data = await response.json();
        currentUser = data.user || data.data;
        
        document.getElementById('userDetails').innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <div><strong>ID:</strong> ${currentUser.id}</div>
                <div><strong>Name:</strong> ${currentUser.name}</div>
                <div><strong>Email:</strong> ${currentUser.email}</div>
                <div><strong>Phone:</strong> ${currentUser.phone || 'N/A'}</div>
                <div><strong>Role:</strong> <span class="badge badge-${currentUser.role || 'user'}">${currentUser.role || 'user'}</span></div>
                <div><strong>Status:</strong> <span class="badge badge-${currentUser.is_active !== false ? 'active' : 'blocked'}">${currentUser.is_active !== false ? 'Active' : 'Blocked'}</span></div>
                <div><strong>City:</strong> ${currentUser.city || 'N/A'}</div>
                <div><strong>State:</strong> ${currentUser.state || 'N/A'}</div>
                <div class="col-span-2"><strong>Address:</strong> ${currentUser.address || 'N/A'}</div>
                <div class="col-span-2"><strong>Joined:</strong> ${new Date(currentUser.created_at).toLocaleString()}</div>
            </div>
        `;
        
        const blockBtn = document.getElementById('blockBtn');
        if (currentUser.is_active !== false) {
            blockBtn.textContent = 'Block User';
            blockBtn.className = 'btn bg-red-600 text-white hover:bg-red-700';
        } else {
            blockBtn.textContent = 'Unblock User';
            blockBtn.className = 'btn bg-green-600 text-white hover:bg-green-700';
        }
        
        document.getElementById('userModal').classList.remove('hidden');
        document.getElementById('userModal').classList.add('flex');
    } catch (error) {
        alert('Error loading user details');
        console.error(error);
    }
}

async function toggleUserStatus(userId = null, isActive = null) {
    const id = userId || currentUser?.id;
    const currentStatus = isActive !== null ? isActive : (currentUser?.is_active !== false);
    
    if (!id) return;
    
    const action = currentStatus ? 'block' : 'unblock';
    if (!confirm(`Are you sure you want to ${action} this user?`)) return;
    
    try {
        const token = api.getToken();
        const response = await fetch(`{{ url("/api/admin/users") }}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                is_active: !currentStatus
            })
        });
        
        if (response.ok) {
            alert(`User ${action}ed successfully`);
            closeModal();
            loadUsers();
        } else {
            const error = await response.json();
            alert('Failed to update user: ' + (error.message || 'Unknown error'));
        }
    } catch (error) {
        alert('Error updating user status');
        console.error(error);
    }
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
    document.getElementById('userModal').classList.remove('flex');
    currentUser = null;
}

loadUsers();
</script>
@endpush
