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

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

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
                         <tbody>

@php $subtotal = 0; @endphp

@if(count($cart) > 0)

    @foreach($cart as $id => $item)

        @php
            $total = $item['price'] * $item['qty'];
            $subtotal += $total;
        @endphp

        <tr>
            <!-- Product -->
            <td>
                <div class="d-flex align-items-center justify-content-center">
                                           @if(!empty($item['image']))
    <img src="{{ asset('uploads/products/'.$item['image']) }}" width="50">
@else
    <img src="{{ asset('uploads/products/no-image.jpg') }}" width="50">
@endif
                    <h2>{{ $item['title'] }}</h2>
                </div>
            </td>

            <!-- Price -->
            <td>${{ $item['price'] }}</td>

            <!-- Quantity -->
            <td>
                <div class="input-group quantity mx-auto" style="width: 100px;">

                    <!-- Minus -->
                    <form action="{{ route('cart.minus', $id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-dark p-2">
                            <i class="fa fa-minus"></i>
                        </button>
                    </form>

                    <input type="text"
                           class="form-control form-control-sm border-0 text-center"
                           value="{{ $item['qty'] }}" readonly>

                    <!-- Plus -->
                    <form action="{{ route('cart.plus', $id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-dark p-2">
                            <i class="fa fa-plus"></i>
                        </button>
                    </form>

                </div>
            </td>

            <!-- Total -->
            <td>${{ $total }}</td>

            <!-- Remove -->
            <td>
                <form action="{{ route('cart.remove', $id) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </td>
        </tr>

    @endforeach

@else
    <tr>
        <td colspan="5" class="text-center">
            Cart is empty
        </td>
    </tr>
@endif

</tbody>

                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div>
                        <div class="card-body">
                            @php $shipping = 20; @endphp

                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>${{ $subtotal }}</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>${{ $shipping  }}</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>${{ $subtotal + $shipping }}</div>
                            </div>
                            <div class="pt-5">
                                <a href="login.php" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
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

@endsection
