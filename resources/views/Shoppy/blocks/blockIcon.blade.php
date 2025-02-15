<section class="key-features white-bg page-section-ptb">
    <div class="container">
        <div class="row">
            @if($array)
                @foreach($array as $value)
                    <?php
                    $title = json_decode($value->title, true);
                    $description = json_decode($value->description, true);

                    if(!key_exists(\App::getLocale(), $title)){
                        $title[\App::getLocale()] = "";
                    }

                    if(!key_exists(\App::getLocale(), $description)){
                        $description[\App::getLocale()] = "";
                    }
                    ?>

                    <div class="col-lg-{{ $item->col }} col-md-{{ $item->col }} col-sm-{{ $item->col }}">
                        <div class="feature-text round feature-border text-center mb-30">
                            @if($value->icon)
                               <div class="feature-icon">
                                   <i class="fa fa-{{ $value->icon }} theme-color" aria-hidden="true"></i>
                                   <!-- {!! $value->icon !!} -->
                               </div>
                            @endif
                                <div class="feature-info">
                                    <h5 class="text-back">{{ $title[\App::getLocale()] }}</h5>
                                    <p>{!! $description[\App::getLocale()] !!} </p>
                                </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
