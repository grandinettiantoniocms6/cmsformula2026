<section class="block-faq mt-3">
    <div class="{{ $item->fullwidth }}">
        <h3 class="title" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay":150, "staggervalue": 150, "easing": "easeOutQuad" }'>{{ $item->name }}</h3>
            <div class="accordion" id="accordion-{{ $item->id }}">
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
                                <div class="accordion-header">
                                    <button class="accordion-button {{ $collapsed }}" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-{{ $item->id }}-{{ $i }}" aria-expanded="false" aria-controls="collapseTwo">
                                        {{ $title[\App::getLocale()] }}
                                    </button>
                                </div>
                                <div id="accordion-collapse-{{ $item->id }}-{{ $i }}" class="accordion-collapse collapse {{$active }}" data-bs-parent="#accordion-{{ $item->id }}">
                                    <div class="accordion-body">
                                        {!! $description[\App::getLocale()] !!}
                                    </div>
                                </div>
                            </div>
                            <?php $i++;?>
                @endforeach
            @endif
        </div>
    </div>
</section>
