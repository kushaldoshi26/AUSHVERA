<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return response()->json(Coupon::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean'
        ]);

        $coupon = Coupon::create($validated);
        return response()->json($coupon, 201);
    }

    public function show($id)
    {
        return response()->json(Coupon::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());
        return response()->json($coupon);
    }

    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return response()->json(['message' => 'Coupon deleted']);
    }

    public function toggle(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['is_active' => $request->is_active]);
        return response()->json($coupon);
    }

    public function validate(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Invalid coupon code'], 404);
        }

        if ($coupon->valid_until && $coupon->valid_until < now()) {
            return response()->json(['valid' => false, 'message' => 'Coupon has expired'], 400);
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['valid' => false, 'message' => 'Coupon usage limit reached'], 400);
        }

        return response()->json(['valid' => true, 'coupon' => $coupon]);
    }
}
