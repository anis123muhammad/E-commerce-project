<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;

class CouponsCodeController extends Controller
{
    // ==============================
    // INDEX
    // ==============================
    public function index()
    {
        $coupons = DiscountCoupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    // ==============================
    // CREATE
    // ==============================
    public function create()
    {
        return view('admin.coupons.create');
    }

    // ==============================
    // STORE
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:discount_coupons,code',
            'name' => 'required|string',
            'description' => 'required|string',
            'max_users' => 'required|integer|min:1',
            'max_user_uses' => 'required|integer|min:1',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'minimum_amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
        ]);

        DiscountCoupon::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'max_uses' => $request->max_users,
            'max_uses_per_user' => $request->max_user_uses,
            'type' => $request->type,
            'discount_amount' => $request->discount_amount,
            'min_amount' => $request->minimum_amount,
            'status' => $request->status,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    // ==============================
    // EDIT
    // ==============================
    public function edit($id)
    {
        $coupon = DiscountCoupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    // ==============================
    // UPDATE
    // ==============================
    public function update(Request $request, $id)
    {
        $coupon = DiscountCoupon::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:discount_coupons,code,' . $id,
            'name' => 'required|string',
            'description' => 'required|string',
            'max_users' => 'required|integer|min:1',
            'max_user_uses' => 'required|integer|min:1',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'minimum_amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
        ]);

        $coupon->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'max_uses' => $request->max_users,
            'max_uses_per_user' => $request->max_user_uses,
            'type' => $request->type,
            'discount_amount' => $request->discount_amount,
            'min_amount' => $request->minimum_amount,
            'status' => $request->status,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    // ==============================
    // DELETE
    // ==============================
    public function destroy($id)
    {
        $coupon = DiscountCoupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }
}
