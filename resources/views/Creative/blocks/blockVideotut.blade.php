        @if($array)
            @foreach($array as $value)
                <?php

                $temp = explode("=", $value->video);
                // variabili settaggi qui
                $controls = $item->controls;
                $autoplay = $item->autoplay;
                $mute = $item->mute;

                $title = json_decode($value->title, true);
                if($title === null){
                    $title = [];
                }

                $subtitle = json_decode($value->subtitle, true);
                if($subtitle === null){
                    $subtitle = [];
                }

                $description = json_decode($value->description, true);
                if($description === null){
                    $description = [];
                }

                if(!key_exists(\App::getLocale(), $description)){
                    $description[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $title)){
                    $title[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $subtitle)){
                    $subtitle[\App::getLocale()] = "";
                }

                ?>

                <section class="page-section-ptb">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 sm-mb-30">
                                <div class="js-video [vimeo, widescreen] big" id="player">
                                    @if(env('IUBENDA') == 1)
                                        <iframe class="_iub_cs_activate" data-suppressedsrc="https://www.youtube.com/embed/{!! $temp[1] !!}?controls={!! $controls !!}&autoplay={!! $autoplay !!}&mute={!! $mute !!}&showinfo=0&modestbranding=1&rel=0" allowfullscreen="allowfullscreen"></iframe>
                                    @else
                                        <iframe src="https://www.youtube.com/embed/{!! $temp[1] !!}?controls={!! $controls !!}&autoplay={!! $autoplay !!}&mute={!! $mute !!}&showinfo=0&modestbranding=1&rel=0" allowfullscreen="allowfullscreen"></iframe>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="section-title mb-20">
                                    <h6>{{ $subtitle[\App::getLocale()] }}</h6>
                                    <h2>{{ $title[\App::getLocale()] }}</h2>
                                </div>
                                <p>{!! $description[\App::getLocale()] !!}</p>
                            </div>
                        </div>
                    </div>
                </section>

            @endforeach
        @endif
