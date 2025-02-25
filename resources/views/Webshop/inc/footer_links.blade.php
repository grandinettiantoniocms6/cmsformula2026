<nav class="nav nav-links">

    <!-- Privacy Policy Iubenda -->
    @if(trim($website->iubenda_privacy) != "")
        <span style="padding: 6px;">{!! $website->iubenda_privacy !!}</span>
    @endif

    <!-- Privacy Policy base -->
    @if(trim($website->title_footer_2) != "")
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#footer_2">{{ $website->title_footer_2 }}</a>
    @endif

    <!-- Cookie Policy Iubenda -->
    @if(trim($website->iubenda_cookie) != "")
        <span style="padding: 6px;">{!! $website->iubenda_cookie !!}</span>
    @endif

    <!-- Cookie Policy base -->
    @if(trim($website->title_footer_3) != "")
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#footer_3">{{ $website->title_footer_3 }}</a>
    @endif

    <!-- Termini e condizioni -->
    @if(trim($website->iubenda_termini) != "")
        <span style="padding: 6px;">{!! $website->iubenda_termini !!}</span>
    @endif

    <!-- Footer 04 -->
    @if(trim($website->title_footer_4) != "")
        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#footer_4">{{ $website->title_footer_4 }}</a>
    @endif

    @if($website->photo_credits)
            <?php
            if(env('LOCAL') == 0){
                if(file_exists(public_path($website->photo_credits))){
                    list($width, $height, $type, $attr) = getimagesize("$website->photo_credits");
                }
            }
            ?>
        <a class="nav-link" href="{{ $website->link_credits }}" target="_blank" title="Sito realizzato da Webisland.it">
            <?php
                $exists = file_exists($website->photo_credits);
            ?>
            @if($exists)
                <img class="img-fluid mx-auto" alt="Sito realizzato da webisland.it" src="{{ url($website->photo_credits) }}" @if(env('LOCAL') == 0) width="{{ $width }}" height="{{ $height }}" @endif>
            @else
                Sito realizzato da webisland.it
            @endif
        </a>
    @endif
</nav>
