@extends('layouts.app')

@section('content')
@include('_partials.top_banner')

<!-- 🔍 Search Bar Section -->
<!-- Search Overlay (below navbar) -->
<div id="searchOverlay" class="search-overlay">
  <div id="searchBarWrapper" class="search-bar-wrapper border py-4">
    <div class="container-fluid">
      <form id="predictive-search-form" action="/search" method="GET" role="search" class="search-form mb-0 d-flex align-items-center">
        <svg aria-hidden="true" fill="none" focusable="false" width="20" class="icon icon-search me-2" viewBox="0 0 24 24">
          <path d="M10.364 3a7.364 7.364 0 1 0 0 14.727 7.364 7.364 0 0 0 0-14.727Z" stroke="currentColor" stroke-width="1" stroke-miterlimit="10"></path>
          <path d="M15.857 15.858 21 21.001" stroke="currentColor" stroke-width="1" stroke-miterlimit="10" stroke-linecap="round"></path>
        </svg>

        <input type="search" name="q" placeholder="Search for... and press enter" aria-label="Search" class="form-control border-0 shadow-none fs-5"> 

        <button type="button" class="btn-close-search bg-transparent border-0 ms-2">
          <svg width="20" viewBox="0 0 16 16" class="icon-close">
            <path d="m1 1 14 14M1 15 15 1" stroke="currentColor"></path>
          </svg>
        </button>
      </form>
    </div>
  </div>
</div>


 



<div class="container-fliud">
    <div class="row align-items-start">
        @foreach( $sliders as $slider )
        <div data-title="{{ $slider->title }}" class="{{ $slider->col }} {{ $slider->col == 'col-lg-3' ?  'col-6    p-0' : '' }}  {{ $slider->title }} p-0 text-center    top-banner-mb-1      {{ $slider->device }}">
            <div class="banner-box">

                <a class="portfolio-thumb d-block position-relative" href="{{ $slider->link }}">
                    <img src="{{ $slider->image }}" title="{{ $slider->title }}" alt="{{ $slider->img_alt }}" class="w-100" />
                    <h1 class="position-absolute top-banner-title bottom-0 start-50 translate-middle-x text-white  bg-opacity-50 px-2 py-1 rounded">
                        {{ $slider->title }}
                    </h1>

                    
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>


 




<div id="{{ optional($products)->count() }}" class="container-fluid">

    @if ( optional($products)->count() )

    <div class="products-section pt-0">
        <h1 title="fashion  top picks" class="text-center text-sm-25  eee mb-3 mt-3 ">Trending Now</h1>
        <div class="products-slider owl-carousel owl-theme dots-top">
            @foreach( $products as $related_product)
            @if (optional($related_product)->product_type == 'variable')
            <div class="product-default inner-quickview inner-icon">
                <figure>
                    <a href="{{ optional($related_product)->link }}">
                        <img src="{{ optional($related_product)->image_to_show_m }}">
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
                        <img src="{{ optional($related_product)->image_to_show_m }}">
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
                        <span class="old-price bold">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->price)  }}</span>
                        <span class="product-price bold text-danger">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->salePrice())  }}</span>
                        @else
                        <span title="{{ optional($related_product)->default_discounted_price }} " class="product-price  bold">{{ optional($related_product)->currency }}{{ number_format(optional($related_product)->converted_price)  }}</span>
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


<div class="container-fliud">
    <div class="row align-items-start">
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


@if ($posts->count() && optional($blog_status)->is_active)

<div class="blog-section pt-0 mt-3">
    <h1 title="fashion blog" class="text-center mb-3">Blog</h1>

    <div class="products-slider ml-3 owl-carousel owl-theme dots-top">
        @foreach($posts as $post)
        <div class="blog-default inner-quickview inner-icon">
            <figure>
                <a href="{{ route('blog.show',['blog'=> $post->slug]) }}">
                    <img title="{{ $post->title }}" src="{{ $post->image_m }}" alt="{{  $post->title }}">
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



@if ($reviews->count())


<section class="section-6 appear-animate">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="section-title text-center mb-4">Latest Product Reviews</h2>

                <div class="owl-carousel owl-theme reviews-carousel" 
                     data-owl-options='{
                        "loop": true,
                        "margin": 20,
                        "autoplay": false,
                        "autoHeight": true,
                        "dots": true,
                        "nav": false,
                        "responsive": {
                            "0": { "items": 1 },
                            "576": { "items": 2 },
                            "992": { "items": 3 }
                        }
                    }'>

                    @foreach($reviews as $review)
                    <div class="card border-0 shadow-sm h-100">
                        {{-- Product Image --}}
                        @if(optional($review->product_variation)->image_to_show_m)
                            <img src="{{ optional($review->product_variation)->image_to_show_m }}" 
                                 class="card-img-top p-3" 
                                 alt="{{ $review->title }}" 
                                 style="max-height:180px; object-fit:contain;">
                        @endif

                        <div class="card-body text-center">
                            {{-- Stars --}}
                            <div class="mb-2">
                                @for($i=1; $i<=5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}">★</span>
                                @endfor
                            </div>

                            {{-- Review Title --}}
                            <h6 class="fw-bold mb-1">{{ $review->title }}</h6>

                            {{-- Review Description --}}
                            <p class="small text-muted">“{{ $review->description }}”</p>

                            {{-- Product Name --}}
                            <p class="text-dark mb-0">
                                <strong>{{ optional($review->product)->product_name }}</strong>
                            </p>
                        </div>

                        <div class="card-footer bg-white text-center">
                            {{-- Reviewer --}}
                            <small class="text-muted">
                                – {{ optional($review->user)->name }} {{ optional($review->user)->last_name[0] ?? '' }}.
                            </small>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>

@endif




<div class="container-fluid">
    <div class="feature-boxes-container row mt-6 mb-1"></div>
</div>







@endsection
@section('page-scripts')
 
@stop

@section('inline-scripts')
     window.addEventListener("load", function() {
    const toggleBtn = document.getElementById("toggleSearch");
    const overlay = document.getElementById("searchOverlay");
    const closeBtn = document.querySelector(".btn-close-search");
    const input = overlay.querySelector("input[type='search']");

    function openSearch() {
      overlay.classList.add("show");
      setTimeout(() => input.focus(), 300);
    }

    function closeSearch() {
      overlay.classList.remove("show");
    }

    // Toggle with search icon
    toggleBtn.addEventListener("click", function() {
      overlay.classList.contains("show") ? closeSearch() : openSearch();
    });

    // Close with overlay background
    overlay.addEventListener("click", function(e) {
      if (e.target === overlay) closeSearch();
    });

    // Close with "X" button
    closeBtn.addEventListener("click", closeSearch);

    // ✅ Close with ESC key
    document.addEventListener("keydown", function(e) {
      if (e.key === "Escape" && overlay.classList.contains("show")) {
        closeSearch();
      }
    });
  }); 
@stop

