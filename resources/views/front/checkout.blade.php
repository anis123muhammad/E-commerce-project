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

    {{-- Stripe JS must be loaded BEFORE the form --}}
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}

    <form action="{{ route('front.process-checkout') }}" method="POST" id="checkoutForm">
        @csrf

        {{-- Hidden input to hold the Stripe token --}}
        <input type="hidden" name="stripeToken" id="stripeToken">

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
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('country')
                                            <p class="text-danger small">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ old('address') }}</textarea>
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
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control">{{ old('order_notes') }}</textarea>
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
                                    <div class="h6"><strong>$<span id="subtotal_amount">{{ number_format($subtotal, 2) }}</span></strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="h6"><strong>Discount</strong></div>
                                    <div class="h6"><strong>$<span id="discount">{{ number_format($discount, 2) }}</span></strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong>$<span id="shipping_amount">{{ number_format($shipping, 2) }}</span></strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong>$<span id="total_amount">{{ number_format($total, 2) }}</span></strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="input-group apply-coupan mt-4">
                            <input type="text" id="coupon_code" placeholder="Coupon Code" class="form-control">
                            <button class="btn btn-dark" type="button" id="apply_coupon_btn">Apply Coupon</button>
                        </div>

                        <div class="card payment-form mt-3">
                            <h3 class="card-title h5 mb-3">Payment Details</h3>
                            <div class="card-body p-0">

                                <div class="mb-4">
                                    <label for="payment_method" class="mb-2">Select Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="form-control" onchange="togglePaymentFields(this.value)">
                                        <option value="">Choose payment method</option>
                                        <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                        <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Credit/Debit Card (Stripe)</option>
                                    </select>
                                    @error('payment_method')
                                        <p class="text-danger small">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Stripe Card Fields — mounted via Stripe Elements (secure, no raw card data) --}}
                                <div id="card_payment_fields" style="display: none;">
                                    <div class="mb-3">
                                        <label class="mb-2">Card Number</label>
                                        <div id="stripe-card-number" class="form-control" style="height: 38px; padding-top: 9px;"></div>
                                        <div id="card-number-errors" class="text-danger small mt-1"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="mb-2">Expiry Date</label>
                                            <div id="stripe-card-expiry" class="form-control" style="height: 38px; padding-top: 9px;"></div>
                                            <div id="card-expiry-errors" class="text-danger small mt-1"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="mb-2">CVV Code</label>
                                            <div id="stripe-card-cvc" class="form-control" style="height: 38px; padding-top: 9px;"></div>
                                            <div id="card-cvc-errors" class="text-danger small mt-1"></div>
                                        </div>
                                    </div>
                                    <div id="stripe-general-error" class="text-danger small mt-2"></div>
                                </div>

                                {{-- COD Message --}}
                                <div id="cod_message" style="display: none;" class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle"></i> You'll pay when you receive your order.
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="btn-dark btn btn-block w-100" id="submitBtn">Proceed to Payment</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </form>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection

@section('customjs')
<script>

// ─── Stripe Setup ─────────────────────────────────────────────────────────────
const stripePublicKey = "{{ config('stripe.stripe.key') }}";
const stripe = Stripe(stripePublicKey);
const elements = stripe.elements();

const cardStyle = {
    base: {
        fontSize: '14px',
        color: '#495057',
        '::placeholder': { color: '#6c757d' }
    },
    invalid: { color: '#dc3545' }
};

const cardNumber = elements.create('cardNumber', { style: cardStyle });
const cardExpiry = elements.create('cardExpiry', { style: cardStyle });
const cardCvc    = elements.create('cardCvc',    { style: cardStyle });

cardNumber.mount('#stripe-card-number');
cardExpiry.mount('#stripe-card-expiry');
cardCvc.mount('#stripe-card-cvc');

// Show inline errors per field
cardNumber.on('change', e => {
    document.getElementById('card-number-errors').innerText = e.error ? e.error.message : '';
});
cardExpiry.on('change', e => {
    document.getElementById('card-expiry-errors').innerText = e.error ? e.error.message : '';
});
cardCvc.on('change', e => {
    document.getElementById('card-cvc-errors').innerText = e.error ? e.error.message : '';
});


// ─── Toggle Payment Fields ─────────────────────────────────────────────────────
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


// ─── Form Submit ───────────────────────────────────────────────────────────────
document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const method = document.getElementById('payment_method').value;
    const submitBtn = document.getElementById('submitBtn');

    if (method === 'stripe') {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Processing...';

        document.getElementById('stripe-general-error').innerText = '';
        // createToken{
        //     token:{},
        //     error:{},
        //     nexxt:{},
        //     next:{},
        // }

        const { token, error } = await stripe.createToken(cardNumber, {
            name: document.getElementById('first_name').value + ' ' + document.getElementById('last_name').value
        });

        if (error) {
            // Show error to the user
            document.getElementById('stripe-general-error').innerText = error.message;
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Proceed to Payment';
            return;
        }

        // Insert token into the hidden field and submit
        document.getElementById('stripeToken').value = token.id;
        this.submit();

    } else {
        // COD — just submit directly
        this.submit();
    }
});

// ─── Country Change → Fetch Shipping ──────────────────────────────────────────
document.getElementById('country').addEventListener('change', function() {
    let countryId = this.value;
    let subtotal = parseFloat({{ $subtotal }});

    if (!countryId) {
        document.getElementById('shipping_amount').innerText = "0.00";
        document.getElementById('total_amount').innerText = subtotal.toFixed(2);
        return;
    }

    fetch("{{ route('front.getShipping') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ country_id: countryId })
    })
    .then(response => response.json())
    .then(data => {
        let shipping = parseFloat(data.shipping);
        let discount = parseFloat(document.getElementById('discount').innerText.replace(/[^0-9.]/g, '')) || 0;
        let total = subtotal + shipping - discount;

        document.getElementById('shipping_amount').innerText = shipping.toFixed(2);
        document.getElementById('total_amount').innerText = total.toFixed(2);
    })
    .catch(error => {
        console.error('Error fetching shipping:', error);
        document.getElementById('shipping_amount').innerText = "0.00";
        document.getElementById('total_amount').innerText = subtotal.toFixed(2);
    });
});

// ─── Apply Coupon ──────────────────────────────────────────────────────────────
document.getElementById('apply_coupon_btn').addEventListener('click', function() {
    let code = document.getElementById('coupon_code').value;

    fetch("{{ route('front.applyCoupon') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            let subtotal = parseFloat(document.getElementById('subtotal_amount').innerText.replace(/[^0-9.]/g, ''));
            let shipping = parseFloat(document.getElementById('shipping_amount').innerText.replace(/[^0-9.]/g, ''));

            document.getElementById('discount').innerText = data.discount.toFixed(2);

            let total = subtotal + shipping - data.discount;
            document.getElementById('total_amount').innerText = total.toFixed(2);

            alert('Coupon Applied Successfully');
        } else {
            alert(data.message);
        }
    });
});


// ─── On Page Load ──────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    // Restore previously selected payment method (after validation fail redirect)
    let paymentMethod = "{{ old('payment_method') }}";
    if (paymentMethod) {
        togglePaymentFields(paymentMethod);
    }

    // Restore country and re-fetch shipping if previously selected
    let countrySelect = document.getElementById('country');
    if (countrySelect.value) {
        countrySelect.dispatchEvent(new Event('change'));
    }

    // Always reset coupon field on load
    document.getElementById('coupon_code').value = '';
});

</script>
@endsection
