<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Admin Management - AUSHVERA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="admin-global.css">
    
    <style>
        .submenu { display: none; padding-left: 1rem; }
        .submenu.open { display: block; }
        .rotate-90 { transform: rotate(90deg); }
    </style>
</head>
<body style="background: #F7F4EE;">
    <div class="flex h-screen overflow-hidden">
        <!-- Premium Sidebar -->
        <aside class="w-64 text-white overflow-y-auto fixed h-screen" style="background: #0B1C2D; border-right: 1px solid rgba(198, 167, 94, 0.2);">
            <div class="p-4" style="border-bottom: 1px solid rgba(198, 167, 94, 0.2);">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="AUSHVERA" class="w-10 h-10">
                    <div>
                        <div style="color: #C6A75E; font-weight: bold; font-size: 1.125rem; letter-spacing: 0.1em;">AUSHVERA</div>
                        <div class="text-xs" style="color: #9CA3AF;">Admin Panel</div>
                    </div>
                </div>
            </div>
            
            <nav class="p-4">
                <!-- Dashboard -->
                <a href="admin-dashboard-premium.html" class="block py-2 px-4 rounded hover:bg-[#C6A75E]/10 mb-2">
                    📊 Dashboard
                </a>

                <!-- Products -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>🛍️ Products</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/products') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">All Products</a></li>
                        <li><a href="{{ url('/admin/categories') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Categories</a></li>
                    </ul>
                </div>

                <!-- Orders -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📦 Orders</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/orders') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">All Orders</a></li>
                        <li><a href="admin-orders.html?status=pending" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Pending Orders</a></li>
                        <li><a href="admin-orders.html?status=completed" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Completed</a></li>
                    </ul>
                </div>

                <!-- Users -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>👥 Users</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/users') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">All Users</a></li>
                    </ul>
                </div>

                <!-- Inventory -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📦 Inventory</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/inventory') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Stock Management</a></li>
                    </ul>
                </div>

                <!-- Marketing -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📢 Marketing</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/banners') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Banners</a></li>
                        <li><a href="{{ url('/admin/coupons') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Coupons</a></li>
                    </ul>
                </div>

                <!-- Reports -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>📈 Reports</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/analytics') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Analytics</a></li>
                        <li><a href="{{ url('/admin/analytics') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Sales Report</a></li>
                    </ul>
                </div>

                <!-- Admin Management -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>👑 Admin Management</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/management') }}" class="block py-2 px-4 bg-[#C6A75E]/10 rounded">All Admins</a></li>
                        <li><a href="admin-register.html" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">➕ Create Admin</a></li>
                        <li><a href="{{ url('/admin/activity-logs') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Activity Logs</a></li>
                    </ul>
                </div>

                <!-- Settings -->
                <div class="sidebar-item mb-2">
                    <button class="sidebar-toggle w-full text-left py-2 px-4 rounded hover:bg-[#C6A75E]/10 flex justify-between items-center">
                        <span>⚙️ Settings</span>
                        <span class="arrow transition-transform">▶</span>
                    </button>
                    <ul class="submenu">
                        <li><a href="{{ url('/admin/reviews') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Reviews</a></li>
                        <li><a href="{{ url('/admin/pricing') }}" class="block py-2 px-4 hover:bg-[#C6A75E]/10 rounded">Pricing</a></li>
                    </ul>
                </div>

                <hr class="my-4 border-[#C6A75E]/20">

                <a href="{{ url('/') }}" class="block py-2 px-4 rounded hover:bg-[#C6A75E]/10 mb-2">
                    🔙 Back to Site
                </a>
                <button onclick="logout()" class="w-full text-left block py-2 px-4 rounded hover:bg-red-800 text-red-400">
                    🚪 Logout
                </button>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto ml-64" style="background: #F7F4EE;">
            <header class="p-6 sticky top-0 z-10" style="background: #0B1C2D; border-bottom: 1px solid rgba(198, 167, 94, 0.2);">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold" style="color: #C6A75E;">Admin Management</h1>
                        <p class="text-sm mt-1" style="color: #9CA3AF;">Welcome back, <span id="adminName" style="color: #C6A75E;"></span></p>
                    </div>
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notificationBtn" class="relative p-2 text-gray-600 hover:text-gray-900">
                            🔔
                            <span id="notificationBadge" class="hidden absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                        </button>
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border z-50">
                            <div class="p-4 border-b">
                                <h3 class="font-bold">Notifications</h3>
                            </div>
                            <div id="notificationList" class="max-h-96 overflow-y-auto"></div>
                        </div>
                    </div>
                    <span id="adminName" class="text-sm text-gray-600"></span>
                    <span id="adminRoleTitle" class="text-sm font-semibold px-4 py-2 rounded-full" style="background: rgba(198, 167, 94, 0.15); color: #C6A75E; border: 1px solid rgba(198, 167, 94, 0.3);"></span><span id="adminRole" style="display:none;" class="text-xs bg-[#C6A75E]/20 text-[#C6A75E] px-2 py-1 rounded"></span>
                </div>
            </header>

            <div class="p-6">
                <div class="bg-white border border-[#C6A75E]/20 rounded shadow">
                    <table class="w-full">
                        <thead class="bg-[#F7F4EE] border-b">
                            <tr>
                                <th class="text-left p-4">Name</th>
                                <th class="text-left p-4">Email</th>
                                <th class="text-left p-4">Role</th>
                                <th class="text-left p-4">Status</th>
                                <th class="text-left p-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adminsTable"><tr><td colspan="5" class="text-center p-4">Loading...</td></tr></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Admin Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h2 class="text-xl font-bold">Edit Admin</h2>
                <button onclick="closeEditModal()" class="text-2xl">&times;</button>
            </div>
            <form id="editForm" class="p-6">
                <input type="hidden" id="editAdminId">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Name</label>
                    <input type="text" id="editName" required class="w-full border border-[#C6A75E]/30 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" id="editEmail" required class="w-full border border-[#C6A75E]/30 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Role</label>
                    <select id="editRole" class="w-full border border-[#C6A75E]/30 rounded px-3 py-2">
                        <option value="super_admin">Super Admin</option>
                        <option value="manager">Manager</option>
                        <option value="support">Support</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-300 text-gray-600 px-6 py-2 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="bg-[#C6A75E] text-white px-6 py-2 rounded hover:bg-[#B8964C]">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="bg-gray-900 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h2 class="text-xl font-bold">Change Password</h2>
                <button onclick="closePasswordModal()" class="text-2xl">&times;</button>
            </div>
            <form id="passwordForm" class="p-6">
                <input type="hidden" id="passwordAdminId">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">New Password</label>
                    <input type="password" id="newPassword" required minlength="6" class="w-full border border-[#C6A75E]/30 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Confirm Password</label>
                    <input type="password" id="confirmPassword" required minlength="6" class="w-full border border-[#C6A75E]/30 rounded px-3 py-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closePasswordModal()" class="bg-gray-300 text-gray-600 px-6 py-2 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="bg-[#C6A75E] text-white px-6 py-2 rounded hover:bg-[#B8964C]">Change Password</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
    <script>
        const API_URL = 'http://localhost:8000/api';
        const token = localStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user'));
        if (!user || user.role !== 'admin') window.location.href = '{{ url("/profile") }}';

        async function loadAdmins() {
            try {
                const response = await fetch(`${API_URL}/admin/admins`, { headers: { 'Authorization': `Bearer ${token}` }});
                const result = await response.json();
                const admins = result.data || result;
                const tbody = document.getElementById('adminsTable');
                if (!admins || admins.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center p-4">No admins found</td></tr>';
                    return;
                }
                tbody.innerHTML = admins.map(admin => `
                    <tr class="border-b hover:bg-[#F7F4EE]">
                        <td class="p-4 font-medium text-[#C6A75E]">${admin.name}</td>
                        <td class="p-4 text-gray-600">${admin.email}</td>
                        <td class="p-4 text-gray-600">${admin.admin_role || 'admin'}</td>
                        <td class="p-4"><span class="px-2 py-1 text-xs rounded-full ${admin.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${admin.is_active ? 'Active' : 'Inactive'}</span></td>
                        <td class="p-4">
                            <button onclick="editAdmin(${admin.id})" class="text-[#C6A75E] hover:underline mr-2">Edit</button>
                            <button onclick="changePassword(${admin.id})" class="text-blue-600 hover:underline mr-2">Password</button>
                            <button onclick="toggleStatus(${admin.id}, ${admin.is_active})" class="text-orange-600 hover:underline mr-2">${admin.is_active ? 'Disable' : 'Enable'}</button>
                            <button onclick="deleteAdmin(${admin.id})" class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                document.getElementById('adminsTable').innerHTML = '<tr><td colspan="5" class="text-center p-4 text-red-500">Error loading admins</td></tr>';
            }
        }

        document.querySelectorAll('.sidebar-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const submenu = this.nextElementSibling;
                const arrow = this.querySelector('.arrow');
                submenu.classList.toggle('open');
                arrow.classList.toggle('rotate-90');
            });
        });

        function logout() {
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            localStorage.removeItem('isLoggedIn');
            window.location.href = '{{ url("/profile") }}';
        }

        async function editAdmin(id) {
            try {
                const response = await fetch(`${API_URL}/admin/admins/${id}`, { headers: { 'Authorization': `Bearer ${token}` }});
                const result = await response.json();
                const admin = result.data || result;
                document.getElementById('editAdminId').value = admin.id;
                document.getElementById('editName').value = admin.name;
                document.getElementById('editEmail').value = admin.email;
                document.getElementById('editRole').value = admin.admin_role;
                document.getElementById('editModal').classList.remove('hidden');
            } catch (error) {
                alert('Error loading admin details');
            }
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('editForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editAdminId').value;
            const data = {
                name: document.getElementById('editName').value,
                email: document.getElementById('editEmail').value,
                admin_role: document.getElementById('editRole').value
            };
            try {
                const response = await fetch(`${API_URL}/admin/admins/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify(data)
                });
                if (response.ok) {
                    alert('Admin updated successfully!');
                    closeEditModal();
                    loadAdmins();
                } else {
                    const error = await response.json();
                    alert(error.message || 'Error updating admin');
                }
            } catch (error) {
                alert('Error updating admin');
            }
        });

        function changePassword(id) {
            document.getElementById('passwordAdminId').value = id;
            document.getElementById('passwordModal').classList.remove('hidden');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.getElementById('passwordForm').reset();
        }

        document.getElementById('passwordForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('passwordAdminId').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (newPassword !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            try {
                const response = await fetch(`${API_URL}/admin/admins/${id}/reset-password`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                    body: JSON.stringify({ password: newPassword })
                });
                if (response.ok) {
                    alert('Password changed successfully!');
                    closePasswordModal();
                } else {
                    const error = await response.json();
                    alert(error.message || 'Error changing password');
                }
            } catch (error) {
                alert('Error changing password');
            }
        });

        async function toggleStatus(id, currentStatus) {
            if (!confirm(`Are you sure you want to ${currentStatus ? 'disable' : 'enable'} this admin?`)) return;
            try {
                const response = await fetch(`${API_URL}/admin/admins/${id}/toggle-status`, {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (response.ok) {
                    alert('Status updated successfully!');
                    loadAdmins();
                } else {
                    const error = await response.json();
                    alert(error.message || 'Error updating status');
                }
            } catch (error) {
                alert('Error updating status');
            }
        }

        async function deleteAdmin(id) {
            if (!confirm('Are you sure you want to delete this admin? This action cannot be undone.')) return;
            try {
                const response = await fetch(`${API_URL}/admin/admins/${id}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (response.ok) {
                    alert('Admin deleted successfully!');
                    loadAdmins();
                } else {
                    const error = await response.json();
                    alert(error.message || 'Error deleting admin');
                }
            } catch (error) {
                alert('Error deleting admin');
            }
        }

        loadAdmins();
    </script>
</body>
</html>
