@extends('front.layouts.app')


@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                     <li class="breadcrumb-item"><a class="white-text" href=" {{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
<div class="accordion" id="accordionExample">

@foreach($categories as $key => $category)

    @php
        $subcategories = $category->sub_categories->where('status', 1);

        // ✅ Check if this category is selected
        $isCategoryActive = request('category') == $category->id;

        // ✅ Check if any subcategory is selected inside it
        $isSubActive = $subcategories->pluck('id')->contains(request('subcategory'));
    @endphp

    @if($subcategories->isNotEmpty())

        <div class="accordion-item">

            {{-- Accordion Button --}}
            <h2 class="accordion-header" id="heading-{{ $key }}">
                <button
                    class="accordion-button {{ ($isCategoryActive || $isSubActive) ? '' : 'collapsed' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse-{{ $key }}">

                    {{ $category->name }}
                </button>
            </h2>

            {{-- Accordion Body --}}
            <div
                id="collapse-{{ $key }}"
                class="accordion-collapse collapse {{ ($isCategoryActive || $isSubActive) ? 'show' : '' }}"
                data-bs-parent="#accordionExample">

                <div class="accordion-body">
                    <div class="navbar-nav flex-column">

                        {{-- ✅ Category Link --}}
                        <a href="{{ route('front.shop', ['category' => $category->id]) }}"
                           class="nav-item nav-link fw-bold {{ $isCategoryActive ? 'active text-primary' : '' }}">
                            All {{ $category->name }}
                        </a>

                        {{-- ✅ SubCategory Links --}}
                        @foreach($subcategories as $sub)

                            <a href="{{ route('front.shop', ['category'
                            => $category->id ,'subcategory' => $sub->id]) }}"
                               class="nav-item nav-link {{ request('subcategory') == $sub->id ? 'active text-danger fw-bold' : '' }}">
                                {{ $sub->name }}
                            </a>

                        @endforeach

                    </div>
                </div>
            </div>

        </div>

    @endif

@endforeach

</div>


                        </div>
                    </div>

<div class="sub-title mt-5">
    <h2>Brand</h2>
</div>

<div class="card">
    <div class="card-body">
        @foreach($brands as $brand)
            <div class="form-check mb-2">
                <input class="brand-checkbox form-check-input"
                       type="checkbox"
                       value="{{ $brand->id }}"
                       id="brand-{{ $brand->id }}"
                       {{ is_array(request('brands')) && in_array($brand->id, request('brands')) ? 'checked' : '' }}>
                <label class="form-check-label" for="brand-{{ $brand->id }}">
                    {{ $brand->name }}
                </label>
            </div>
        @endforeach
    </div>
</div>

<div class="sub-title mt-5">
    <h2>Price</h2>
</div>

<div class="card">
    <div class="card-body">
        <input type="text" id="price-range" name="price" value="" />
    </div>
</div>


                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                         <div class="ml-2">
    <div class="btn-group">

        <!-- Button -->
        <button type="button"
                class="btn btn-sm btn-light dropdown-toggle"
                data-bs-toggle="dropdown">
            Sorting
        </button>

        <!-- Dropdown Items -->
        <div class="dropdown-menu dropdown-menu-right">

            <a class="dropdown-item sort-option" href="#" data-sort="latest">
                Latest
            </a>

            <a class="dropdown-item sort-option" href="#" data-sort="price_high">
                Price High
            </a>

            <a class="dropdown-item sort-option" href="#" data-sort="price_low">
                Price Low
            </a>

        </div>
    </div>
</div>

                            </div>
                        </div>
<div class="row" id="product-list">
    @foreach($products as $product)
    <div class="col-md-4">
        <div class="card product-card">
            <div class="product-image position-relative">
 <a href="{{ route('front.product' , $product->slug) }}" class="product-img">                    <img class="card-img-top"
                         src="{{ $product->images->first()
                                ? asset('uploads/products/thumbs/'.$product->images->first()->image)
                                : asset('front-assets/images/no-image.png') }}"
                         alt="{{ $product->name }}">
                </a>

                <a class="whishlist" href="#"><i class="far fa-heart"></i></a>

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

            <div class="card-body text-center mt-3">
                <a class="h6 link" href="#">{{ $product->title }}</a>
                <div class="price mt-2">
                    <span class="h5"><strong>${{ $product->price }}</strong></span>
                    @if($product->compare_price)
                        <span class="h6 text-underline"><del>${{ $product->compare_price }}</del></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

             <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customjs')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Ion RangeSlider JS -->
<script src="https://cdn.jsdelivr.net/npm/ion-rangeslider@2.3.1/js/ion.rangeSlider.min.js"></script>
<script>
$(document).ready(function() {

    // =====================
    // Brand filter
    // =====================
    $('.brand-checkbox').on('change', function() {
        let selectedBrands = [];

        $('.brand-checkbox:checked').each(function() {
            selectedBrands.push($(this).val());
        });

        filterProducts(selectedBrands, null, null);
    });

    // =====================
    // Price filter
    // =====================
    $("#price-range").ionRangeSlider({
        type: "double",
        min: 0,
        max: 10000,
        from: 0,
        to: 10000,
        prefix: "$",
        grid: true,
        onFinish: function(data) {
            let minPrice = data.from;
            let maxPrice = data.to;

            filterProducts(null, minPrice, maxPrice);
        }
    });

    // =====================
    // Common function to filter products via AJAX
    // =====================
    function filterProducts(brands = null, minPrice = null, maxPrice = null) {

        // Collect currently selected brands if not passed
        if(brands === null) {
            brands = [];
            $('.brand-checkbox:checked').each(function() {
                brands.push($(this).val());
            });
        }

        // Get current slider values if not passed
        if(minPrice === null || maxPrice === null) {
            let slider = $("#price-range").data("ionRangeSlider");
            minPrice = slider.result.from;
            maxPrice = slider.result.to;
        }

        // Send AJAX request
        $.get("{{ route('front.shop') }}", {
            brands: brands,
            min_price: minPrice,
            max_price: maxPrice
        }, function(response) {
            // Replace products without page reload
            $('#product-list').html($(response).find('#product-list').html());
        });
    }
});
</script>
<script>
$(document).ready(function () {

    // When user clicks sorting option
    $('.sort-option').on('click', function (e) {

        e.preventDefault(); // stop page refresh

        // Get selected sorting value
        let sortValue = $(this).data("sort");

        // Show active selected option
        $('.sort-option').removeClass("active");
        $(this).addClass("active");

        // Change button text
        $('.dropdown-toggle').text($(this).text());

        // AJAX request
        $.get("{{ route('front.shop') }}", {
            sort: sortValue
        }, function (response) {

            // Replace product list only
            $('#product-list').html(
                $(response).find('#product-list').html()
            );

        });

    });

});
</script>

@endsection
