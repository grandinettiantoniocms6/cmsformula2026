@if($array)
    <section class="block-videotutorial">
        <div class="container">
    @foreach($array as $value)
        <?php

        $temp = explode("=", $value->video);
        // variabili settaggi qui
        $controls = $value->controls;
        $autoplay = $value->autoplay;
        $mute = $value->mute;

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
            <div class="row gx-lg-5 mt-3">
                <div class="col-lg-12 mb-4">
                    <div class="plyr__video-embed js-player" id="player-{{$value->id}}">
                        <iframe
                            class="_iub_cs_activate"
                            width="100%"
                            height="520px"
                            src="https://www.youtube.com/embed/{!! $temp[1] !!}?controls={!! $controls !!}&autoplay={!! $autoplay !!}&mute={!! $mute !!}&showinfo=0&modestbranding=1&rel=0"
                            allowfullscreen
                            allowtransparency
                        ></iframe>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">

                            <div class="text-dark-gray fs-18 fw-600">{{ $subtitle[\App::getLocale()] }}</div>
                            <div class="text-dark-gray fs-18 fw-600">{{ $title[\App::getLocale()] }}</h2>
                            {!! $description[\App::getLocale()] !!}

                </div>

            </div>
    @endforeach
            </div>
    </section>
@endif
