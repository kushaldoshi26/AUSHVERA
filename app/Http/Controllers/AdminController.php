<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total_amount');
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
        $totalProducts = \App\Models\Product::count();
        $lowStockProducts = \App\Models\Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = \App\Models\Product::where('stock', 0)->count();
        
        // Today's stats
        $todayOrders = \App\Models\Order::whereDate('created_at', today())->count();
        $todayRevenue = \App\Models\Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')->sum('total_amount');
        
        // Monthly revenue (last 6 months)
        $monthlyRevenue = \App\Models\Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        return response()->json([
            'total_users' => User::where('role', 'user')->count(),
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'pending_orders' => $pendingOrders,
            'total_products' => $totalProducts,
            'low_stock_products' => $lowStockProducts,
            'out_of_stock_products' => $outOfStockProducts,
            'today_orders' => $todayOrders,
            'today_revenue' => $todayRevenue,
            'monthly_revenue' => $monthlyRevenue
        ]);
    }

    public function users()
    {
        $users = User::where('role', 'user')
            ->withCount('orders')
            ->latest()
            ->get();
        return response()->json(['users' => $users]);
    }

    public function getUser($id)
    {
        $user = User::withCount('orders')->findOrFail($id);
        return response()->json(['user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $id,
            'phone'    => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
            'state'    => 'nullable|string|max:100',
            'pincode'  => 'nullable|string|max:10',
            'address'  => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $user->update($validated);
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function reviews()
    {
        $reviews = Review::with('user')->latest()->get();
        return response()->json($reviews);
    }

    public function toggleReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => $request->is_approved]);
        return response()->json(['message' => 'Review updated']);
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response()->json(['message' => 'Review deleted']);
    }

    public function updatePricing(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->update($request->only(['price', 'original_price', 'discount']));
        return response()->json(['message' => 'Pricing updated', 'product' => $product]);
    }

    public function loginHistory()
    {
        $history = DB::table('login_history')
            ->join('users', 'login_history.user_id', '=', 'users.id')
            ->select('users.name', 'users.email', 'users.role', 'login_history.login_time', 'login_history.ip_address')
            ->orderBy('login_history.login_time', 'desc')
            ->get();
        return response()->json($history);
    }

    /**
     * Admin: list orders with pagination, filters and export
     */
    public function orders(Request $request)
    {
        $perPage = (int) $request->query('per_page', 20);
        $status = $request->query('status');
        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');

        $query = \App\Models\Order::with('user', 'items.product');

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            })->orWhere('id', $search);
        }

        $totalFound = $query->count();
        $orders = $query->orderBy($sortBy, $sortOrder)->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Orders retrieved successfully',
            'total_found' => $totalFound,
            'data' => $orders->items(),
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ]
        ], 200);
    }

    public function showOrder($id)
    {
        $order = \App\Models\Order::with(['user', 'items.product'])->find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id'             => $order->id,
                'total_amount'   => $order->total_amount,
                'status'         => $order->status,
                'payment_status' => $order->payment_status ?? 'pending',
                'payment_method' => $order->payment_method,
                'transaction_id' => $order->transaction_id,
                'user'           => $order->user ? [
                    'id'    => $order->user->id,
                    'name'  => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone,
                ] : null,
                'items'          => $order->items->map(function ($item) {
                    return [
                        'id'         => $item->id,
                        'product_id' => $item->product_id,
                        'product'    => $item->product ? ['id' => $item->product->id, 'name' => $item->product->name] : null,
                        'quantity'   => $item->quantity,
                        'price'      => $item->price,
                    ];
                }),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]
        ], 200);
    }

    /**
     * Export orders as CSV
     */
    public function exportOrders(Request $request)
    {
        $fileName = 'orders_export_' . date('Ymd_His') . '.csv';
        $orders = \App\Models\Order::with('user')->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($orders) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Order ID', 'User', 'Email', 'Total', 'Status', 'Payment Status', 'Created At']);
            foreach ($orders as $order) {
                fputcsv($out, [
                    $order->id,
                    $order->user->name ?? '',
                    $order->user->email ?? '',
                    $order->total_amount,
                    $order->status,
                    $order->payment_status ?? '',
                    $order->created_at,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
