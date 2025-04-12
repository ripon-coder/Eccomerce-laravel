@foreach ($feature_products as $item)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="product product-11 mt-v3 text-center">
            <figure class="product-media">
                <a href="{{ route('single-product', $item->slug) }}">
                    <img 
                        data-src="{{ asset('storage/' . $item->thumbnail) }}" 
                        alt="{{ $item->name }}" 
                        class="product-image lazyload">
                </a>
            
                <div class="product-action-vertical">
                    <a href="#" class="btn-product-icon btn-wishlist">
                        <span>add to wishlist</span>
                    </a>
                </div>
            </figure>
            
            <div class="product-body">
                <h3 class="product-title"><a href="{{route('single-product',$item->slug)}}">{{$item->name}}</a></h3>
                <div class="product-price pt-1">
                    <span class="new-price">{{@format_money($item->variants[0]->discount_price)}}</span>
                    <span class="old-price"><del>{{@format_money($item->variants[0]->price)}}</del></span>
                </div>
            </div>
            <div class="product-action">
                <a href="#" class="btn-product btn-cart"><span>add to
                        cart</span></a>
            </div>
        </div>
    </div>
@endforeach
