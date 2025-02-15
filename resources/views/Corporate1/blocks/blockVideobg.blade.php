<section class="block-videobg" id="videobg-{{ $item->id }}">
    <div class="js-video [youtube, widescreen]">
        @if($item)
            <?php
                $temp = explode("=", $item->video);
                $controls = $item->controls;
                $autoplay = $item->autoplay;
                $mute = $item->mute;
            ?>
                <div class="plyr__video-embed js-player" id="player-videobg-{{$item->id}}">
                    <iframe
                        class="_iub_cs_activate"
                        src="https://www.youtube.com/embed/{!! $temp[1] !!}?controls={!! $controls !!}&autoplay={!! $autoplay !!}&mute={!! $mute !!}&showinfo=0&modestbranding=1&rel=0"
                        allowfullscreen
                        allowtransparency
                    ></iframe>
                </div>
        @endif
    </div>
</section>






