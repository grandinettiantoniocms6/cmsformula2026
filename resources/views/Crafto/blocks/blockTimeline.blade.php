<section class="big-section" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-12 col-lg-12 md-mb-15 sm-mb-20 text-center">


                <div class="row row-cols-1">
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

                                <div class="col-12 process-step-style-05 position-relative hover-box">
                                    <div class="process-step-item d-flex">
                                        <div class="process-step-icon-wrap position-relative">
                                            <div class="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-60px w-60px fs-16 bg-solitude-blue fw-600 position-relative">
                                                <span class="number position-relative z-index-1 text-dark-gray">{{ $title[\App::getLocale()] }}</span>
                                                <div class="box-overlay bg-black rounded-circle"></div>
                                            </div>
                                            <span class="progress-step-separator bg-dark-gray opacity-1"></span>
                                        </div>
                                        <div class="process-content ps-30px last-paragraph-no-margin mb-30px">
                                            <span class="d-block fw-600 text-dark-gray mb-5px fs-18">{{ $date[\App::getLocale()] }}</span>
                                            <p class="w-90 lg-w-100">{!! $description[\App::getLocale()] !!}</p>
                                        </div>
                                    </div>
                                </div>

                            @else

                                <div class="col-12 process-step-style-05 position-relative hover-box">
                                    <div class="process-step-item d-flex">
                                        <div class="process-step-icon-wrap position-relative">
                                            <div class="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-60px w-60px fs-16 bg-solitude-blue fw-600 position-relative">
                                                <span class="number position-relative z-index-1 text-dark-gray">{{ $title[\App::getLocale()] }}</span>
                                                <div class="box-overlay bg-black rounded-circle"></div>
                                            </div>
                                            <span class="progress-step-separator bg-dark-gray opacity-1"></span>
                                        </div>
                                        <div class="process-content ps-30px last-paragraph-no-margin mb-30px">
                                            <span class="d-block fw-600 text-dark-gray mb-5px fs-18">{{ $date[\App::getLocale()] }}</span>
                                            <p class="w-90 lg-w-100">{!! $description[\App::getLocale()] !!}</p>
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
    </div>
</section>

