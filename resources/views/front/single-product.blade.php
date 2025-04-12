@extends('front.layout.app')
@section('content')

    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Default</li>
            </ol>
        </div>
    </nav>
    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <img id="product-zoom" class="lazyload"
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                                        data-src="{{ asset('storage/' . $product->thumbnail) }}"
                                        data-zoom-image="{{ asset('storage/' . $product->thumbnail) }}" alt="product image">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure>

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
                                                <img class="lazyload"
                                                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                                                    data-src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
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
                            <form id="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" id="product-id" value="{{ $product->id }}">
                                <input type="hidden" name="variant_id" id="variant_id">
                                <div class="details-filter-row details-row-size pt-2">
                                    <label for="size">Size:</label>
                                    <div class="select-custom">
                                        <select id="size-selector" onchange="updatePrice()" name="size" id="size"
                                            class="form-control">
                                            @if ($noSizesAvailable)
                                                <option value="" disabled>No sizes available</option>
                                            @else
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size['id'] }}"
                                                        data-variant-id="{{ $size['variant_id'] }}">{{ $size['value'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" value="1"
                                            min="1" max="10" step="1" data-decimals="0" required>
                                    </div>
                                </div>
                                <div id="remaining-quantity-container">
                                    <span class="label">Remaining Quantity:</span>
                                    <span id="remaining-quantity" class="quantity">Loading...</span>
                                </div>


                                <div class="product-details-action">
                                    <button type="submit" id="add-to-cart-btn" class="btn-product btn-cart add-to-cart">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                        <span class="text">Add to cart</span>
                                    </button>



                                    <div class="details-action-wrapper">
                                        <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                                Wishlist</span></a>
                                    </div>
                                </div>
                            </form>
                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#">Women</a>,
                                    <a href="#">Dresses</a>,
                                    <a href="#">Yellow</a>
                                </div>

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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="title text-center mb-4">You May Also Like</h2>

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

                {{-- @for ($i = 0; $i < 8; $i++)
                    @include('front.inc.related-product')
                @endfor --}}

            </div>
        </div>
    </div>
    </main>
@endsection
@section('stylesheet')
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
            const spinner = document.querySelector('.add-to-cart .spinner-border');
            const text = document.querySelector('.add-to-cart .text');

            const sizeSelector = document.getElementById('size-selector');
            const selectedOption = sizeSelector?.selectedOptions[0];

            const sizeId = parseInt(selectedOption?.value);
            const variantId = selectedOption?.getAttribute('data-variant-id');
            const productId = document.getElementById('product-id')?.value;

            const priceEl = document.getElementById('new_price');
            const oldPriceEl = document.getElementById('old_price');
            const variantIdInput = document.getElementById('variant_id');

            // Set variant id directly
            variantIdInput.value = variantId;

            // Show loading
            spinner?.classList.remove('d-none');
            text?.classList.add('d-none');

            // 1. Fetch remaining quantity
            $.ajax({
                url: '{{ route('get-ramaining-quantity') }}',
                method: 'GET',
                data: {
                    product_id: productId,
                    variant_id: variantId
                },
                success: function(response) {
                    const remaining = parseInt(response ?? 0);
                    const el = $('#remaining-quantity');
                    const container = $('#remaining-quantity-container');

                    el.text(remaining);
                    if (remaining <= 5) {
                        container.addClass('low-stock');
                        el.text(`${remaining} (Low Stock)`);
                    } else {
                        container.removeClass('low-stock');
                    }
                },
                error: function() {
                    $('#remaining-quantity').text('N/A');
                }
            });

            // 2. Update price using `variantId`
            const matched = variants.find(v => v.id == variantId);

            if (matched) {
                const discount = matched.discount_price || matched.price;
                const regular = matched.price;
                priceEl.textContent = formatCurrency(discount);
                oldPriceEl.textContent = formatCurrency(regular);
            } else {
                priceEl.textContent = formatCurrency(defaultPrice);
                oldPriceEl.textContent = formatCurrency(defaultPrice);
            }

            // Hide loading
            setTimeout(() => {
                spinner?.classList.add('d-none');
                text?.classList.remove('d-none');
            }, 300);
        }


        // Run on page load
        document.addEventListener('DOMContentLoaded', () => {
            updatePrice();
        });


        // add to cart
        $('#add-to-cart-form').on('submit', function(e) {
            e.preventDefault();
            const $btn = $('#add-to-cart-btn');
            const $spinner = $btn.find('.spinner-border');
            const $btnText = $btn.find('.text');

            // Disable button and show spinner
            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');
            $btnText.addClass('d-none');

            const formData = {
                _token: $('input[name="_token"]').val(),
                product_id: $('input[name="product_id"]').val(),
                variant_id: $('input[name="variant_id"]').val(),
                size_id: $('#size-selector').val(),
                quantity: $('#qty').val()
            };

            $.ajax({
                url: '{{ route('cart.add') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log("Cart Added Successfully");
                    $('#cart-dropdown-container').html(response);
                },
                complete: function() {
                    // Re-enable button and hide spinner
                    $btn.prop('disabled', false);
                    $spinner.addClass('d-none');
                    $btnText.removeClass('d-none');
                },
                error: function(xhr) {
                    console.log("Something went wrong!");
                }
            });
        });
    </script>
@endsection
