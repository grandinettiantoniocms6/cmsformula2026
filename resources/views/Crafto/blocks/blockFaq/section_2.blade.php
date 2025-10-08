<section class="big-section block-faq mt-3" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <h3 class="title" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay":150, "staggervalue": 150, "easing": "easeOutQuad" }'>{{ $item->name }}</h3>

            <div class="accordion accordion-style-02" id="accordion-{{ $item->id }}" data-active-icon="icon-feather-chevron-up" data-inactive-icon="icon-feather-chevron-down" data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

                @if($array)
                        <?php $i = 0;?>
                    @foreach($array as $value)
                            <?php
                            $id = $value->id;
                            $title = json_decode($value->title, true);
                            if($title === null){
                                $title = [];
                            }

                            $description = json_decode($value->description, true);
                            if($description === null){
                                $description = [];
                            }

                            $active = '';
                            $collapsed = 'collapsed';
                            if($i == 0){
                                $active = 'show';
                                $collapsed = '';
                            }

                            if(!key_exists(\App::getLocale(), $title)){
                                $title[\App::getLocale()] = "";
                            }

                            if(!key_exists(\App::getLocale(), $description)){
                                $description[\App::getLocale()] = "";
                            }
                            ?>

                                <div class="accordion-item {{ $active }}" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay":150, "staggervalue": 150, "easing": "easeOutQuad" }'>
                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                        <button class="accordion-button {{ $collapsed }}" style="background-color:#ffffff!important; border-color: #ffffff!important; border: 0px;" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-{{ $item->id }}-{{ $i }}" aria-expanded="false" aria-controls="collapseTwo">
                                            <b>{{ $title[\App::getLocale()] }}</b>
                                        </button>
                                    </div>
                                    <div id="accordion-collapse-{{ $item->id }}-{{ $i }}" class="accordion-collapse collapse {{$active }}" data-bs-parent="#accordion-{{ $item->id }}">
                                        <div class="accordion-body last-paragraph-no-margin border-color-light-medium-gray">
                                            {!! $description[\App::getLocale()] !!}
                                        </div>
                                    </div>
                                </div>
                            <?php $i++;?>


                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
