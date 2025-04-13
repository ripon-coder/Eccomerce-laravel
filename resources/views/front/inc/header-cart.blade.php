<div class="dropdown cart-dropdown">
    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" data-display="static">
        <i class="icon-shopping-cart"></i>
        <span class="cart-count">{{ count($headerCartItems ?? []) }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-cart-products">
            @forelse ($headerCartItems ?? [] as $item)
                <div class="product">
                    <div class="product-cart-details">
                        <h4 class="product-title">
                            <a href="#">{{ $item['product']->name }}</a>
                        </h4>

                        <span class="cart-product-info">
                            <span class="cart-product-qty">{{ $item['quantity'] }}</span>
                            x ${{ number_format($item['variant']->discount_price ?? $item['variant']->price, 2) }}
                        </span>
                    </div>

                    <figure class="product-image-container">
                        <a href="#" class="product-image">
                            <img src="{{ asset($item['image']) }}" alt="product">
                        </a>
                    </figure>

                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                </div>
            @empty
                <p class="text-center m-2">Your cart is empty.</p>
            @endforelse
        </div>

        <div class="dropdown-cart-total">
            <span>Total</span>
            <span class="cart-total-price">${{ number_format($headerCartTotal ?? 0, 2) }}</span>
        </div>

        <div class="dropdown-cart-action">
            <a href="{{route('cart')}}" class="btn btn-primary">View Cart</a>
            <a href="#" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
        </div>
    </div>
</div>
