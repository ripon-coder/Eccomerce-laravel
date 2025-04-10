@extends('front.layout.app')
@section('content')

    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Default</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <img id="product-zoom" src="{{ asset('storage/' . $product->thumbnail) }}"
                                        data-zoom-image="{{ asset('storage/' . $product->thumbnail) }}" alt="product image">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery">

                                    @php
                                        $images = is_string($product->images)
                                            ? json_decode($product->images)
                                            : $product->images;
                                    @endphp

                                    @if (is_array($images) && count($images))
                                        @foreach ($images as $image)
                                            <a class="product-gallery-item active" href="#"
                                                data-image="{{ asset('storage/' . $image) }}"
                                                data-zoom-image="{{ asset('storage/' . $image) }}">
                                                <img src="{{ asset('storage/' . $image) }}" alt="product side">
                                            </a>
                                        @endforeach
                                    @else
                                        <p>No images found.</p>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            <div class="product-price">
                                <span id="new_price" class="new-price"></span> 
                                <span id="old_price" class="old-price"><del></del></span>
                            </div>

                            <div class="details-filter-row details-row-size pt-2">
                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select id="size-selector" onchange="updatePrice()" name="size" id="size"
                                        class="form-control">
                                        @if ($noSizesAvailable)
                                            <option value="" disabled>No sizes available</option>
                                        @else
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size['id'] }}">{{ $size['value'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" class="form-control" value="1" min="1"
                                        max="10" step="1" data-decimals="0" required>
                                </div><!-- End .product-details-quantity -->
                            </div><!-- End .details-filter-row -->

                            <div class="product-details-action">
                                <a href="#" class="btn-product btn-cart add-to-cart"><span>add to cart</span></a>

                                <div class="details-action-wrapper">
                                    <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                            Wishlist</span></a>
                                </div><!-- End .details-action-wrapper -->
                            </div><!-- End .product-details-action -->

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#">Women</a>,
                                    <a href="#">Dresses</a>,
                                    <a href="#">Yellow</a>
                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                            class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                            class="icon-pinterest"></i></a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                            role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab"
                            role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping &
                            Returns</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                        aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            {!! $product->description !!}
                        </div>
                    </div>

                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                        aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>Delivery & returns</h3>
                            <p>We deliver to over 100 countries around the world. For full details of the delivery options
                                we offer, please view our <a href="#">Delivery information</a><br>
                                We hope you’ll love every purchase, but if you ever need to return an item you can do so
                                within a month of receipt. For full details of how to make a return, please view our <a
                                    href="#">Returns information</a></p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->

                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                "nav": false, 
                "dots": true,
                "margin": 20,
                "loop": false,
                "responsive": {
                    "0": {
                        "items":1
                    },
                    "480": {
                        "items":2
                    },
                    "768": {
                        "items":3
                    },
                    "992": {
                        "items":4
                    },
                    "1200": {
                        "items":4,
                        "nav": true,
                        "dots": false
                    }
                }
            }'>

                @for ($i = 0; $i < 8; $i++)
                    @include('front.inc.related-product')
                @endfor

            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
@section('script')
<script>
    const variants = @json($product->variants);
    const defaultVariant = @json($product->variants->first());
    const defaultPrice = defaultVariant?.discount_price || defaultVariant?.price || "0.00";

    function formatCurrency(value) {
        return '৳' + Number(value).toLocaleString('en-BD', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updatePrice() {
        const sizeId = parseInt(document.getElementById('size-selector')?.value);
        const priceEl = document.getElementById('new_price');
        const oldPriceEl = document.getElementById('old_price');

        let matched = null;

        for (const variant of variants) {
            if (variant.options.some(option => option.attribute_option_id == sizeId)) {
                matched = variant;
                break;
            }
        }

        if (matched) {
            const discount = matched.discount_price || matched.price; // Use discount price if available, else regular price
            const regular = matched.price;

            priceEl.textContent = formatCurrency(discount);

            // Always show the original price
            oldPriceEl.textContent = formatCurrency(regular);
        } else {
            // No match, show default price
            priceEl.textContent = formatCurrency(defaultPrice);
            oldPriceEl.textContent = formatCurrency(defaultPrice);
        }
    }

    document.addEventListener('DOMContentLoaded', updatePrice);
</script>
@endsection

