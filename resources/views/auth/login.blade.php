@extends('layouts.auth')
 
@section('content')
   
 <!--Content-->
    <section class="sec-padding bg--main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="ml-1 col-md-5  bg--main mr-1">
                    <a href="/" class="d-flex  mt-3 justify-content-center">
                      <img width="200" src="{{ $system_settings->logo_path() }}" alt="{{ Config('app.name') }} Logo">
                    </a>
                    <div class=" mt-1 mb-4">
                        @include('_partials.login')
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--End Content-->
@endsection
