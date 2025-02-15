<section class="block-flusso wow animate__fadeInUp" data-wow-duration=".3s">
    <div class="container">
        @if($array)
            <?php $i = 1; ?>
            @foreach($array as $value)
                <?php
                $number = json_decode($value->number, true);
                if($number === null){
                    $number = [];
                }
                $bg_number = json_decode($value->bg_number, true);
                if($bg_number === null){
                    $bg_number = [];
                }

                $title = json_decode($value->title, true);
                if($title === null){
                    $title = [];
                }

                $bg_title = json_decode($value->bg_title, true);
                if($bg_title === null){
                    $bg_title = [];
                }

                $description = json_decode($value->description, true);
                if($description === null){
                    $description = [];
                }

                $url_interno = json_decode($value->url_interno, true);
                if($url_interno === null){
                    $url_interno = [];
                }

                $url_esterno = json_decode($value->url, true);
                if($url_esterno === null){
                    $url_esterno = [];
                }

                $button = json_decode($value->button, true);
                if($button === null){
                    $button = [];
                }

                $type_href = $value->type_href;

                if(!key_exists(\App::getLocale(), $description)){
                    $description[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $title)){
                    $title[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $button)){
                    $button[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $url_interno)){
                    $url_interno[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $url_esterno)){
                    $url_esterno[\App::getLocale()] = "";
                }

                $url = "#";

                if(key_exists(\App::getLocale(), $url_interno)){
                    if(trim($url_interno[\App::getLocale()]) != ""){
                        $url = "/{$url_interno[\App::getLocale()]}";
                    }else{
                        if(key_exists(\App::getLocale(), $url_esterno)){
                            if(trim($url_esterno[\App::getLocale()]) != ""){
                                $url = $url_esterno[\App::getLocale()];
                            }
                        }
                    }
                }

                $perc = $i%2; ?>

                @if($perc == 0)

                        <div class="process right wow animate__fadeInUp" data-wow-duration="3s">
                            <div class="process-step">
                                <strong style="background-color: {{ $value->bg_number }}">{{ $number[\App::getLocale()] }}</strong>
                            </div>
                            <div class="process-content text-right">
                                <div class="process-icon">
                                    <span></span>
                                </div>
                                <div class="process-info">
                                    <h4 class="title" style="color: {{ $value->bg_title }}">{{ $title[\App::getLocale()] }}</h4>
                                    <div class="description">{!! $description[\App::getLocale()] !!}</div>
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="border-area right-top"></div>
                            <div class="border-area right-bottom"></div>
                        </div>

                @else
                        <div class="process left wow animate__fadeInLeft" data-wow-duration="3s">
                            <div class="process-step">
                                <strong style="background-color: {{ $value->bg_number }}">{{ $number[\App::getLocale()] }}</strong>
                            </div>
                            <div class="process-content">
                                <div class="process-icon">
                                    <span></span>
                                </div>
                                <div class="process-info">
                                    <h4 class="title" style="color: {{ $value->bg_title }}">{{ $title[\App::getLocale()] }}</h4>
                                    <div class="description">{!! $description[\App::getLocale()] !!}</div>
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">{{ $button[\App::getLocale()] }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="border-area left-bottom"></div>
                            @if(!$loop->first)
                            <div class="border-area left-top"></div>
                            @endif
                        </div>

                @endif
                <?php $i++;?>
            @endforeach
        @endif
    </div>
</section>

