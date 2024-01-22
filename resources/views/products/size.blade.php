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
                            
                        </div>
                    </nav>
                    <h1 class="breadcrumb-title">Size Guide</h1>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="container-fluid mb-3">
    <div  class="row">
        <div class="col-12">
            <img src="/images/sizes/SIZE-GUIDE-2.jpg" />
            <img src="/images/sizes/SIZE-GUIDE-3.jpg" />
            <img src="/images/sizes/SIZE-GUIDE-1.jpg" />
            <img src="/images/sizes/SIZE-GUIDE-4.jpg" />
        </div>
    </div>
</div>
@endsection
@section('page-scripts')
@stop
@section('inline-scripts')
    
   
@stop
