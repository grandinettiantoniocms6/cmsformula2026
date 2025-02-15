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
        <section class="block-html wow animate__fadeInUp" data-wow-duration=".3s" id="block-html-{{ $item->id }}">
            <div class="container space-{{ $item->mt }}">
                @if(key_exists(\App::getLocale(), $description))
                    {!! $description[\App::getLocale()] !!}
                @endif
            </div>
        </section>
    @else
        <section style="background-color: {!! $item->bgcolor !!}; background-image: url('{!! $foto !!}'); background-repeat:repeat;background-position:left top;" class="block-html wow animate__fadeInUp" data-wow-duration=".3s" id="2block-html-{{ $item->id }}">
            <div class="container-fluid space-{{ $item->mt }} col-lg-{{ $item->col }} mx-auto">
                @if(key_exists(\App::getLocale(), $description))
                    {!! $description[\App::getLocale()] !!}
                @endif
            </div>
        </section>
    @endif
@endif

