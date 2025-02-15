<ul class="menu menu-active-underline">
    @if($menu)
        @foreach($menu as $item)
            <li>
                @if($item->slug != "/")
                    <a href="/{{ $item->slug }}">
                @else
                     <a href="/">
                @endif
                    {{ $item->title }}
                    <!-- Se la voce di menu ha figli metti arrow -->
                    @if(count($item->figli))

                    @endif
                </a>
                <!-- sotto menu per ogni voce -->
                @if(count($item->figli))
                    <ul>
                        @foreach($item->figli as $figli)
                            <?php
                                $target = $figli->is_in_blank == 1 ? "_blank" : "";
                            ?>
                            <li>
                                <a href="{{ $figli->slug }}" target="{{ $target }}">{{ $figli->title }}

                                </a>

                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    @endif

</ul>
