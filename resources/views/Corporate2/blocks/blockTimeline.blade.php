<section class="block-timeline">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg">
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
                                    <div class="timeline-badge">
                                        <div>{{ $date[\App::getLocale()] }}</div>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">{{ $title[\App::getLocale()] }}</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p> {!! $description[\App::getLocale()] !!}</p>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="timeline-inverted">
                                    <div class="timeline-badge">
                                        <div>{{ $date[\App::getLocale()] }}</div>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">{{ $title[\App::getLocale()] }} </h4>
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
                    <li class="timeline-arrow"><i class="bi bi-chevron-down"></i></li>
                </ul>
            </div>
        </div>
    </div>
</section>
