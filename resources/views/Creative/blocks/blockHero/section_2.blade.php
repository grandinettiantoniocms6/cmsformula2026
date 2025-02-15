<section class="bg-fixed hero-section division" style="background-image: url('{{ $sfondo }}'); height: {!! $height !!}; background-position: bottom center; padding-top: 140px; padding-bottom: 50px;">
    <div class="container">
        <div class="row d-flex align-items-center">
            <!-- HERO TEXT -->
            <div class="col-md-6 col-xl-5">
                <div class="hero-txt white-color">

                    <h3>{{ $title[\App::getLocale()] }}</h3>

                    <p>{!! $description[\App::getLocale()] !!}</p>

                    @if(trim($button[\App::getLocale()])!="")
                        <a target="{{ $type_href }}" class="btn btn-md btn-primary tra-white-hover" href="{{ $url }}">
                            <span>{{ $button[\App::getLocale()] }}</span>
                        </a>
                    @endif

                </div>
            </div>	<!-- END HERO TEXT -->


            <!-- HERO IMAGE -->
            <div class="col-md-6 col-xl-7">
                <div class="hero-9-img text-center">
                    @if($value->foto)
                        <img class="img-fluid" src="{{ $foto }}" alt="">
                    @endif
                </div>
            </div>


        </div><!-- End row -->
    </div>
</section>
