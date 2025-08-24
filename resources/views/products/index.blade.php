@extends('layouts.app')
 
@section('content')
@include('_partials.top_banner')


<section class="breadcrumb no-banner  justify-content-center">
    <div class="breadcrumb-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12  text-center border-bottom">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav breadcrumb-link">
                        <div class="container d-flex justify-content-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb }}</li>
                            </ol>
                        </div>
                    </nav>
                    <h1 class="breadcrumb-title">{{ $breadcrumb }}</h1>
                    <div class="category-description">
                        <p class="text-center"> {{ isset($category) ? $category->description : '' }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="container-fluid mb-3">
    <div  class="row">
      @if (!$products->count())
        <div class="col-lg-12 main-content" bis_skin_checked="1">
          
            <div id="load-products" class="row" bis_skin_checked="1">
                <div class="col-12 d-flex justify-content-center" bis_skin_checked="1">
                    <div class="text-center pb-3" bis_skin_checked="1">
                        <svg width="400" height="200" viewBox="0 0 400 240" role="img" aria-label="No products found" xmlns="http://www.w3.org/2000/svg"><title>No products found</title> <desc>A stylized empty state with a magnifying glass and dashed product card.</desc> <defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#f3f4f6"></stop> <stop offset="1" stop-color="#e5e7eb"></stop></linearGradient></defs> <ellipse cx="200" cy="170" rx="130" ry="18" fill="#e5e7eb"></ellipse> <path d="M60 70c0-18 14-32 32-32h216c18 0 32 14 32 32v54c0 18-14 32-32 32H92c-18 0-32-14-32-32V70z" fill="url(#g)"></path> <rect x="95" y="78" width="210" height="88" rx="10" fill="#fff" stroke="#e5e7eb" stroke-width="2" stroke-dasharray="6 6"></rect> <rect x="110" y="92" width="60" height="60" rx="8" fill="#f9fafb" stroke="#e5e7eb"></rect> <rect x="180" y="92" width="100" height="12" rx="6" fill="#e5e7eb"></rect> <rect x="180" y="112" width="70" height="10" rx="5" fill="#e5e7eb"></rect> <rect x="180" y="130" width="90" height="10" rx="5" fill="#e5e7eb"></rect> <g transform="translate(245 120) rotate(15)"><circle cx="0" cy="0" r="28" fill="#fff" stroke="#9ca3af" stroke-width="3"></circle> <path d="M18 18L44 44" stroke="#9ca3af" stroke-width="4" stroke-linecap="round"></path> <circle cx="-8" cy="-4" r="2" fill="#9ca3af"></circle> <circle cx="8" cy="-4" r="2" fill="#9ca3af"></circle> <path d="M-10 6c6 6 14 6 20 0" fill="none" stroke="#9ca3af" stroke-width="3" stroke-linecap="round"></path></g> <g stroke="#d1d5db" stroke-linecap="round"><path d="M310 86h10M315 81v10"></path> <path d="M100 152h8M104 148v8"></path></g> <g fill="#6b7280" font-family="system-ui, -apple-system, 'Segoe UI', Roboto, Ubuntu, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif"><text x="200" y="200" font-size="16" text-anchor="middle">No products found</text> <text x="200" y="220" font-size="12" text-anchor="middle" fill="#9ca3af">Try adjusting your filters or search terms</text></g></svg> 
                    </div>
                </div> 
            </div> 
        </div>
      @endif
        
        
       @if ( isset($category) &&  isset($category_attributes) && !empty($category_attributes) )
            <div class="col-lg-9 main-content">
                <div class="product-overlay d-none">
                    <div class="loading">
                        <div class="loader"></div>
                    </div>
                </div>
        @else
            <div class="col-lg-12 main-content">
        @endif
        @if ($products->count() && isset($category) && strtolower($category->name) !== 'gift cards')
            <nav class="toolbox horizontal-filter filter-sorts">
                <div class="toolbox-left">
                    <div class="toolbox-item toolbox-sort pr-1">

                        <label class="ml-3"></label>
                        <div class="select-custom">
                            <select  name="sort_by" id="sort_by" class="form-control">
                                <option value="" selected="selected">Sort By</option>
                                <option value="created_at,asc">Oldest</option>
                                <option value="created_at,desc">Newest</option>
                                <option value="price,asc">Lowest Price</option>
                                <option value="price,desc">Highest Price</option>
                            </select>
                        </div><!-- End .select-custom -->


                    </div><!-- End .toolbox-item -->
                </div><!-- End .toolbox-left -->


                <div class="toolbox-right">
                    <div class="toolbox-item layout-modes">
                        <a href="#" class="layout-btn btn-grid active" title="Grid">
                            <i class="icon-mode-grid"></i>
                        </a>
                        
                    </div><!-- End .layout-modes -->
                </div><!-- End .toolbox-right -->
            </nav>
        @endif
        <div id="load-products" class="row">
            
 
            @if ( isset($category) &&  isset($category_attributes) && !empty($category_attributes) )
                @include('_partials.products',['no_attr'=>true])
            @else
                @include('_partials.products',['no_attr' => false])
            @endif
        </div>

           
            <div id="pagination" class="col-md-10 text-center mb-20 md-offset-1">
                @if(!empty($products->hasMorePages()))
                    <a href="{{ $products->nextPageUrl() }}" id="load_more" class="btn btn-block loadmore btn-loadmore load_more mt-4 mb-2">
                        <span class="spinner-grow spinner-grow-md d-none"></span>
                        Load More ...
                    </a>
                @endif
            </div>
        </div><!-- End .col-lg-9 -->

        
        @if ($products->count())
            @if ( isset($category) &&  isset($category_attributes) && $category_attributes->count()  )
                <div class="sidebar-overlay"></div>
                <div class="sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
                <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                    <div class="pin-wrapper" style="">
                        <div class="sidebar-wrapper" style="">
                            @include('_partials.search',['category_attributes'=>$category_attributes])
                        </div>
                    </div>
                </aside><!-- End .col-lg-3 -->
            @endif
        @endif
    </div><!-- End .row -->
    <form id="sort_by">
        <input type="hidden" name="sort_by" id="sort" />
    </form>

</div>
@endsection
@section('page-scripts')
@stop
@section('inline-scripts')
    $(document).ready(function() {
        $("#load-products").loadProducts({
           'form':$('form#collections input'),
           'form_data':$("form#collections"),
           'form_sort_by':$("select#sort_by "),
           'target':'load-products',
           'loggedInStatus':8,
           'load_more':$(document).find('a.load_more'),
           'filter_url':'{{ request()->fullUrl() }}',
           'overlay': '.product-overlay'
        });
   
        //reset form
        $("#reset-search-form").on("click", function () {
           //  Reset all selections fields to default option.          
           $('input[type=checkbox]').each(function () {
               this.checked = false;
           }); 
        });   
   });
   
@stop
