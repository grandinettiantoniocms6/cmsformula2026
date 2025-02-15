<div class="col-lg-{{ $item->col }} col-md-3 col-sm-4">
    <div class="card-group" style="padding: 10px;">
        <div class="card-mosaico wow animate__fadeInUp" data-wow-duration=".3s" >
            <img class="img-fluid card-img-top" src="{{ $foto }}" alt="" loading="lazy">
            @if(trim($button[\App::getLocale()])!="")
                <br><br><h3 class="title">
                    <a target="{{ $type_href }}" href="{{ $url }}">{{ $name_surname[\App::getLocale()] }}</a>
                </h3>
            @endif

            <div class="role">{{ $role[\App::getLocale()] }}</div>
            <nav class="nav nav-contacts"">
            @if(trim($phone[\App::getLocale()])!="")
                <span class="phone nav-link py-1 px-2"><i class="bi bi-telephone"></i> {{ $phone[\App::getLocale()] }}</span>
            @endif
            @if(trim($email[\App::getLocale()])!="")
                <span class="email nav-link py-1 px-2"><i class="bi bi-envelope"></i> {{ $email[\App::getLocale()] }}</span>
                @endif
                </nav>
                <nav class="nav nav-social">
                    @if(trim($social_1[\App::getLocale()])!="")
                        <a class="nav-link nav-link-facebook"" target="{{ $type_href_1 }}" href="{{ $url_1 }}"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(trim($social_2[\App::getLocale()])!="")
                        <a class="nav-link nav-link-instagram" target="{{ $type_href_2 }}" href="{{ $url_2}}"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(trim($social_3[\App::getLocale()])!="")
                        <a class="nav-link nav-link-linkedin" target="{{ $type_href_3 }}" href="{{ $url_3}}"><i class="fab fa-linkedin"></i></a>
                    @endif
                    @if(trim($social_4[\App::getLocale()])!="")
                        <a class="nav-link nav-link-twitter" target="{{ $type_href_4 }}" href="{{ $url_4}}"><i class="fab fa-twitter"></i></a>
                    @endif
                </nav>
        </div>

    </div>
</div>
