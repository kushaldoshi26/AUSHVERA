<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account - AUSHVERA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="admin-global.css">
    <style>
        .submenu { display: none; padding-left: 1rem; }
        .submenu.open { display: block; }
        .rotate-90 { transform: rotate(90deg); }
        
        document.querySelectorAll('.sidebar-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const submenu = this.nextElementSibling;
                const arrow = this.querySelector('.arrow');
                submenu.classList.toggle('open');
                arrow.classList.toggle('rotate-90');
            });
        });
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">AUSHVERA</h1>
            <p class="text-gray-600 mt-2">Create Admin Account</p>
        </div>
        
        <form id="adminRegisterForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" id="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" required minlength="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Admin Role</label>
                <select id="admin_role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="super_admin">Super Admin</option>
                    <option value="manager">Manager</option>
                    <option value="support">Support</option>
                </select>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 font-medium">
                Create Admin Account
            </button>
        </form>
        
        <p class="text-center text-sm text-gray-600 mt-4">
            Already have an account? <a href="{{ url('/profile') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>

    <script>
        document.getElementById('adminRegisterForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const data = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                admin_role: document.getElementById('admin_role').value,
                role: 'admin'
            };
            
            try {
                const response = await fetch('http://localhost:8000/api/admin/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    alert('Admin account created successfully! You can now login.');
                    window.location.href = '{{ url("/profile") }}';
                } else {
                    alert(result.message || 'Failed to create admin account');
                }
            } catch (error) {
                alert('Error creating admin account. Please try again.');
            }
        });
    </script>
</body>
</html>
