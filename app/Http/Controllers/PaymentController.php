<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Verify Razorpay payment signature
     */
    public function verifyPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'razorpay_order_id' => 'required|string',
                'razorpay_payment_id' => 'required|string',
                'razorpay_signature' => 'required|string',
                'order_id' => 'required|exists:orders,id'
            ]);

            $orderId = $validated['razorpay_order_id'];
            $paymentId = $validated['razorpay_payment_id'];
            $signature = $validated['razorpay_signature'];

            // Generate signature for verification
            $secret = config('services.razorpay.secret');
            $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);

            // Verify signature
            if ($generatedSignature !== $signature) {
                Log::error('Payment signature verification failed', [
                    'order_id' => $validated['order_id'],
                    'razorpay_order_id' => $orderId,
                    'razorpay_payment_id' => $paymentId
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification failed'
                ], 400);
            }

            // Update order status
            $order = Order::find($validated['order_id']);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $order->update([
                'payment_status' => 'paid',
                'payment_method' => 'razorpay',
                'transaction_id' => $paymentId,
                'razorpay_order_id' => $orderId,
                'status' => 'processing'
            ]);

            Log::info('Payment verified successfully', [
                'order_id' => $order->id,
                'payment_id' => $paymentId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'data' => [
                    'order_id' => $order->id,
                    'payment_id' => $paymentId,
                    'status' => $order->status
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Payment verification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Razorpay webhook handler
     */
    public function webhook(Request $request)
    {
        try {
            $webhookSecret = config('services.razorpay.webhook_secret');
            $webhookSignature = $request->header('X-Razorpay-Signature');
            $webhookBody = $request->getContent();

            // Verify webhook signature
            $expectedSignature = hash_hmac('sha256', $webhookBody, $webhookSecret);

            if ($webhookSignature !== $expectedSignature) {
                Log::error('Webhook signature verification failed');
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $payload = json_decode($webhookBody, true);
            $event = $payload['event'];

            // Handle different webhook events
            switch ($event) {
                case 'payment.captured':
                    $this->handlePaymentCaptured($payload['payload']['payment']['entity']);
                    break;

                case 'payment.failed':
                    $this->handlePaymentFailed($payload['payload']['payment']['entity']);
                    break;

                case 'order.paid':
                    $this->handleOrderPaid($payload['payload']['order']['entity']);
                    break;

                default:
                    Log::info('Unhandled webhook event', ['event' => $event]);
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('Webhook processing error', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    private function handlePaymentCaptured($payment)
    {
        $orderId = $payment['notes']['order_id'] ?? null;
        
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $payment['id'],
                    'status' => 'processing'
                ]);
                
                Log::info('Payment captured via webhook', ['order_id' => $orderId]);
            }
        }
    }

    private function handlePaymentFailed($payment)
    {
        $orderId = $payment['notes']['order_id'] ?? null;
        
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);
                
                // Restore stock
                foreach ($order->items as $item) {
                    \App\Models\Product::where('id', $item->product_id)
                        ->increment('stock', $item->quantity);
                }
                
                Log::info('Payment failed via webhook', ['order_id' => $orderId]);
            }
        }
    }

    private function handleOrderPaid($orderData)
    {
        Log::info('Order paid webhook received', ['order_data' => $orderData]);
    }
}
