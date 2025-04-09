@foreach ($feature_products as $item)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="product product-11 mt-v3 text-center">
            <figure class="product-media">
                <a href="/product">
                    <img src="assets/images/demos/demo-2/products/product-12-1.jpg" alt="Product image"
                        class="product-image">
                </a>

                <div class="product-action-vertical">
                    <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                            wishlist</span></a>
                </div>
            </figure>
            <div class="product-body">
                <h3 class="product-title"><a href="product.html">{{$item->name}}</a></h3>
                <div class="product-price pt-1">
                    <span class="new-price">{{format_money()}}</span>
                    <span class="old-price"><del>৳1,000</del></span>
                </div>
            </div>
            <div class="product-action">
                <a href="#" class="btn-product btn-cart"><span>add to
                        cart</span></a>
            </div>
        </div>
    </div>
@endforeach
