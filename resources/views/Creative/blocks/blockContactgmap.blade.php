@if($array)
    @foreach($array as $value)
        <?php

        // questi 4 input sono multilingua e vanno scritti così
        $subtitle = json_decode($value->subtitle, true);
        if($subtitle === null){
            $subtitle = [];
        }

        $title = json_decode($value->title, true);
        if($title === null){
            $title = [];
        }

        $description = json_decode($value->description, true);
        if($description === null){
            $description = [];
        }

        $description2 = json_decode($value->description2, true);
        if($description2 === null){
            $description2 = [];
        }

        // per i successivi non essendo multilingua li scrivo così
        $bg_box = $value->bg_box;
        $margin_top = $item->margin_top;
        $margin_bottom = $item->margin_bottom;
        $color_txt = $value->color_txt;
        $height_gmap = $value->height_gmap;
        $url = $value->url;
        $address1 = $value->address1;
        $address2 = $value->address2;
        $address3 = $value->address3;
        $phone1 = $value->phone1;
        $phone2 = $value->phone2;
        $phone3 = $value->phone3;
        $fax = $value->fax;
        $email1 = $value->email1;
        $email2 = $value->email2;
        $email3 = $value->email3;
        $pec = $value->pec;

        // solo per i 4 campi multilingua devo fare gli if qui
        if(!key_exists(\App::getLocale(), $subtitle)){
            $subtitle[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $title)){
            $title[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $description)){
            $description[\App::getLocale()] = "";
        }

        if(!key_exists(\App::getLocale(), $description2)){
            $description2[\App::getLocale()] = "";
        }

        // invece per i campi monolingua gli if li faccio fuori (vedi riga 69 e altre sotto)

        ?>

            <section class="theme-bg " style="background-color: {{ $value->bg_box }}; margin-top: {{ $margin_top }}px; margin-bottom: {{ $margin_bottom }}px;">
                <div class="container-fluid pos-r">
                    <div class="row">
                        <div class="col-lg-6 map-side map-right order-2 order-lg-1">
                            @if($url)
                                @if(env('IUBENDA') == 1)
                                    <iframe class="_iub_cs_activate" data-suppressedsrc="{{ $url }}" width="100%" height="{{ $height_gmap }}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                @else
                                    <iframe src="{{ $url }}" width="100%" height="{{ $height_gmap }}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                @endif
                            @endif
                        </div>

                        <div class="col-lg-5 ml-60 order-1 order-lg-2">
                            <div class="contact-3-info page-section-ptb text-white">
                                <div class="clearfix">
                                    <h6 style="color: {{ $value->color_txt }};">{{ $subtitle[\App::getLocale()] }}</h6>
                                    <h2 style="color: {{ $value->color_txt }};">{{ $title[\App::getLocale()] }}</h2>
                                    <p>{!! $description[\App::getLocale()] !!} </p>

                                    <ul class="addresss-info list-unstyled">

                                        @if($address1)
                                            <li><i style="color: {{ $value->color_txt }};" class="ti-map-alt"></i> <p style="color: {{ $value->color_txt }};">{{ $address1 }}</p> </li>
                                        @endif

                                        @if($address2)
                                            <li><i style="color: {{ $value->color_txt }};" class="ti-map-alt"></i> <p style="color: {{ $value->color_txt }};">{{ $address2 }}</p> </li>
                                        @endif

                                        @if($address3)
                                            <li><i style="color: {{ $value->color_txt }};" class="ti-map-alt"></i> <p style="color: {{ $value->color_txt }};">{{ $address3 }}</p> </li>
                                        @endif

                                        @if($phone1 or $phone2 or $phone3 )
                                            <li><i style="color: {{ $value->color_txt }};" class="ti-mobile"></i><p style="color: {{ $value->color_txt }};">{{ $phone1 }} {{ $phone2 }} {{ $phone3 }}</p></li>
                                        @endif

                                        @if($fax)
                                            <li><i style="color: {{ $value->color_txt }};" class="ti-mobile"></i><p style="color: {{ $value->color_txt }};">Fax: {{ $fax }}</p></li>
                                        @endif

                                        @if($email1 or $email2 or $email3 )
                                            <li><i style="color: {{ $value->color_txt }};" class="ti-email"></i><p style="color: {{ $value->color_txt }};">{{ $email1 }}  {{ $email2 }}  {{ $email3 }}</p></li>
                                        @endif

                                        @if($pec)
                                            <li><i style="color: {{ $value->color_txt }};" class="ti-email"></i><p style="color: {{ $value->color_txt }};">{{ $pec }}</p></li>
                                        @endif

                                    </ul>
                                    <div class="mt-50">
                                        <p>{!! $description2[\App::getLocale()] !!} </p>
                                    </div>
                                </div>
                            </div>
                        </div>

    @endforeach
@endif
                  </div>
                </div>
                <div class="clearfix"></div>
            </section>
