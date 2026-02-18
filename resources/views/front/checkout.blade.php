@extends('front.layouts.app')


@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <form action="{{ route('front.process-checkout') }}" method="POST" id="checkoutForm">
@csrf

    <section class="section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}">
                                    </div>
                                    @error('first_name')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}">
                                    </div>
                                    @error('last_name')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                                    </div>
                                    @error('email')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                       <select name="country" id="country" class="form-control">
    <option value="">Select a Country</option>
    @foreach ($countries as $country)
    <option value="{{ $country->id }}">{{ $country->name }}</option>
    @endforeach
</select>
                                    </div>
                                    @error('country')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" value="{{ old('address') }}" class="form-control"></textarea>
                                    </div>
                                    @error('address')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="appartment" id="appartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('appartment') }}">
                                    </div>
                                    @error('appartment')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ old('city') }}">
                                    </div>
                                    @error('city')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ old('state') }}">
                                    </div>
                                    @error('state')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{ old('zip') }}">
                                    </div>
                                    @error('zip')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{ old('mobile') }}">
                                    </div>
                                    @error('mobile')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control" value="{{ old('order_notes') }}" ></textarea>
                                    </div>
                                    @error('order_notes')
    <p class="text-danger small">{{ $message }}</p>
@enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
<div class="sub-title">
    <h2>Order Summary</h2>
</div>

@forelse ($cart as $id => $item)
<div class="card cart-summary mb-2">
    <div class="card-body">

        <div class="d-flex justify-content-between pb-2">
            <div class="h6">{{ $item['title'] }} (x{{ $item['qty'] }})</div>
            <div class="h6">${{ $item['price'] }}</div>
        </div>

        <div class="d-flex justify-content-between summery-end">
            @if(isset($item['subtitle']))
                <div class="h6"><strong>{{ $item['subtitle'] }}</strong></div>
            @endif
            <div class="h6"><strong>${{ $item['price'] * $item['qty'] }}</strong></div>
        </div>

    </div>
</div>
@empty
<p>Your cart is empty.</p>
@endforelse

<div class="card cart-summary mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="h6"><strong>Subtotal</strong></div>
            <div class="h6"><strong>${{ number_format($subtotal, 2) }}</strong></div>
        </div>

        <div class="d-flex justify-content-between">
            <div class="h6"><strong>Shipping</strong></div>
            <div class="h6"><strong>${{ number_format($shipping, 2) }}</strong></div>
        </div>

        <div class="d-flex justify-content-between mt-2">
            <div class="h5"><strong>Total</strong></div>
            <div class="h5"><strong>${{ number_format($total, 2) }}</strong></div>
        </div>
    </div>
</div>


{{-- <div class="card cart-summary mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="h6"><strong>Subtotal</strong></div>
            <div class="h6"><strong>${{ $subtotal }}</strong></div>
        </div>

        <div class="d-flex justify-content-between">
            <div class="h6"><strong>Shipping</strong></div>
            <div class="h6"><strong>${{ $shipping }}</strong></div>
        </div>

        <div class="d-flex justify-content-between mt-2">
            <div class="h5"><strong>Total</strong></div>
            <div class="h5"><strong>${{ $total }}</strong></div>
        </div>
    </div>
</div> --}}


                  <div class="card payment-form">
    <h3 class="card-title h5 mb-3">Payment Details</h3>
    <div class="card-body p-0">
        <!-- Payment Method Selection -->
        <div class="mb-4">
            <label for="payment_method" class="mb-2">Select Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" onchange="togglePaymentFields(this.value)">
                <option value="">Choose payment method</option>
                <option value="cod">Cash on Delivery (COD)</option>
                <option value="stripe">Credit/Debit Card (Stripe)</option>
            </select>
        </div>

        <!-- Card Payment Fields (Hidden by default) -->
        <div id="card_payment_fields" style="display: none;">
            <div class="mb-3">
                <label for="card_number" class="mb-2">Card Number</label>
                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="cvv_code" class="mb-2">CVV Code</label>
                    <input type="text" name="cvv_code" id="cvv_code" placeholder="123" class="form-control">
                </div>
            </div>
        </div>

        <!-- COD Message (Hidden by default) -->
        <div id="cod_message" style="display: none;" class="alert alert-info mt-3">
            <i class="fas fa-info-circle"></i> You'll pay when you receive your order.
        </div>

        <div class="pt-4">
            <button type="submit" class="btn-dark btn btn-block w-100">Proceed to Payment</button>
        </div>
    </div>
</div>

<!-- JavaScript to toggle payment fields -->
<script>
function togglePaymentFields(method) {
    const cardFields = document.getElementById('card_payment_fields');
    const codMessage = document.getElementById('cod_message');

    if (method === 'stripe') {
        cardFields.style.display = 'block';
        codMessage.style.display = 'none';
    } else if (method === 'cod') {
        cardFields.style.display = 'none';
        codMessage.style.display = 'block';
    } else {
        cardFields.style.display = 'none';
        codMessage.style.display = 'none';
    }
}
</script>

<!-- Add Font Awesome for icons (optional) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
            </div>
        </div>
    </section>


</form>

@endsection

<script>
    document.getElementById('checkoutForm').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Processing...';
});
</script>

