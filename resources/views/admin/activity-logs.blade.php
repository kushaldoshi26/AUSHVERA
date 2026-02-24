<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs - AUSHVERA</title>
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
<body style="background: #F7F4EE;">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Activity Logs</h1></div>

        <div class="bg-white border border-[#C6A75E]/20 rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-[#F7F4EE]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">IP Address</th>
                    </tr>
                </thead>
                <tbody id="logsTable" class="divide-y divide-gray-200"></tbody>
            </table>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        const token = localStorage.getItem('token');

        async function loadLogs() {
            try {
                const res = await fetch(`${API_URL}/admin/activity-logs`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await res.json();
                const logs = data.logs || [];

                document.getElementById('logsTable').innerHTML = logs.map(log => `
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            ${new Date(log.created_at).toLocaleString()}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium">${log.user?.name || 'System'}</div>
                            <div class="text-xs text-gray-600">${log.user?.email || ''}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded ${getActionBadge(log.action)}">
                                ${formatAction(log.action)}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">${log.description}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${log.ip_address || '-'}</td>
                    </tr>
                `).join('');
            } catch (err) {
                console.error('Error loading logs:', err);
            }
        }

        function getActionBadge(action) {
            const badges = {
                'admin_created': 'bg-green-100 text-green-800',
                'admin_updated': 'bg-blue-100 text-blue-800',
                'admin_deleted': 'bg-red-100 text-red-800',
                'password_reset': 'bg-purple-100 text-purple-800',
                'password_changed': 'bg-purple-100 text-purple-800',
                'admin_status_changed': 'bg-orange-100 text-orange-800'
            };
            return badges[action] || 'bg-[#F7F4EE] text-gray-700';
        }

        function formatAction(action) {
            return action.replace(/_/g, ' ').toUpperCase();
        }

        loadLogs();
    </script>
</body>
</html>
