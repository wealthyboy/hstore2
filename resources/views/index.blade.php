@extends('layouts.app')

@section('content')
@include('_partials.top_banner')

<div class="container-fliud">
    <div  class="row align-items-start">
        @foreach( $banners as $banner )
            <div data-title="{{ $banner->title }}" class="{{ $banner->col }} {{ $banner->col == 'col-lg-3' ?  'col-6    p-0' : '' }}  {{ $banner->title }} p-0 text-center          {{ $banner->device }}">
                <div class="banner-box">
                    <a class="portfolio-thumb" href="{{ $banner->link }}">
                        <img src="{{ $banner->image }}" title="{{ $banner->title }}" alt="{{ $banner->img_alt }}" />
                    </a>
                </div>
            </div> 
        @endforeach
    </div>
</div>



<div id="{{ optional($products)->count() }}" class="container-fluid">
    
    @if ( optional($products)->count() )

    <div class="products-section pt-0">
        <h1 title="fashion  top picks" class="text-center text-sm-25  eee mb-3 mt-3 ">Top Picks for You</h1>
        <div class="products-slider owl-carousel owl-theme dots-top">
            @foreach( $products as $related_product)
            @if (optional($related_product)->product_type == 'variable')
            <div class="product-default inner-quickview inner-icon">
                <figure>
                    <a href="{{ optional($related_product)->link }}">
                        <img  src="{{ optional($related_product)->image_to_show_m }}">
                    </a>
                    @if ( optional($related_product)->default_discounted_price > 1)
                    <div class="label-group">
                        <span class="product-label label-sale">-{{ optional($related_product)->default_percentage_off }}%</span>
                    </div>
                    @endif
                    
                </figure>
                <div class="product-details">
                    <h3 class="product-title">
                        <a href="{{ optional($related_product)->link }}">{{ optional($related_product)->name  }}</a>
                    </h3>
                    <div class="price-box">
                        @if (optional($related_product)->default_discounted_price ) 
                            <span class="old-price">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->converted_price)  }}</span>
                            <span class="product-price">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->default_discounted_price)  }}</span>
                        @else
                           <span title="{{ optional($related_product)->default_discounted_price }} pppp" class="product-price  pppp">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->converted_price)  }}</span>
                        @endif
                    </div><!-- End .price-box -->
                </div><!-- End .product-details -->
            </div>
            @else

            <div class="product-default inner-quickview inner-icon">
                <figure>
                    <a href="{{ optional($related_product)->link }}">
                        <img  src="{{ optional($related_product)->image_to_show_m }}">
                    </a>
                    @if ( optional($related_product)->default_discounted_price > 1)
                    <div class="label-group">
                        <span class="product-label label-sale">-{{ optional($related_product)->default_percentage_off }}%</span>
                    </div>
                    @endif
                    
                </figure>
                <div class="product-details">
                    <h3 class="product-title">
                        <a href="{{ optional($related_product)->link }}">{{ optional($related_product)->name }}</a>
                    </h3>
                    <div class="price-box">
                        @if (optional($related_product)->salePrice() ) 
                            <span class="old-price">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->price)  }}</span>
                            <span class="product-price">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->salePrice())  }}</span>
                        @else
                           <span title="{{ optional($related_product)->default_discounted_price }} pppp" class="product-price  pppp">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->converted_price)  }}</span>
                        @endif
                    </div><!-- End .price-box -->
                </div><!-- End .product-details -->
            </div>
            @endif

           



            @endforeach


           
        </div><!-- End .products-slider -->

    </div><!-- End .products-section -->

    @endif
    </div><!-- End .container -->


@if ($posts->count() && optional($blog_status)->is_active) 

<div class="blog-section pt-0 mt-3">
    <h1 title="fashion blog" class="text-center mb-3">Blog</h1>

    <div class="products-slider ml-3 owl-carousel owl-theme dots-top">
       @foreach($posts as $post)
        <div class="blog-default inner-quickview inner-icon">
            <figure>
                <a href="{{ route('blog.show',['blog'=> $post->slug]) }}">
                    <img  title="{{ $post->title }}" src="{{ $post->image_m }}" alt="{{  $post->title }}">
                </a>
            </figure>
            <div class="blog-details text-left">
                <h4 class="blog-title mb-1">
                    <a title="{{ $post->title }} " href="{{ route('blog.show',['blog'=> $post->slug]) }}" class="">
                        {{ $post->title }}
                    </a>
                </h4>
                <div class="blog-teaser-box">
                    <?php echo  str_limit(html_entity_decode($post->teaser), $limit = 100, $end = '...') ?>   
                </div><!-- End .price-box -->
            </div><!-- End .product-details -->
        </div>
        @endforeach
        
    </div><!-- End .products-slider -->
</div><!-- End .products-section -->

@endif





<section class="section-6    appear-animate">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="section-title">Latest Product Reviews</h2>
                <div class="owl-carousel owl-theme testimonials-carousel" data-owl-options="{
                        'autoplay': false,
                        'autoHeight': true
                    }">
                    @foreach($reviews as $review)

                    <div class="testimonial bg-white pt-3">
                        <div class="testimonial-owner pl-3">
                            <figure>
                                <img title="{{ $review->title }}" src="{{ optional($review->product_variation)->image_to_show_m }}"  width="96" height="96" alt="{{ $review->title }} ">

                            </figure>

                            <div class="testi-content">
                                <div class="ratings-container mb-1">
                                    <div class="product-ratings">
                                        <div class="ratings" style="width: {{ $review->rating }}%"></div>
                                    </div>
                                </div>

                                <h4 class="testimonial-title p-0">{{ optional($review->product)->product_name }}</h4>

                                <blockquote class="ml-3 pr-0">
                                <p>{{ $review->description }}</p>
                                      
                                </blockquote>

                                <h5 class="testi-author">{{ optional($review->user)->name }} {{ optional($review->user)->last_name[0]  }}.</h5>
                            </div>
                        </div>
                    </div>

                    @endforeach


                </div>
                <!-- End .testimonial-slider -->
            </div>
        </div>
    </div>
</section>
<!-- End .blog-section -->



<div class="container-fluid ">
<div class="feature-boxes-container row mt-6 mb-1">
    <div class="col-md-4 col-4">
        <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
            <i class="icon-earphones-alt"></i>
            <div class="feature-box-content">
                <h3 class="mb-0 pb-1">Customer Support</h3>
                <h5 class="m-b-3">Need Assistance?</h5>
                <p></p>
            </div><!-- End .feature-box-content -->
        </div><!-- End .feature-box -->
    </div><!-- End .col-md-4 -->

    <div class="col-md-4 col-4">
        <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
            <i class="icon-credit-card"></i>
            <div class="feature-box-content">
                <h3 class="mb-0 pb-1">Secured Payment</h3>
                <h5 class="m-b-3">Safe &amp; Fast</h5>
                <p></p>
            </div><!-- End .feature-box-content -->
        </div><!-- End .feature-box -->
    </div><!-- End .col-md-4 -->

    <div class="col-md-4 col-4">
        <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
            <i class="icon-action-undo"></i>

            <div class="feature-box-content">
                <h3 class="mb-0 pb-1">DELIVERIES AND RETURNS</h3>
                <h5 class="m-b-3">Hassle Free</h5>
                <p></p>
            </div><!-- End .feature-box-content -->
        </div><!-- End .feature-box -->
    </div><!-- End .col-md-4 -->
</div>

</div>







@endsection
@section('page-scripts')
@stop


