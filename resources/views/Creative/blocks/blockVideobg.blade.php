<div id="player">
    <div class="js-video [youtube, widescreen]">
        @if($item)
            <?php
                $temp = explode("=", $item->video);

                // variabili settaggi qui
                $controls = $item->controls;
                $autoplay = $item->autoplay;
                $mute = $item->mute;
                //nella riga 13 i valori pilotati li metto con {!! $variabile !!}

            ?>
                @if(env('IUBENDA') == 1)
                    <iframe class="_iub_cs_activate" data-suppressedsrc="https://www.youtube.com/embed/{{ $temp[1] }}?controls={!! $controls !!}&autoplay={!! $autoplay !!}&mute={!! $mute !!}&showinfo=0&modestbranding=1&rel=0" allowfullscreen="allowfullscreen"></iframe>
                @else
                    <iframe src="https://www.youtube.com/embed/{{ $temp[1] }}?controls={!! $controls !!}&autoplay={!! $autoplay !!}&mute={!! $mute !!}&showinfo=0&modestbranding=1&rel=0" allowfullscreen="allowfullscreen"></iframe>
                @endif

        @endif
    </div>
</div>






