<section class="block-timeline">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <ul class="timeline">
                    @if($array)
                        @foreach($array as $value)
                                <?php

                                $date = json_decode($value->date, true);
                                if($date === null){
                                    $date = [];
                                }

                                $title = json_decode($value->title, true);
                                if($title === null){
                                    $title = [];
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

                                ?>

                                <li class="timeline-inverted">

                                    <div class="timeline-badge wow animate__fadeInLeft" data-wow-duration=".6s" style="background-color: {!! $item->bg_color !!}!important;">
                                        <div style="color: {!! $item->date_color !!}!important;">{{ $date[\App::getLocale()] }}</div>
                                    </div>
                                    <div class="timeline-panel wow animate__fadeInRight" data-wow-duration=".9s">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title" style="color: {!! $item->title_color !!}!important;">{{ $title[\App::getLocale()] }}</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p> {!! $description[\App::getLocale()] !!}</p>
                                        </div>
                                    </div>

                                </li>


                        @endforeach
                    @endif
                    <li class="timeline-arrow"><i class="bi bi-chevron-down"></i></li>
                </ul>
            </div>
        </div>
    </div>
</section>
