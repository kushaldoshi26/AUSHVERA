<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function topProducts()
    {
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', 
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        return response()->json(['top_products' => $topProducts]);
    }

    public function topCustomers()
    {
        $topCustomers = Order::select('user_id', 
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_spent'))
            ->with('user:id,name,email')
            ->groupBy('user_id')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        return response()->json(['top_customers' => $topCustomers]);
    }

    public function salesReport(Request $request)
    {
        $period = $request->query('period', 'month'); // day, week, month, year
        
        $query = Order::where('payment_status', 'paid');
        
        switch ($period) {
            case 'day':
                $data = $query->whereDate('created_at', today())
                    ->selectRaw('HOUR(created_at) as period, COUNT(*) as orders, SUM(total_amount) as revenue')
                    ->groupBy('period')
                    ->get();
                break;
            case 'week':
                $data = $query->where('created_at', '>=', now()->subDays(7))
                    ->selectRaw('DATE(created_at) as period, COUNT(*) as orders, SUM(total_amount) as revenue')
                    ->groupBy('period')
                    ->get();
                break;
            case 'year':
                $data = $query->where('created_at', '>=', now()->subYear())
                    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as orders, SUM(total_amount) as revenue')
                    ->groupBy('period')
                    ->get();
                break;
            default: // month
                $data = $query->where('created_at', '>=', now()->subMonth())
                    ->selectRaw('DATE(created_at) as period, COUNT(*) as orders, SUM(total_amount) as revenue')
                    ->groupBy('period')
                    ->get();
        }

        return response()->json(['sales_data' => $data, 'period' => $period]);
    }

    public function exportOrders(Request $request)
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();

        $csv = "Order ID,Customer Name,Email,Total Amount,Status,Payment Status,Created At\n";
        
        foreach ($orders as $order) {
            $csv .= sprintf(
                "%d,%s,%s,%.2f,%s,%s,%s\n",
                $order->id,
                $order->user->name ?? 'Guest',
                $order->user->email ?? '',
                $order->total_amount,
                $order->status,
                $order->payment_status ?? 'pending',
                $order->created_at->format('Y-m-d H:i:s')
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="orders_' . date('Y-m-d') . '.csv"');
    }

    public function exportUsers()
    {
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->get();

        $csv = "ID,Name,Email,Phone,City,Joined Date\n";
        
        foreach ($users as $user) {
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,%s\n",
                $user->id,
                $user->name,
                $user->email,
                $user->phone ?? '',
                $user->city ?? '',
                $user->created_at->format('Y-m-d')
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="users_' . date('Y-m-d') . '.csv"');
    }

    public function exportProducts()
    {
        $products = Product::orderBy('name')->get();

        $csv = "ID,Name,Category,Price,Stock,Status\n";
        
        foreach ($products as $product) {
            $status = $product->stock == 0 ? 'Out of Stock' : ($product->stock < 10 ? 'Low Stock' : 'In Stock');
            $csv .= sprintf(
                "%d,%s,%s,%.2f,%d,%s\n",
                $product->id,
                $product->name,
                $product->category ?? 'Uncategorized',
                $product->price,
                $product->stock,
                $status
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="products_' . date('Y-m-d') . '.csv"');
    }
}
