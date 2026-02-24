<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get user's cart with items
     */
    public function show(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart()->with('items.product')->first();

            if (!$cart) {
                $cart = $user->cart()->create();
            }

            $cartItems = $cart->items()->with('product')->get();

            $totalPrice = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'cart_id' => $cart->id,
                    'items' => $cartItems->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'cart_item_id' => $item->id,
                            'product_id' => $item->product_id,
                            'product' => [
                                'id' => $item->product->id,
                                'name' => $item->product->name,
                                'price' => $item->product->price,
                                'image' => $item->product->image,
                            ],
                            'quantity' => $item->quantity,
                            'subtotal' => $item->product->price * $item->quantity,
                        ];
                    }),
                    'total_price' => $totalPrice,
                    'total_items' => $cartItems->count(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add item to cart with stock validation
     */
    public function addItem(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::find($validated['product_id']);

            // Check product exists
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Check stock availability
            if ($product->stock <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product out of stock',
                    'available_stock' => 0
                ], 422);
            }

            // Validate requested quantity against available stock
            if ($validated['quantity'] > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity exceeds available stock',
                    'available_stock' => $product->stock,
                    'requested_quantity' => $validated['quantity']
                ], 422);
            }

            $user = $request->user();
            $cart = $user->cart;

            // Check if item already exists in cart
            $existingItem = $cart->items()->where('product_id', $validated['product_id'])->first();

            if ($existingItem) {
                $newQuantity = $existingItem->quantity + $validated['quantity'];
                
                // Validate total quantity doesn't exceed stock
                if ($newQuantity > $product->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Total quantity exceeds available stock',
                        'available_stock' => $product->stock,
                        'current_quantity' => $existingItem->quantity,
                        'requested_addition' => $validated['quantity'],
                        'total_would_be' => $newQuantity
                    ], 422);
                }

                // Update quantity
                $existingItem->update(['quantity' => $newQuantity]);
                $cartItem = $existingItem;
            } else {
                // Create new cart item
                $cartItem = $cart->items()->create([
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'data' => [
                    'id' => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'stock' => $product->stock,
                    ],
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $product->price * $cartItem->quantity,
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity with stock validation
     */
    public function updateItem(Request $request, $itemId)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $cartItem = CartItem::find($itemId);

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $product = $cartItem->product;

            // Check stock availability
            if ($product->stock <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product out of stock',
                    'available_stock' => 0
                ], 422);
            }

            // Validate new quantity against available stock
            if ($validated['quantity'] > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity exceeds available stock',
                    'available_stock' => $product->stock,
                    'requested_quantity' => $validated['quantity'],
                    'current_quantity' => $cartItem->quantity
                ], 422);
            }

            $cartItem->update(['quantity' => $validated['quantity']]);

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated',
                'data' => [
                    'id' => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'stock' => $product->stock,
                    ],
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $product->price * $cartItem->quantity,
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
                'message' => 'Failed to update cart item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem(Request $request, $itemId)
    {
        try {
            $cartItem = CartItem::find($itemId);

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart;

            $cart->items()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart count
     */
    public function count(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart;
            $count = $cart->items()->sum('quantity');

            return response()->json([
                'success' => true,
                'data' => [
                    'count' => $count
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get cart count',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
