@extends('front.layouts.app')

@section('content')
<div class="thank-you-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <!-- Success Icon -->
                <div class="success-icon mb-4">
                    <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                </div>

                <!-- Thank You Message -->
                <h1 class="mb-3">Thank You for Your Order!</h1>

                <p class="lead mb-4">
                    Your order has been successfully placed.
                </p>

             <!-- Order Details Card with Real Data -->
@if(isset($order) && $order)
    <div class="order-details card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order Summary</h5>
            <p class="mb-2">Order #: <strong class="text-primary">{{ $order->id }}</strong></p>
            <p class="mb-2">Date: <strong>{{ $order->created_at->format('F j, Y') }}</strong></p>
            <p class="mb-2">Name: <strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
            <p class="mb-2">Email: <strong>{{ $order->email }}</strong></p>
            <p class="mb-2">Payment Method: <strong>{{ strtoupper($order->payment_method) }}</strong></p>
            <p class="mb-0">Total Amount: <strong class="text-success">${{ number_format($order->grand_total, 2) }}</strong></p>
        </div>
    </div>

    <!-- Order Items -->
    <div class="order-items card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Order Items</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead class="text-muted">
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <!-- Simple version with just Order ID -->
    <div class="order-details card mb-4">
        <div class="card-body">
            <h5 class="card-title">Your Order Placed</h5>
            <p class="mb-0">Your Order ID: <strong class="text-primary">{{ session('order_id') ?? 'ORD-'  }}</strong></p>
        </div>
    </div>
@endif

                <!-- Confirmation Message -->
                <p class="text-muted mb-4">
                    We've sent a confirmation email to <strong>{{ $order->email ?? 'your email' }}</strong>.<br>
                    You will be notified once your order is shipped.
                </p>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('front.shop') }}" class="btn btn-primary btn-lg me-2">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-truck"></i> Track Order
                    </a>
                </div>

                <!-- Additional Information -->
                <div class="mt-5 pt-4 border-top">
                    <p class="small text-muted">
                        Need help? <a href="{{ route('contact') }}">Contact our support team</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.thank-you-page {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 70vh;
}

.success-icon {
    animation: scaleIn 0.5s ease-in-out;
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.order-details, .order-items {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}

.order-items .table {
    margin-bottom: 0;
}

.order-items .table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.9rem;
}

.order-items .table td {
    padding: 0.75rem;
    vertical-align: middle;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 12px 30px;
    border-radius: 25px;
    transition: all 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}

.btn-outline-secondary {
    padding: 12px 30px;
    border-radius: 25px;
    transition: all 0.3s;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108,117,125,0.3);
}

@media (max-width: 768px) {
    .thank-you-page {
        padding: 40px 0;
    }

    .action-buttons .btn {
        display: block;
        width: 100%;
        margin: 10px 0;
    }

    .action-buttons .btn.me-2 {
        margin-right: 0 !important;
    }

    .order-items .table {
        font-size: 0.9rem;
    }
}
</style>
@endpush
