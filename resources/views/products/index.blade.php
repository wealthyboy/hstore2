@extends('layouts.app')
 
@section('content')
@include('_partials.top_banner')


<section class="breadcrumb no-banner  justify-content-start">
    <div class="breadcrumb-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12  text-left border-bottom">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav breadcrumb-link">
                        <div class="containe d-flex justify-content-start">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb }}</li>
                            </ol>
                        </div>
                    </nav>
                    <h3 class="breadcrumb-title mb-0">{{ $breadcrumb }}</h3>
                    @if( isset($category) )
                    <div class="category-description product-description ">
                        <span class="text-left description-text mb-0"> {{ isset($category) ? $category->description : '' }} </span>
                        <span class="text-right w-100">
                            <a href="#" class="toggle-desc bold">Show More</a>
                        </span>
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</section>



<div class="container-fluid mb-3">
    <products-index  :filters="{{$category_attributes}}" 
 />
</div>
@endsection
@section('page-scripts')
@stop
@section('inline-scripts')
   $(document).ready(function () {
    const charLimit = 150; // limit before truncating

  $(".product-description").each(function () {
    const fullText = $(this).find(".description-text").text();
    if (fullText.length <= charLimit) {
      $(this).find(".toggle-desc").hide(); // no need for toggle
      return;
    }

    const truncated = fullText.substring(0, charLimit) + "...";

    $(this).find(".description-text").data("full", fullText);
    $(this).find(".description-text").data("truncated", truncated);

    // show truncated by default
    $(this).find(".description-text").text(truncated);
  });

  $(".toggle-desc").on("click", function (e) {
    e.preventDefault();
    const desc = $(".description-text");

    console.log(desc)

    if ($(this).text() === "Show More") {
      desc.text(desc.data("full"));
      $(this).text("Show Less");
    } else {
      desc.text(desc.data("truncated"));
      $(this).text("Show More");
    }
  });
});

@stop
