<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->select('id', 'name', 'email', 'admin_role', 'is_active', 'last_login_at', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['admins' => $admins]);
    }

    public function store(Request $request)
    {
        // Only super_admin can create new admins
        if (auth()->user()->admin_role !== 'super_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only Super Admin can create new admin accounts'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'admin_role' => 'required|in:super_admin,manager,support'
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'admin_role' => $validated['admin_role'],
            'is_active' => true
        ]);

        ActivityLog::log('admin_created', "Created new admin: {$admin->name}", 'User', $admin->id);

        return response()->json(['message' => 'Admin created successfully', 'admin' => $admin], 201);
    }

    public function update(Request $request, $id)
    {
        // Only super_admin can update admin roles
        if (auth()->user()->admin_role !== 'super_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only Super Admin can modify admin accounts'
            ], 403);
        }

        $admin = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'admin_role' => 'sometimes|in:super_admin,manager,support',
            'is_active' => 'sometimes|boolean'
        ]);

        $changes = [];
        foreach ($validated as $key => $value) {
            if ($admin->$key != $value) {
                $changes[$key] = ['old' => $admin->$key, 'new' => $value];
            }
        }

        $admin->update($validated);

        ActivityLog::log('admin_updated', "Updated admin: {$admin->name}", 'User', $admin->id, $changes);

        return response()->json(['message' => 'Admin updated successfully', 'admin' => $admin]);
    }

    public function resetPassword(Request $request, $id)
    {
        // Only super_admin can reset other admin passwords
        if (auth()->user()->admin_role !== 'super_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only Super Admin can reset admin passwords'
            ], 403);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $admin = User::findOrFail($id);
        $admin->update(['password' => Hash::make($validated['password'])]);

        ActivityLog::log('password_reset', "Reset password for admin: {$admin->name}", 'User', $admin->id);

        return response()->json(['message' => 'Password reset successfully']);
    }

    public function changeOwnPassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        ActivityLog::log('password_changed', "Changed own password");

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function toggleStatus($id)
    {
        // Only super_admin can toggle admin status
        if (auth()->user()->admin_role !== 'super_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only Super Admin can activate/deactivate admins'
            ], 403);
        }

        $admin = User::findOrFail($id);
        $admin->update(['is_active' => !$admin->is_active]);

        $status = $admin->is_active ? 'activated' : 'deactivated';
        ActivityLog::log('admin_status_changed', "Admin {$admin->name} {$status}", 'User', $admin->id);

        return response()->json(['message' => "Admin {$status} successfully", 'admin' => $admin]);
    }

    public function destroy($id)
    {
        // Only super_admin can delete admins
        if (auth()->user()->admin_role !== 'super_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only Super Admin can delete admin accounts'
            ], 403);
        }

        $admin = User::findOrFail($id);
        
        if ($admin->id === auth()->id()) {
            return response()->json(['message' => 'Cannot delete yourself'], 422);
        }

        $name = $admin->name;
        $admin->delete();

        ActivityLog::log('admin_deleted', "Deleted admin: {$name}", 'User', $id);

        return response()->json(['message' => 'Admin deleted successfully']);
    }

    public function activityLogs()
    {
        $logs = ActivityLog::with('user:id,name,email')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return response()->json(['logs' => $logs]);
    }
}
