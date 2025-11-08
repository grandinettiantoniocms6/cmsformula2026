@if($array)
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

            // serve per le thumb se non lo uso, la foto la richiamo così: src="{{ $value->foto }}"
            $photo = $item->foto;

            if($photo){
                $basename = basename($photo);
                $temp = explode(".", $basename);

                $check = "thumb/blocks_countdown/$temp[0]-large.webp";
                if(file_exists($check)){
                    $foto = url($check);
                }else{
                    $foto = url($photo);
                }
            }

            // Sfondo

            switch ($item->alpha) {
                case 0:
                    $alpha_bg = '00';
                    break;
                case 100:
                    $alpha_bg = '';
                    break;
                default:
                    $alpha_bg = $item->alpha;
            }

            $blockbg = $item->bgcolor.$alpha_bg;

            ?>

                <!-- Velina o layer trasparente sopra img o colore sfondo -->
            <style>
                .banner::after { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: linear-gradient(120deg, #131313, #1f1f1f); opacity: 0.{{ $item->alpha }}; }
                .banner { position: relative; min-height: 60vh; background-size: cover; display: flex; }
                .banner::before { z-index: -1; }
                .banner > * { z-index: 2; }
            </style>
            <!-- Velina o layer trasparente sopra img o colore sfondo -->


@if(trim($item->foto) != "")
<section class="cover-background pt-{{ $item->pt }}" style="background-image:url('{{ $foto }}'); height: {{ $item->height }}px;">
    <div class="layer" style="background-color: rgba(0, 0, 0, 0.{{ $item->alpha }}); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
@else

<section class="background-position-center-top overflow-hidden pt-{{ $item->pt }}" style="background-color:{{ $item->bgcolor }}; height: {{ $item->height }}px;">
@endif

    <div class="{{ $item->fullwidth }}" data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

            <!-- start countdown item -->
            <div class="row align-items-center justify-content-center h-100 z-index-2 position-relative">
                <div class="col-md-10 col-lg-10 col-xl-6 text-center">
                    <h1 class="fw-700 fs-80 mb-20px d-block alt-font ls-minus-2px" style="color: {{ $item->color_title }};">{{ $title[\App::getLocale()] }}</h1>
                        {!! $description[\App::getLocale()] !!}
                    <div class="col d-flex justify-content-center countdown-style-01">
                        <div data-enddate="{{ $value->year }}/{{ $value->mounth }}/{{ $value->day }} {{ $value->hours }}:{{ $value->minutes }}:00" class="countdown"></div>
                    </div>
                </div>
            </div>
            <!-- end countdown item -->

  @endforeach
@endif
        </div>
</section>


