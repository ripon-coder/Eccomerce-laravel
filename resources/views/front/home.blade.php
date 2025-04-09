@extends('front.layout.app')
@section('content')
    <div class="intro-section bg-lighter pt-2 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="banner banner-display">
                        <a href="#">
                            <img src="assets/images/slider/slide-1.jpg" alt="Banner">
                        </a>

                        <div class="banner-content main-banner">
                            <!-- End .banner-subtitle -->
                            <h3 class="banner-title text-white"><a href="#">Chairs & Chaises
                                    <br>Up to 40% off</a></h3><!-- End .banner-title -->
                            <a href="#" class="btn main-banner-btn btn-outline-white banner-link">Shop
                                Now<i class="icon-long-arrow-right"></i></a>
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-lg-8 -->
                <div class="col-lg-4">
                    <div class="intro-banners">
                        <div class="row row-sm">
                            <div class="col-md-6 col-lg-12">
                                <div class="banner banner-display">
                                    <a href="#">
                                        <img src="assets/images/banners/home/intro/banner-1.jpg" alt="Banner">
                                    </a>

                                    <div class="banner-content">
                                        <h3 class="banner-title text-white"><a href="#">Chairs & Chaises
                                                <br>Up to 40% off</a></h3><!-- End .banner-title -->
                                        <a href="#" class="btn btn-outline-white banner-link">Shop Now<i
                                                class="icon-long-arrow-right"></i></a>
                                    </div><!-- End .banner-content -->
                                </div><!-- End .banner -->
                            </div><!-- End .col-md-6 col-lg-12 -->

                            <div class="col-md-6 col-lg-12">
                                <div class="banner banner-display mb-0">
                                    <a href="#">
                                        <img src="assets/images/banners/home/intro/banner-2.jpg" alt="Banner">
                                    </a>

                                    <div class="banner-content">
                                        <h3 class="banner-title text-white"><a href="#">Best Lighting
                                                <br>Collection</a></h3><!-- End .banner-title -->
                                        <a href="#" class="btn btn-outline-white banner-link">Discover
                                            Now<i class="icon-long-arrow-right"></i></a>
                                    </div><!-- End .banner-content -->
                                </div><!-- End .banner -->
                            </div><!-- End .col-md-6 col-lg-12 -->
                        </div><!-- End .row row-sm -->
                    </div><!-- End .intro-banners -->
                </div><!-- End .col-lg-4 -->
            </div>
            <div class="mb-4"></div>
            <div class="container">
                <h2 class="title text-center mb-4">Explore Popular Categories</h2>
                <!-- End .title text-center -->

                <div class="cat-blocks-container">
                    <div class="row">
                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="category.html" class="cat-block">
                                <figure>
                                    <span>
                                        <img src="assets/images/demos/demo-4/cats/1.png" alt="Category image">
                                    </span>
                                </figure>

                                <h3 class="cat-block-title">Computer &amp; Laptop</h3>
                                <!-- End .cat-block-title -->
                            </a>
                        </div><!-- End .col-sm-4 col-lg-2 -->

                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="category.html" class="cat-block">
                                <figure>
                                    <span>
                                        <img src="assets/images/demos/demo-4/cats/2.png" alt="Category image">
                                    </span>
                                </figure>

                                <h3 class="cat-block-title">Digital Cameras</h3><!-- End .cat-block-title -->
                            </a>
                        </div><!-- End .col-sm-4 col-lg-2 -->

                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="category.html" class="cat-block">
                                <figure>
                                    <span>
                                        <img src="assets/images/demos/demo-4/cats/3.png" alt="Category image">
                                    </span>
                                </figure>

                                <h3 class="cat-block-title">Smart Phones</h3><!-- End .cat-block-title -->
                            </a>
                        </div><!-- End .col-sm-4 col-lg-2 -->

                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="category.html" class="cat-block">
                                <figure>
                                    <span>
                                        <img src="assets/images/demos/demo-4/cats/4.png" alt="Category image">
                                    </span>
                                </figure>

                                <h3 class="cat-block-title">Televisions</h3><!-- End .cat-block-title -->
                            </a>
                        </div><!-- End .col-sm-4 col-lg-2 -->

                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="category.html" class="cat-block">
                                <figure>
                                    <span>
                                        <img src="assets/images/demos/demo-4/cats/5.png" alt="Category image">
                                    </span>
                                </figure>

                                <h3 class="cat-block-title">Audio</h3><!-- End .cat-block-title -->
                            </a>
                        </div><!-- End .col-sm-4 col-lg-2 -->

                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="category.html" class="cat-block">
                                <figure>
                                    <span>
                                        <img src="assets/images/demos/demo-4/cats/6.png" alt="Category image">
                                    </span>
                                </figure>

                                <h3 class="cat-block-title">Smart Watches</h3><!-- End .cat-block-title -->
                            </a>
                        </div><!-- End .col-sm-4 col-lg-2 -->
                    </div><!-- End .row -->
                </div><!-- End .cat-blocks-container -->
            </div>
        </div>
    </div>

    <div class="mb-6"></div>
    <div class="mb-5"></div>

    <div class="container">
        <div class="heading heading-center mb-6">
            <h2 class="title">Latest Products</h2>
        </div>
        <div class="">
            <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                <div class="products">
                    <div class="row justify-content-center">
                            @include('front.inc.product')
                    </div>
                </div>
            </div>
        </div>
        <div class="more-container text-center">
            <a href="#" class="btn btn-outline-darker btn-more"><span>more products</span><i
                    class="icon-long-arrow-right"></i></a>
        </div>
    </div>

    <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div class="icon-box icon-box-card text-center">
                    <span class="icon-box-icon">
                        <i class="icon-rocket"></i>
                    </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Payment & Delivery</h3>
                        <p>Free shipping for orders over $50</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6">
                <div class="icon-box icon-box-card text-center">
                    <span class="icon-box-icon">
                        <i class="icon-rotate-left"></i>
                    </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Return & Refund</h3>
                        <p>Free 100% money back guarantee</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6">
                <div class="icon-box icon-box-card text-center">
                    <span class="icon-box-icon">
                        <i class="icon-life-ring"></i>
                    </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Quality Support</h3>
                        <p>Alway online feedback 24/7</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2"></div>
    </div>
@endsection
