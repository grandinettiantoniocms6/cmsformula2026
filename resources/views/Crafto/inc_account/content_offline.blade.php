<div class="section-fullscreen bg-image">
    <div class="bg-black-05">
        <div class="container text-center">
            <div class="position-top">
                <div class="row align-items-center col-spacing-0">
                    <div class="col-6 text-left">
                    </div>
                    <div class="col-6 text-right">
                    </div>
                </div><!-- end row -->
            </div><!-- end position-top -->
            <div class="position-middle">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <h1 class="font-weight-light margin-bottom-30">Sito in allestimento</h1>
                        @if($website->offline_description)
                            {!! $website->offline_description !!}
                        @endif
                    </div>
                </div><!-- end row -->
            </div><!-- end position-middle -->
        </div><!-- end container -->
    </div>
</div>
