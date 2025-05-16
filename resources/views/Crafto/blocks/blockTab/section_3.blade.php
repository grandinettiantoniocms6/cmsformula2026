<section class="block-tabs style-{{ $item->style }}" id="block-tabs-{{ $item->id }}">
    <div class="{{ $item->fullwidth }} mt-{{ $item->mt }}px">
        <div class="tab">
            @if($array)

                <style>
                    #block-tabs-{{ $item->id }} .nav-item {
                        background-color: {{ $item->bgcolor }};
                    }
                    #block-tabs-{{ $item->id }} .nav-link {
                        color: {{ $item->btn_txt_color }};
                        border-radius: 0;
                        background-color: transparent;
                        border-bottom: 2px solid {{ $item->btn_txt_color }};
                        font-weight: 600;
                    }
                    #block-tabs-{{ $item->id }} .nav-link:hover {
                        color: {{ $item->btn_color_hover }};
                        border-color: {{ $item->btn_color_hover }};
                    }
                    #block-tabs-{{ $item->id }} .nav-link:active, #block-tabs-{{ $item->id }} .nav-link.active {
                        color: {{ $item->btn_color_active }};
                        border-color: {{ $item->btn_color_active }};
                    }
                </style>
                <ul class="nav nav-pills mb-3" role="tablist">
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
                            <a class="nav-link {{ $active }}"
                               id="li-tab-{{ $value->id }}"
                               data-bs-toggle="tab"
                               role="tab"
                               aria-controls="{{ $value->id }}"
                               data-bs-target="#tab-{{ $value->id }}"
                               href="#tab-{{ $value->id }}">{{ $title[\App::getLocale()] }}
                            </a>
                        </li>
                        <?php $i++; ?>
                    @endforeach
                </ul>
            @endif
            <div class="tab-content" id="tab-content-tab-id-{{ $item->id }}">
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
                        <div class="tab-pane fade {{ $active }} {{ $show }}" id="tab-{{ $value->id }}" role="tabpanel">
                            {!! $description[\App::getLocale()] !!}
                        </div>
                        <?php $i++; ?>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
