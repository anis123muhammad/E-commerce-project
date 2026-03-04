<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        return view('admin.order.order', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.order.order-detail', compact('order'));
    }

    public function updateStatusAjax(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $order->status
        ]);
    }

public function sendInvoiceEmail(Request $request)
{
    try {
        // Accept JSON input
        $orderId   = $request->input('order_id');
        $emailType = $request->input('email_type');

        // Validate
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'email_type' => 'required|in:customer,admin'
        ]);

        // Load order with items and product details
        $order = Order::with('items.product')->findOrFail($orderId);

        // Determine recipient
        $recipient = $emailType === 'customer' ? $order->email : env('MAIL_FROM_ADDRESS');

        // Send email
        Mail::to($recipient)->send(new OrderInvoiceMail($order, $emailType));

        return response()->json([
            'success' => true,
            'message' => 'Invoice email sent successfully!'
        ]);

    } catch (\Exception $e) {
        // Catch SMTP or any errors
        return response()->json([
            'success' => false,
            'message' => 'Email failed: ' . $e->getMessage()
        ], 500);
    }
} }
