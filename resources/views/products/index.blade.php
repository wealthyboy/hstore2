@extends('layouts.app')
 
@section('content')
@include('_partials.top_banner')


<section class="breadcrumb no-banner  justify-content-center">
    <div class="breadcrumb-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12  text-left border-bottom">
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
                        <p class="text-left"> {{ isset($category) ? $category->description : '' }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="container-fluid mb-3">
    <products-index />

</div>
@endsection
@section('page-scripts')
@stop
@section('inline-scripts')
    $(document).ready(function() {
           
   });
   
@stop
