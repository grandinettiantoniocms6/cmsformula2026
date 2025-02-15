<section class="key-features white-bg page-section-ptb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section-title text-center">
                    <h2 class="title-effect">Documenti</h2>
                </div>
            </div>
        </div>
            @if($array)
                <div class="row">
                    @foreach($array as $value)
                        @if(trim($value->file) != "" || $value->file)
                            <?php $title = json_decode($value->title, true); ?>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="feature-text round feature-border text-center mb-30">
                                        <a href="/uploads/{{ $value->file }}" target="_blank">
                                            <div class="feature-icon">
                                                <span aria-hidden="true" class="ti-cloud-down theme-color"></span>
                                            </div>
                                            <div class="feature-info">
                                               {{ $title[\App::getLocale()] }}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                        @endif
                    @endforeach
                </div>
            @endif
    </div>
</section>
