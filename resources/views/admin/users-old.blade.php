<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('api-config.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <title>Users — AUSHVERA Admin</title>
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
                <h1 class="page-title">Users</h1>
            </header>
            <div class="page-content">
                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTable">
                            <tr><td colspan="6" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- User Details Modal -->
    <div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h2 class="text-xl font-bold">User Details</h2>
                <button onclick="closeModal()" class="text-2xl hover:text-gray-300">&times;</button>
            </div>
            <div class="page-content" id="userDetails">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="font-semibold text-gray-600">Name:</label><input type="text" id="modalName" class="w-full border rounded px-2 py-1 mt-1"></div>
                    <div><label class="font-semibold text-gray-600">Email:</label><input type="email" id="modalEmail" class="w-full border rounded px-2 py-1 mt-1"></div>
                    <div><label class="font-semibold text-gray-600">Phone:</label><input type="text" id="modalPhone" class="w-full border rounded px-2 py-1 mt-1"></div>
                    <div><label class="font-semibold text-gray-600">DOB:</label><input type="date" id="modalDob" class="w-full border rounded px-2 py-1 mt-1"></div>
                    <div><label class="font-semibold text-gray-600">Gender:</label><select id="modalGender" class="w-full border rounded px-2 py-1 mt-1"><option value="">Select</option><option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option></select></div>
                    <div><label class="font-semibold text-gray-600">City:</label><input type="text" id="modalCity" class="w-full border rounded px-2 py-1 mt-1"></div>
                    <div><label class="font-semibold text-gray-600">State:</label><input type="text" id="modalState" class="w-full border rounded px-2 py-1 mt-1"></div>
                    <div><label class="font-semibold text-gray-600">Pincode:</label><input type="text" id="modalPincode" class="w-full border rounded px-2 py-1 mt-1"></div>
                    <div class="col-span-2"><label class="font-semibold text-gray-600">Address:</label><textarea id="modalAddress" class="w-full border rounded px-2 py-1 mt-1" rows="2"></textarea></div>
                    <div class="col-span-2"><span class="font-semibold text-gray-600">Joined:</span> <span id="modalJoined" class="text-gray-500"></span></div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-b-lg text-right">
                <button onclick="saveUser()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 mr-2">Save</button>
                <button onclick="closeModal()" class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-gray-800">Close</button>
            </div>
        </div>
    </div>
    
    <script>
        async AdminApp.logout() {
            try { await api.logout(); } catch(e) {}
            localStorage.removeItem('auth_token');
            localStorage.removeItem('currentUser');
            document.getElementById('loginModal').classList.add('active');
        }
        
        const user = JSON.parse(localStorage.getItem('user'));
        if (!user || user.role !== 'admin') {
            document.getElementById('loginModal').classList.add('active');
        }
        
        async function loadUsers() {
            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch('http://localhost:8000/api/admin/users', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await response.json();
                
                const tbody = document.getElementById('usersTable');
                if (data.users && data.users.length > 0) {
                    tbody.innerHTML = data.users.map(u => `
                        <tr>
                            <td>${u.name}</td>
                            <td>${u.email}</td>
                            <td>${u.phone || 'N/A'}</td>
                            <td>${u.city || 'N/A'}</td>
                            <td>${new Date(u.created_at).toLocaleDateString()}</td>
                            <td>
                                <button onclick="viewUser(${u.id})" class="btn btn-success">View</button>
                                <button onclick="deleteUser(${u.id})" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">No users found</td></tr>';
                }
            } catch (error) {
                console.error(error);
                document.getElementById('usersTable').innerHTML = '<tr><td colspan="6" class="text-center text-red-500">Error loading users</td></tr>';
            }
        }
        
        let currentUserId = null;
        
        async function viewUser(id) {
            try {
                currentUserId = id;
                const response = await fetch(`http://localhost:8000/api/admin/users/${id}`);
                const data = await response.json();
                const u = data.user;
                
                document.getElementById('modalName').value = u.name;
                document.getElementById('modalEmail').value = u.email;
                document.getElementById('modalPhone').value = u.phone || '';
                document.getElementById('modalDob').value = u.dob || '';
                document.getElementById('modalGender').value = u.gender || '';
                document.getElementById('modalCity').value = u.city || '';
                document.getElementById('modalState').value = u.state || '';
                document.getElementById('modalPincode').value = u.pincode || '';
                document.getElementById('modalAddress').value = u.address || '';
                document.getElementById('modalJoined').textContent = new Date(u.created_at).toLocaleString();
                
                document.getElementById('userModal').classList.remove('hidden');
            } catch (error) {
                alert('Error loading user details');
            }
        }
        
        async function saveUser() {
            try {
                const response = await fetch(`http://localhost:8000/api/admin/users/${currentUserId}`, {
                    method: 'PUT',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        name: document.getElementById('modalName').value,
                        email: document.getElementById('modalEmail').value,
                        phone: document.getElementById('modalPhone').value,
                        dob: document.getElementById('modalDob').value,
                        gender: document.getElementById('modalGender').value,
                        city: document.getElementById('modalCity').value,
                        state: document.getElementById('modalState').value,
                        pincode: document.getElementById('modalPincode').value,
                        address: document.getElementById('modalAddress').value
                    })
                });
                if (response.ok) {
                    alert('User updated successfully');
                    closeModal();
                    loadUsers();
                } else {
                    alert('Failed to update user');
                }
            } catch (error) {
                alert('Error updating user');
            }
        }
        
        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
        }
        
        function editUser(id) {
            alert('Edit user ' + id + ' - Feature coming soon');
        }
        
        async function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                try {
                    const response = await fetch(`http://localhost:8000/api/admin/users/${id}`, {
                        method: 'DELETE'
                    });
                    if (response.ok) {
                        alert('User deleted successfully');
                        loadUsers();
                    } else {
                        alert('Failed to delete user');
                    }
                } catch (error) {
                    alert('Error deleting user');
                }
            }
        }
        
        loadUsers();
    </script>
</body>
</html>
