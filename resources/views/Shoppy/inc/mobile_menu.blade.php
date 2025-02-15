<!-- MobileMenu -->
<div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay">
    </div>
    <!-- End of Overlay -->
    <a class="mobile-menu-close" href="#"><i class="d-icon-times"></i></a>
    <!-- End of CloseButton -->
    <div class="mobile-menu-container scrollable">
        <form action="#" class="input-wrapper">
            <input type="text" class="form-control" name="search" autocomplete="off"
                   placeholder="Search your keyword..." required />
            <button class="btn btn-search" type="submit">
                <i class="d-icon-search"></i>
            </button>
        </form>
        <ul class="mobile-menu mmenu-anim">
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
    </div>
</div>



