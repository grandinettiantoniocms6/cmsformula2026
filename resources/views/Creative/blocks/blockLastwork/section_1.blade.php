<section class="portfolio-home o-hidden" style="background-color: {{ $value->bg_color }};">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4">
                <div class="portfolio-title section-title mt-md-5">
                    <h6 style="color: {{ $value->color_subtitle }};">{{ $subtitle[\App::getLocale()] }}</h6>
                    <h2 style="color: {{ $value->color_title }};">{{ $title[\App::getLocale()] }}</h2>
                    <p class="mb-20">{!! $description[\App::getLocale()] !!}</p>
                    @if(trim($button[\App::getLocale()])!="")
                        <a class="button mt-30" target="{{ $type_href }}" href="{{ $url }}" class="btn btn-primary">{{ $button[\App::getLocale()] }}</a>
                    @endif
                </div>
                <div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="isotope popup-gallery columns-3 no-padding">
                    <!-- CICLA -->
                    <div class="grid-item">
                        <div class="portfolio-item">
                            @if(trim($value->foto_1) != "")
                                <a class="d-block" target="{{ $type_href_1 }}" href="{{ $url_1 }}">
                                    <img src="{{ $value->foto_1 }}" alt="">
                                </a>
                            @endif
                            <div class="portfolio-overlay" style="background-color: {{ $website->color_gen1 }};">
                                @if(trim($button_1[\App::getLocale()])!="")
                                    <h4 style="color: {{ $website->color_gen2 }};">
                                        {{ $workname_1[\App::getLocale()] }}
                                    </h4>
                                    <span class="text-white">
                                                            <a target="{{ $type_href_1 }}" href="{{ $url_1 }}">{{ $worktype_1[\App::getLocale()] }} | {{ $button_1[\App::getLocale()] }}</a>
                                                        </span>
                                @endif
                            </div>
                            <a class="popup portfolio-img" href="{{ $value->foto_1 }}"><i class="fa fa-arrows-alt"></i></a>
                        </div>
                    </div>
                    <!-- / CICLA -->
                    <!-- CICLA -->
                    <div class="grid-item">
                        <div class="portfolio-item">
                            @if(trim($value->foto_2) != "")
                                <a class="d-block" target="{{ $type_href_2 }}" href="{{ $url_2 }}">
                                    <img src="{{ $value->foto_2 }}" alt="">
                                </a>
                            @endif
                            <div class="portfolio-overlay" style="background-color: {{ $website->color_gen1 }};">
                                @if(trim($button_2[\App::getLocale()])!="")
                                    <h4 style="color: {{ $website->color_gen2 }};">
                                        {{ $workname_2[\App::getLocale()] }}
                                    </h4>
                                    <span class="text-white">
                                                            <a target="{{ $type_href_2 }}" href="{{ $url_2 }}">{{ $worktype_2[\App::getLocale()] }} | {{ $button_2[\App::getLocale()] }}</a>
                                                        </span>
                                @endif
                            </div>
                            <a class="popup portfolio-img" href="{{ $value->foto_2 }}"><i class="fa fa-arrows-alt"></i></a>
                        </div>
                    </div>
                    <!-- / CICLA -->
                    <!-- CICLA -->
                    <div class="grid-item">
                        <div class="portfolio-item">
                            @if(trim($value->foto_3) != "")
                                <a class="d-block" target="{{ $type_href_3 }}" href="{{ $url_3 }}">
                                    <img src="{{ $value->foto_3 }}" alt="">
                                </a>
                            @endif
                            <div class="portfolio-overlay" style="background-color: {{ $website->color_gen1 }};">
                                @if(trim($button_3[\App::getLocale()])!="")
                                    <h4 style="color: {{ $website->color_gen2 }};">
                                        {{ $workname_3[\App::getLocale()] }}
                                    </h4>
                                    <span class="text-white">
                                                            <a target="{{ $type_href_3 }}" href="{{ $url_3 }}">{{ $worktype_3[\App::getLocale()] }} | {{ $button_3[\App::getLocale()] }}</a>
                                                        </span>
                                @endif
                            </div>
                            <a class="popup portfolio-img" href="{{ $value->foto_3 }}"><i class="fa fa-arrows-alt"></i></a>
                        </div>
                    </div>
                    <!-- / CICLA -->
                    <!-- CICLA -->
                    <div class="grid-item">
                        <div class="portfolio-item">
                            @if(trim($value->foto_4) != "")
                                <a class="d-block" target="{{ $type_href_4 }}" href="{{ $url_4 }}">
                                    <img src="{{ $value->foto_4 }}" alt="">
                                </a>
                            @endif
                            <div class="portfolio-overlay" style="background-color: {{ $website->color_gen1 }};">
                                @if(trim($button_4[\App::getLocale()])!="")
                                    <h4 style="color: {{ $website->color_gen2 }};">
                                        {{ $workname_4[\App::getLocale()] }}
                                    </h4>
                                    <span class="text-white">
                                                            <a target="{{ $type_href_4 }}" href="{{ $url_4 }}">{{ $worktype_4[\App::getLocale()] }} | {{ $button_4[\App::getLocale()] }}</a>
                                                        </span>
                                @endif
                            </div>
                            <a class="popup portfolio-img" href="{{ $value->foto_4 }}"><i class="fa fa-arrows-alt"></i></a>
                        </div>
                    </div>
                    <!-- / CICLA -->
                    <!-- CICLA -->
                    <div class="grid-item">
                        <div class="portfolio-item">
                            @if(trim($value->foto_5) != "")
                                <a class="d-block" target="{{ $type_href_5 }}" href="{{ $url_5 }}">
                                    <img src="{{ $value->foto_5 }}" alt="">
                                </a>
                            @endif
                            <div class="portfolio-overlay" style="background-color: {{ $website->color_gen1 }};">
                                @if(trim($button_5[\App::getLocale()])!="")
                                    <h4 style="color: {{ $website->color_gen2 }};">
                                        {{ $workname_5[\App::getLocale()] }}
                                    </h4>
                                    <span class="text-white">
                                                            <a target="{{ $type_href_5 }}" href="{{ $url_5 }}">{{ $worktype_5[\App::getLocale()] }} | {{ $button_5[\App::getLocale()] }}</a>
                                                        </span>
                                @endif
                            </div>
                            <a class="popup portfolio-img" href="{{ $value->foto_5 }}"><i class="fa fa-arrows-alt"></i></a>
                        </div>
                    </div>
                    <!-- / CICLA -->
                    <!-- CICLA -->
                    <div class="grid-item">
                        <div class="portfolio-item">
                            @if(trim($value->foto_6) != "")
                                <a class="d-block" target="{{ $type_href_6 }}" href="{{ $url_6 }}">
                                    <img src="{{ $value->foto_6 }}" alt="">
                                </a>
                            @endif
                            <div class="portfolio-overlay" style="background-color: {{ $website->color_gen1 }};">
                                @if(trim($button_6[\App::getLocale()])!="")
                                    <h4 style="color: {{ $website->color_gen2 }};">
                                        {{ $workname_6[\App::getLocale()] }}
                                    </h4>
                                    <span class="text-white">
                                                            <a target="{{ $type_href_6 }}" href="{{ $url_6 }}">{{ $worktype_6[\App::getLocale()] }} | {{ $button_6[\App::getLocale()] }}</a>
                                                        </span>
                                @endif
                            </div>
                            <a class="popup portfolio-img" href="{{ $value->foto_6 }}"><i class="fa fa-arrows-alt"></i></a>
                        </div>
                    </div>
                    <!-- / CICLA -->

                </div>
            </div>
        </div>
    </div>
</section>
