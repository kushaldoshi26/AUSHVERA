<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function adjustStock(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'type' => 'required|in:adjustment,restock,return',
            'notes' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request, $productId) {
            $product = Product::lockForUpdate()->findOrFail($productId);
            
            $stockBefore = $product->stock;
            $product->stock += $request->quantity;
            $product->save();

            StockHistory::create([
                'product_id' => $product->id,
                'quantity_change' => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $product->stock,
                'type' => $request->type,
                'reference_type' => 'manual',
                'user_id' => auth()->id(),
                'notes' => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'product' => $product,
                'message' => 'Stock adjusted successfully'
            ]);
        });
    }

    public function getLowStock()
    {
        $products = Product::where('track_inventory', true)
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->with('category')
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
            'count' => $products->count()
        ]);
    }

    public function getStockHistory($productId)
    {
        $history = StockHistory::where('product_id', $productId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'history' => $history
        ]);
    }

    public function bulkUpdateStock(Request $request)
    {
        $request->validate([
            'updates' => 'required|array',
            'updates.*.product_id' => 'required|exists:products,id',
            'updates.*.stock' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->updates as $update) {
                $product = Product::lockForUpdate()->find($update['product_id']);
                $stockBefore = $product->stock;
                $product->stock = $update['stock'];
                $product->save();

                StockHistory::create([
                    'product_id' => $product->id,
                    'quantity_change' => $update['stock'] - $stockBefore,
                    'stock_before' => $stockBefore,
                    'stock_after' => $product->stock,
                    'type' => 'adjustment',
                    'reference_type' => 'bulk_update',
                    'user_id' => auth()->id(),
                    'notes' => 'Bulk stock update'
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully'
        ]);
    }

    public function getInventoryStats()
    {
        $totalProducts = Product::count();
        $lowStockCount = Product::where('track_inventory', true)
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->count();
        $outOfStockCount = Product::where('track_inventory', true)
            ->where('stock', '<=', 0)
            ->count();
        $totalStockValue = Product::sum(DB::raw('stock * price'));

        return response()->json([
            'success' => true,
            'stats' => [
                'total_products' => $totalProducts,
                'low_stock_count' => $lowStockCount,
                'out_of_stock_count' => $outOfStockCount,
                'total_stock_value' => $totalStockValue
            ]
        ]);
    }
}
