<section class="block-tabs style-{{ $item->style }} mt-4" id="block-tabs-{{ $item->id }}" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }} mt-{{ $item->mt }}px">
        <div class="row align-items-center" data-anime='{ "el": "childs", "translateY": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 150, "staggervalue": 300, "easing": "easeOutQuad" }'>
            <div class="col-xl-3 col-lg-4 col-md-12 tab-style-05 md-mb-30px sm-mb-20px">
                <ul class="nav nav-tabs justify-content-center border-0 text-left fw-500 fs-18 alt-font">

                    @if($array)
                    <style>
                        #block-tabs-{{ $item->id }} .nav-item {
                            background-color: {{ $item->bgcolor }};
                        }
                        #block-tabs-{{ $item->id }} .nav-link {
                            color: {{ $item->btn_txt_color }};
                            margin: 0.5rem;
                        }
                        #block-tabs-{{ $item->id }} .nav-link:hover {
                            color: {{ $item->btn_color_hover }};
                        }
                        #block-tabs-{{ $item->id }} .nav-link:active, #block-tabs-{{ $item->id }} .nav-link.active {
                            color: #fff;
                            background-color: {{ $item->btn_color_active }};
                            border-color: {{ $item->btn_color_active }};
                        }
                    </style>

                    <?php $i = 0; ?>

                        @foreach($array as $value)
                        <?php

                            $title = json_decode($value->title, true);
                            if($title === null){
                                $title = [];
                            }

                            $description = json_decode($value->description, true);
                            if($description === null){
                                $description = [];
                            }

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $description)){
                                $description[\App::getLocale()] = "";
                            }

                            $active = "";
                            if($i == 0){
                                $active = "active";
                            }
                        ?>

                            <li class="nav-item">
                                <a id="li-tab-{{ $value->id }}"
                                   data-bs-toggle="tab" role="tab"
                                   aria-controls="{{ $value->id }}"
                                   data-bs-target="#tab-{{ $value->id }}"
                                   class="nav-link d-flex align-items-center {{ $active }}"
                                   href="#tab_four-{{ $value->id }}">
                                        <span>{{ $title[\App::getLocale()] }}</span>
                                </a>
                            </li>

                            <?php $i++; ?>

                        @endforeach
                </ul>
            </div>

                @endif

                    <div class="col-xl-9 col-lg-8 col-md-12">
                        <div class="tab-content">

                        @if($array)
                                <?php $i = 0; ?>
                            @foreach($array as $value)
                                    <?php

                                    $title = json_decode($value->title, true);
                                    if($title === null){
                                        $title = [];
                                    }

                                    $description = json_decode($value->description, true);
                                    if($description === null){
                                        $description = [];
                                    }

                                    $active = "";
                                    $show = "";
                                    if($i == 0){
                                        $active = "active";
                                        $show = "show";
                                    }
                                    ?>


                                        <!-- start tab content -->
                                        <div class="tab-pane fade {{ $active }} {{ $show }}" id="tab-{{ $value->id }}" role="tabpanel">
                                            <span class="margin-top: 1px; a:hover #ffffff!important;">{!! $description[\App::getLocale()] !!}</span>
                                        </div>
                                        <?php $i++; ?>
                                        <!-- end tab content -->

                            @endforeach
                        @endif

                        </div>
                    </div>
        </div>
    </div>
</section>
