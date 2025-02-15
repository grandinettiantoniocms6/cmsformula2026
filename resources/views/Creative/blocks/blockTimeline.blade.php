<section class="our-history page-section-ptb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="timeline-dots"></div>
                    <ul class="timeline">
                        @if($array)
                            <?php
                            $i = 1;
                            ?>
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

                                    $perc = $i%2;

                                    ?>

                                @if($perc == 0)

                                    <li>
                                        <div class="timeline-badge"><p class="theme-color">{{ $date[\App::getLocale()] }}</p></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title text-muted">{{ $title[\App::getLocale()] }}</h5>

                                                </div>
                                                <div class="timeline-body">
                                                    <p> {!! $description[\App::getLocale()] !!}</p>
                                                </div>
                                        </div>
                                    </li>


                                @else

                                    <li class="timeline-inverted">
                                        <div class="timeline-badge"><p class="theme-color">{{ $date[\App::getLocale()] }}</p></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title text-muted">{{ $title[\App::getLocale()] }} </h5>
                                                </div>
                                                <div class="timeline-body">
                                                    <p> {!! $description[\App::getLocale()] !!}</p>
                                                </div>
                                            </div>
                                    </li>


                                @endif
                                <?php $i++;?>
                            @endforeach
                        @endif
                                    <li class="timeline-arrow"><i class="fa fa-chevron-down"></i></li>
                    </ul>

            </div>
        </div>
    </div>
</section>
