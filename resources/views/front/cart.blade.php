@extends('front.layout.app')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        @if (count($cartItems) > 0)
                            <form action="{{ route('cart.update') }}" method="POST" id="cart-update-form">
                                @csrf
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td class="product-col">
                                                    <div class="product">
                                                        <figure class="product-media">
                                                            <a href="{{ route('single-product', $item['product']->slug) }}">
                                                                <img class="lazyload"
                                                                    data-src="{{ '/storage/' . $item['image'] }}"
                                                                    alt="{{ $item['product']->name }}">
                                                            </a>
                                                        </figure>
                                                        <h3 class="product-title">
                                                            {{ $item['product']->name }} ({{ $item['size'] }})
                                                        </h3>
                                                    </div>
                                                </td>
                                                <td class="price-col">
                                                    ৳{{ number_format($item['variant']->discount_price ?? $item['variant']->price, 2) }}
                                                </td>
                                                <td class="quantity-col">
                                                    <div class="cart-product-quantity">
                                                        <input type="number"
                                                            name="cart[{{ $item['variant']->id }}][quantity]"
                                                            class="form-control update-quantity"
                                                            value="{{ $item['quantity'] }}" min="1">
                                                    </div>
                                                </td>
                                                <td class="total-col">৳{{ number_format($item['subtotal'], 2) }}</td>
                                                <td class="remove-col">
                                                    <button type="button" class="btn-remove"
                                                        onclick="confirmRemove({{ $item['variant']->id }})">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="cart-bottom">
                                    <button type="submit" class="btn btn-outline-dark-2 update-cart-btn">
                                        <span>UPDATE CART</span><i class="icon-refresh"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- Hidden Remove Forms --}}
                            @foreach ($cartItems as $item)
                                <form id="remove-form-{{ $item['variant']->id }}"
                                    action="{{ route('cart.remove', $item['variant']->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        @else
                            <p>Your cart is empty.</p>
                        @endif
                    </div>

                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>৳{{ number_format($total, 2) }}</td>
                                    </tr><!-- End .summary-subtotal -->

                                    <tr class="summary-shipping">
                                        <td>Shipping:</td>
                                        <td><span id="shipping-cost">৳0</span></td>
                                    </tr>
                                    @foreach ($shipping_charge as $charge)
                                        <tr class="summary-shipping-row">
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input @checked($shipping_id == $charge->id) type="radio"
                                                        id="shipping-{{ $charge->id }}" name="shipping"
                                                        class="custom-control-input" value="{{ $charge->id }}"
                                                        data-amount="{{ $charge->charge }}">
                                                    <label class="custom-control-label"
                                                        for="shipping-{{ $charge->id }}">{{ $charge->title }}</label>
                                                </div>
                                            </td>
                                            <td>৳{{ $charge->charge }}</td>
                                        </tr>
                                    @endforeach


                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>৳<span id="total-price">{{ number_format($total, 2) }}</span></td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a href="checkout.html" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO
                                CHECKOUT</a>
                        </div><!-- End .summary -->

                        <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE
                                SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div>
            </div>
        </div>
    </div>

    {{-- Confirmation Script --}}
    <script>
        function confirmRemove(variantId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                document.getElementById('remove-form-' + variantId).submit();
            }
        }

        const shippingRadios = document.querySelectorAll('input[name="shipping"]');
        const subtotal = parseFloat('{{ $total }}');

        shippingRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const shippingId = this.value;

                fetch("{{ route('cart.updateShipping') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            shipping_id: shippingId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.shipping_cost)

                    })
                    .catch(error => {
                        console.error("Error updating shipping:", error);
                    });
            });
        });
    </script>
@endsection
