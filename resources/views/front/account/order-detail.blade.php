@extends('user_auth.layouts.app')

@section('content')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
    @include('front.account_layouts.app')                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>

                        <div class="card-body pb-0">
                            <!-- Info -->
                            <div class="card card-sm">
                                <div class="card-body bg-light mb-3">
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order No:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                            {{ $order->id }}
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Shipped date:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                <time datetime="2019-10-01">
                                                   {{ $order->created_at->format('d M, Y') }}
                                                </time>
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Status:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
{{ ucfirst($order->status) }}                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
${{ number_format($order->grand_total, 2) }}                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer p-3">

                            <!-- Heading -->
                            <h6 class="mb-7 h5 mt-4">Order Items ({{ $order->items->count() }})</h6>

                            <!-- Divider -->
                            <hr class="my-3">

                            <!-- List group -->
                       <ul>
@foreach($order->items as $item)
<li class="list-group-item">
    <div class="row align-items-center">
        <div class="col">
            <p class="mb-4 fs-sm fw-bold">
                {{ $item->name }} x {{ $item->qty }} <br>
                <span class="text-muted">
                    ${{ number_format($item->price, 2) }}
                </span>
            </p>
        </div>
    </div>
</li>
@endforeach
</ul>
                        </div>
                    </div>

                    <div class="card card-lg mb-5 mt-3">
                        <div class="card-body">
                            <!-- Heading -->
                            <h6 class="mt-0 mb-3 h5">Order Total</h6>

                            <!-- List group -->
                            <ul>
                               <li class="list-group-item d-flex">
    <span>Subtotal</span>
    <span class="ms-auto">${{ number_format($order->subtotal, 2) }}</span>
</li>

<li class="list-group-item d-flex">
    <span>Shipping</span>
    <span class="ms-auto">${{ number_format($order->shipping, 2) }}</span>
</li>

<li class="list-group-item d-flex fs-lg fw-bold">
    <span>Total</span>
    <span class="ms-auto">${{ number_format($order->grand_total, 2) }}</span>
</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>z
    @endsection
