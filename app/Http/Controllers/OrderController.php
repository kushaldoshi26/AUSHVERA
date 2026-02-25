<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get user's orders
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $orders = $user->orders()->orderBy('created_at', 'desc')->get();

            $formattedOrders = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'item_count' => $order->items()->count(),
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully',
                'data' => $formattedOrders
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Simulate payment for an order (updates payment status and order status)
     */
    public function pay(Request $request, $orderId)
    {
        try {
            $validated = $request->validate([
                'method' => 'required|string'
            ]);

            $user = $request->user();
            $order = Order::where('user_id', $user->id)->find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if ($order->payment_status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order already paid'
                ], 422);
            }

            // Simulate payment gateway response
            $transactionId = 'txn_' . bin2hex(random_bytes(6));

            $order->update([
                'payment_status' => 'paid',
                'payment_method' => $validated['method'],
                'transaction_id' => $transactionId,
                'status' => 'processing'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'data' => [
                    'order_id' => $order->id,
                    'transaction_id' => $transactionId,
                    'status' => $order->status,
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific order with items
     */
    public function show(Request $request, $orderId)
    {
        try {
            $user = $request->user();
            $order = Order::where('user_id', $user->id)->find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $orderItems = $order->items()->with('product')->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $order->id,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'items' => $orderItems->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product' => [
                                'id' => $item->product->id,
                                'name' => $item->product->name,
                                'image' => $item->product->image,
                            ],
                            'quantity' => $item->quantity,
                            'price_at_purchase' => $item->price,
                            'subtotal' => $item->quantity * $item->price,
                        ];
                    }),
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Checkout cart and create order (atomic transaction)
     */
    public function checkout(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart;

            // Check if cart is empty
            $cartItems = $cart->items()->with('product')->get();
            
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 422);
            }

            // Use database transaction to ensure atomic operation
            $order = DB::transaction(function () use ($user, $cart, $cartItems) {
                // Validate all items and calculate total
                $totalAmount = 0;
                $orderItemsData = [];

                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;

                    // Validate product still exists
                    if (!$product) {
                        throw new \Exception("Product not found for cart item {$cartItem->id}");
                    }

                    // Validate stock is still available
                    if ($product->track_inventory && $product->stock < $cartItem->quantity) {
                        throw new \Exception(
                            "Insufficient stock for {$product->name}. " .
                            "Available: {$product->stock}, Requested: {$cartItem->quantity}"
                        );
                    }

                    // Calculate subtotal with price snapshot
                    $subtotal = $product->price * $cartItem->quantity;
                    $totalAmount += $subtotal;

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $cartItem->quantity,
                        'price' => $product->price, // Snapshot current price
                    ];
                }

                // Validate total amount
                if ($totalAmount <= 0) {
                    throw new \Exception("Order total amount is invalid");
                }

                // Create order
                $order = $user->orders()->create([
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                ]);

                // Create order items with price snapshot and decrement stock
                foreach ($orderItemsData as $itemData) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                    ]);

                    // Decrement product stock and log history
                    $product = Product::lockForUpdate()->find($itemData['product_id']);
                    if ($product->track_inventory) {
                        $stockBefore = $product->stock;
                        $product->decrement('stock', $itemData['quantity']);
                        
                        StockHistory::create([
                            'product_id' => $product->id,
                            'quantity_change' => -$itemData['quantity'],
                            'stock_before' => $stockBefore,
                            'stock_after' => $product->stock,
                            'type' => 'sale',
                            'reference_type' => 'order',
                            'reference_id' => $order->id,
                            'user_id' => $user->id
                        ]);
                    }
                }

                // Clear cart items after successful order creation
                $cart->items()->delete();

                return $order;
            });

            // Fetch order with items for response
            $orderItems = $order->items()->with('product')->get();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'id' => $order->id,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'items' => $orderItems->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name,
                            'quantity' => $item->quantity,
                            'price_at_purchase' => $item->price,
                            'subtotal' => $item->quantity * $item->price,
                        ];
                    }),
                    'created_at' => $order->created_at,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update order status (admin only - used in payment processing)
     */
    public function updateStatus(Request $request, $orderId)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
                'payment_status' => 'sometimes|in:pending,paid,failed,refunded',
            ]);

            $order = Order::find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $updateData = ['status' => $validated['status']];
            if (isset($validated['payment_status'])) {
                $updateData['payment_status'] = $validated['payment_status'];
            }
            $order->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated',
                'data' => [
                    'id' => $order->id,
                    'status' => $order->status,
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel order (if not yet shipped) and restore stock
     */
    public function cancel(Request $request, $orderId)
    {
        try {
            $user = $request->user();
            $order = Order::where('user_id', $user->id)->find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (in_array($order->status, ['shipped', 'delivered', 'cancelled'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot cancel order with status: {$order->status}"
                ], 422);
            }

            DB::transaction(function () use ($order, $user) {
                // Restore stock for all items
                foreach ($order->items as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product->track_inventory) {
                        $stockBefore = $product->stock;
                        $product->increment('stock', $item->quantity);
                        
                        StockHistory::create([
                            'product_id' => $product->id,
                            'quantity_change' => $item->quantity,
                            'stock_before' => $stockBefore,
                            'stock_after' => $product->stock,
                            'type' => 'return',
                            'reference_type' => 'order',
                            'reference_id' => $order->id,
                            'user_id' => $user->id,
                            'notes' => 'Order cancelled'
                        ]);
                    }
                }
                
                $order->update(['status' => 'cancelled']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully and stock restored',
                'data' => [
                    'id' => $order->id,
                    'status' => $order->status,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

