<div style="background-color: {{ $global_promo->background_color }}" class="top-notice text-white">
    <div class="container-fluid text-center">
        <div class="offer-hignlight">
            @foreach($global_promo->promo_texts as $key =>  $promo_text)
                <div  class="col-12 text-center">
                    <h5 class="d-inline-block color--light text-uppercase  mb-0"><b>
                    {{ $promo_text->promo}}</b>
                    </h5>
                </div>
            @endforeach
        </div>
    </div><!-- End .container -->
</div>

