@extends('front.layouts.app')

@section('content')

    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href=" {{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">{{ $product->title }}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner bg-light">
                    @if($product->images->count() > 0)
                        @foreach($product->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img class="w-100 h-100" src="{{ asset('uploads/products/' . $image->image) }}" alt="{{ $product->title }}">
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('images/no-image.jpg') }}" alt="No Image">
                        </div>
                    @endif
                </div>
                @if($product->images->count() > 1)
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="col-md-7">
            <div class="bg-light right">
                <h1>{{ $product->title }}</h1>

                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(99 Reviews)</small>
                </div>

                @if($product->compare_price)
                    <h2 class="price text-secondary"><del>${{ number_format($product->compare_price, 2) }}</del></h2>
                @endif
                <h2 class="price">${{ number_format($product->price, 2) }}</h2>

                <p>{{ $product->short_description ?? 'No description available.' }}</p>

                {{-- @if($product->track_qty == 'Yes')
                    @if($product->qty > 0)
                        <p class="text-success"><strong>In Stock ({{ $product->qty }} available)</strong></p>
                    @else
                        <p class="text-danger"><strong>Out of Stock</strong></p>
                    @endif
                @endif --}}

                <form action="{{ route('front.cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <button class="btn btn-dark">
        <i class="fas fa-shopping-cart"></i> ADD TO CART
    </button>
</form>


<div class="product-barcode mb-3">
    <h4>Barcode:</h4>
    <p>{{ $product->barcode }}</p>

    @if(!empty($product->barcode_image))
        <img src="{{ asset($product->barcode_image) }}"
             alt="Barcode for {{ $product->title }}"
             style="max-width: 40%; height: auto;">
    @endif
</div>

            </div>
        </div>

        <div class="col-md-12 mt-5">
            <div class="bg-light">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab"
                                aria-controls="description" aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                                data-bs-target="#shipping" type="button" role="tab"
                                aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                data-bs-target="#reviews" type="button" role="tab"
                                aria-controls="reviews" aria-selected="false">Reviews</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
    <p>{{ $product->description }}</p>
</div>

<div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
    <p>{{ $product->shipping_returns }}</p>
</div>

                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <p>No reviews yet.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
    </section>

    <section class="pt-5 section-8">
        <div class="container">
    <div class="section-title">
        <h2>Related Products</h2>
    </div>

    <div class="col-md-12">
        <div id="related-products" class="carousel">

            @foreach($relatedProducts as $product)
                <div class="card product-card">
                    <div class="product-image position-relative">

                        <!-- Product Image -->
                        <a href="{{ route('front.product', $product->slug) }}" class="product-img">
                            <img class="card-img-top"
                                 src="{{ $product->firstImage
                                        ? asset('uploads/products/thumbs/' . $product->firstImage->image)
                                        : asset('front-assets/images/no-image.png') }}"
                                 alt="">
                        </a>

                        <!-- Wishlist -->
                        <a class="whishlist" href="#">
                            <i class="far fa-heart"></i>
                        </a>

                        <!-- Add To Cart -->
                        <div class="product-action">
                         <form action="{{ route('front.cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <button class="btn btn-dark">
        <i class="fas fa-shopping-cart"></i> ADD TO CART
    </button>
</form>

                        </div>

                    </div>

                    <!-- Product Info -->
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="{{ route('front.product', $product->slug) }}">
                            {{ $product->title }}
                        </a>

                        <div class="price mt-2">
                            <span class="h5">
                                <strong>${{ $product->price }}</strong>
                            </span>

                            @if($product->compare_price)
                                <span class="h6 text-underline">
                                    <del>${{ $product->compare_price }}</del>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</div>

    </section>

@endsection
