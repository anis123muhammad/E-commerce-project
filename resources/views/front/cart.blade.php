@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div id="cart-alert"></div>

                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
                                @php
                                    $cart = session()->get('cart', []);
                                    $subtotal = 0;
                                @endphp

                                @if(count($cart) > 0)
                                    @foreach($cart as $id => $item)
                                        @php $subtotal += $item['price'] * $item['qty']; @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="{{ $item['image'] ? asset('uploads/products/'.$item['image']) : asset('uploads/products/no-image.jpg') }}" width="50">
                                                    <h2>{{ $item['title'] }}</h2>
                                                </div>
                                            </td>
                                            <td>${{ $item['price'] }}</td>
                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <button class="btn btn-sm btn-dark btn-minus p-2" data-id="{{ $id }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input type="text" class="form-control form-control-sm border-0 text-center" value="{{ $item['qty'] }}" readonly>
                                                    <button class="btn btn-sm btn-dark btn-plus p-2" data-id="{{ $id }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>${{ $item['price'] * $item['qty'] }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger btn-remove" data-id="{{ $id }}">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Cart is empty</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div id="subtotal">${{ $subtotal }}</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div id="shipping">$20</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div id="total">${{ $subtotal + 20 }}</div>
                            </div>
                            <div class="pt-5">
                                <a href="{{ route('front.checkout') }}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    $(document).ready(function() {
        // Handle all button clicks
        $(document).on('click', '.btn-plus, .btn-minus, .btn-remove', function() {
            let id = $(this).data('id');
            let action = $(this).hasClass('btn-plus') ? 'plus' :
                        $(this).hasClass('btn-minus') ? 'minus' : 'remove';

            if (action == 'remove' && !confirm('Remove this item?')) return;

            handleCart(id, action);
        });
    });

    function handleCart(id, action) {
        let url = action == 'remove' ? '{{ route("cart.remove") }}' : '{{ route("cart.update") }}';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                action: action
            },
            success: function(res) {
                if (res.success) {
                    updateCart(res.cart, res.subtotal, res.shipping, res.total);
                    showMessage('success', res.message);
                } else {
                    showMessage('danger', res.message);
                }
            }
        });
    }

    function updateCart(cart, subtotal, shipping, total) {
        let html = '';

        if (Object.keys(cart).length > 0) {
            $.each(cart, function(id, item) {
                html += `<tr>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="{{ asset('uploads/products') }}/${item.image || 'no-image.jpg'}" width="50">
                            <h2>${item.title}</h2>
                        </div>
                    </td>
                    <td>$${item.price}</td>
                    <td>
                        <div class="input-group quantity mx-auto" style="width: 100px;">
                            <button class="btn btn-sm btn-dark btn-minus p-2" data-id="${id}">
                                <i class="fa fa-minus"></i>
                            </button>
                            <input type="text" class="form-control form-control-sm border-0 text-center" value="${item.qty}" readonly>
                            <button class="btn btn-sm btn-dark btn-plus p-2" data-id="${id}">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>$${(item.price * item.qty).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger btn-remove" data-id="${id}">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>`;
            });
        } else {
            html = '<tr><td colspan="5" class="text-center">Cart is empty</td></tr>';
        }

        $('#cart-body').html(html);
        $('#subtotal').text('$' + subtotal);
        $('#shipping').text('$' + shipping);
        $('#total').text('$' + total);
    }

    function showMessage(type, msg) {
        $('#cart-alert').html(`
            <div class="alert alert-${type} alert-dismissible fade show">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        setTimeout(() => $('#cart-alert').html(''), 3000);
    }
    </script>
@endsection
