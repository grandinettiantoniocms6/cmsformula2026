<section class="gray-bg page-section-ptb">
    <div class="container">
        <div class="row ">
            <div class="col-sm-12">

                @if($array)
                    <?php
                    $i = 1;
                    ?>
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

                        $perc = $i%2;

                        ?>

                        @if($perc == 0)

                                <div class="process-box-02 mt-40 pr-50 sm-pr-0">
                                    <div class="process-step float-none float-sm-right ml-0 ml-sm-4">
                                        <h1 style="color: {{ $value->bg_number }};">{{ $number[\App::getLocale()] }}</h1>
                                    </div>
                                    <div class="process-content process-right text-right d-table-cell">
                                        <div class="process-info process-right white-bg p-4">
                                            <h5 class="mb-20" style="color: {{ $value->bg_title }};"> {{ $title[\App::getLocale()] }}</h5>
                                            <p>{!! $description[\App::getLocale()] !!}</p>
                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" class="button button-lg" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                        @else

                                <div class="process-box-02 mt-40 pr-50 sm-pr-0">
                                    <div class="process-step float-none float-sm-left mr-30">
                                        <h1 style="color: {{ $value->bg_number }};">{{ $number[\App::getLocale()] }}</h1>
                                    </div>
                                    <div class="process-content process-left text-left d-table-cell">
                                        <div class="process-info white-bg p-4">
                                            <h5 class="mb-20" style="color: {{ $value->bg_title }};"> {{ $title[\App::getLocale()] }}</h5>
                                            <p>{!! $description[\App::getLocale()] !!}</p>
                                            @if(trim($button[\App::getLocale()])!="")
                                                <a target="{{ $type_href }}" class="button button-lg" href="{{ $url }}"><i class="ti-arrow-right"></i><span>{{ $button[\App::getLocale()] }}</span></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                        @endif
                        <?php $i++;?>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>
