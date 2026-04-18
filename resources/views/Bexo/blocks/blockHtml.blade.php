@if($item)
    <?php
        $description = json_decode($item->content, true);
        if($description === null){
            $description = [];
        }

        $foto = "";
        if($item->foto){
            $basename = basename($item->foto);
            $temp = explode(".", $basename);

            if(key_exists(1,$temp)){
                $check = "thumb/blocks_html/$temp[0]-large.webp";
            }else{
                $check = "thumb/blocks_html/$temp[0]-large";
            }

            if(file_exists($check)){
                $foto = url($check);
            }else{
                $foto = url($item->foto);
            }
        }


    ?>
    @if($item->is_with_section && $position != 'footer')
        <section class="block-html" id="block-html-{{ $item->id }}" data-anime='{"translateX": [50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
            <div class="container">
                @if(key_exists(\App::getLocale(), $description))
                    {!! $description[\App::getLocale()] !!}
                @endif
            </div>
        </section>
    @else
        <section @if($position != 'footer') style="background-color: {!! $item->bgcolor !!}; background-image: url('{!! $foto !!}'); background-repeat:repeat;background-position:left top;" @endif class="block-html" id="2block-html-{{ $item->id }}" data-anime='{"translateX": [50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
            <div class="container-fluid col-lg-{{ $item->col }} mx-auto" style="padding: 20px; margin-top: {{ $item->mt }}px;">
                @if(key_exists(\App::getLocale(), $description))
                    {!! $description[\App::getLocale()] !!}
                @endif
            </div>
        </section>
    @endif
@endif

