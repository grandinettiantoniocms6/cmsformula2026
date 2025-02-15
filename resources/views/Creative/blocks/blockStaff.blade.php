<section class="meet-team page-section-ptb">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="isotope full-screen columns-{{ $item->col }}">
                    @if($array)
                    @foreach($array as $value)
                        <?php

                        $name_surname = json_decode($value->name_surname, true);
                        if($name_surname === null){
                            $name_surname = [];
                        }

                        $role = json_decode($value->role, true);
                        if($role === null){
                            $role = [];
                        }

                        $phone = json_decode($value->phone, true);
                        if($phone === null){
                            $phone = [];
                        }

                        $email = json_decode($value->email, true);
                        if($email === null){
                            $email = [];
                        }

                        $col = $item->col;

                        $social_1 = json_decode($value->url_1, true);
                        if($social_1 === null){
                            $social_1 = [];
                        }

                        $social_2 = json_decode($value->url_2, true);
                        if($social_2 === null){
                            $social_2 = [];
                        }

                        $social_3 = json_decode($value->url_3, true);
                        if($social_3 === null){
                            $social_3 = [];
                        }

                        $social_4 = json_decode($value->url_4, true);
                        if($social_4 === null){
                            $social_4 = [];
                        }

                        $url_interno = json_decode($value->url_interno, true);
                        if($url_interno === null){
                            $url_interno = [];
                        }

                        $url_esterno = json_decode($value->url, true);
                        if($url_esterno === null){
                            $url_esterno = [];
                        }

                        $button = json_decode($value->button, true);
                        if($button === null){
                            $button = [];
                        }

                        $type_href = $value->type_href;
                        $type_href_1 = $value->type_href_1;
                        $type_href_2 = $value->type_href_2;
                        $type_href_3 = $value->type_href_3;
                        $type_href_4 = $value->type_href_4;

                        $url = "#";

                        if(key_exists(\App::getLocale(), $url_interno)){
                            if(trim($url_interno[\App::getLocale()]) != ""){
                                $url = "/{$url_interno[\App::getLocale()]}";
                            }
                        }
                        if(key_exists(\App::getLocale(), $url_esterno)){
                            if(trim($url_esterno[\App::getLocale()]) != ""){
                                $url = $url_esterno[\App::getLocale()];
                            }
                        }

                        if(!key_exists(\App::getLocale(), $name_surname)){
                            $name_surname[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $social_1)){
                            $social_1[\App::getLocale()] = "";
                        }

                        $url_1 = "#";

                        if(key_exists(\App::getLocale(), $social_1)){
                            if(trim($social_1[\App::getLocale()]) != ""){
                                $url_1 = $social_1[\App::getLocale()];
                            }
                        }

                        if(!key_exists(\App::getLocale(), $social_2)){
                            $social_2[\App::getLocale()] = "";
                        }

                        $url_2 = "#";

                        if(key_exists(\App::getLocale(), $social_2)){
                            if(trim($social_2[\App::getLocale()]) != ""){
                                $url_2 = $social_2[\App::getLocale()];
                            }
                        }

                        if(!key_exists(\App::getLocale(), $social_3)){
                            $social_3[\App::getLocale()] = "";
                        }

                        $url_3 = "#";

                        if(key_exists(\App::getLocale(), $social_3)){
                            if(trim($social_3[\App::getLocale()]) != ""){
                                $url_3 = $social_3[\App::getLocale()];
                            }
                        }

                        if(!key_exists(\App::getLocale(), $social_4)){
                            $social_4[\App::getLocale()] = "";
                        }

                        $url_4 = "#";

                        if(key_exists(\App::getLocale(), $social_4)){
                            if(trim($social_4[\App::getLocale()]) != ""){
                                $url_4 = $social_4[\App::getLocale()];
                            }
                        }


                        if(!key_exists(\App::getLocale(), $button)){
                            $button[\App::getLocale()] = "";
                        }

                        ?>

                        <!-- ciclo -->
                                <div class="grid-item">
                                    <div class="team team-hover">
                                        <div class="team-photo">
                                            <img class="img-fluid mx-auto" src="{{ $value->foto }}" alt="">
                                        </div>
                                        <div class="team-description">
                                            <div class="team-info">
                                                <h5>{{ $name_surname[\App::getLocale()] }}</h5>
                                                @if(trim($button[\App::getLocale()])!="")
                                                    <h5><a target="{{ $type_href }}" href="{{ $url }}"> {{ $button[\App::getLocale()] }}</a></h5>
                                                @endif
                                                <span>{{ $role[\App::getLocale()] }}</span>
                                            </div>
                                            <div class="team-contact">
                                                <span class="call"> {{ $phone[\App::getLocale()] }}</span>
                                                <span class="email"> <i class="fa fa-envelope-o"></i> {{ $email[\App::getLocale()] }}</span>
                                            </div>
                                            <div class="social-icons color clearfix">
                                                <ul>
                                                    <li class="social-facebook">
                                                        @if(trim($social_1[\App::getLocale()])!="")
                                                           <a target="{{ $type_href_1 }}" href="{{ $url_1 }}"><i class="fab fa-facebook"></i></a>
                                                        @endif
                                                    </li>
                                                    <li class="social-twitter">
                                                        @if(trim($social_2[\App::getLocale()])!="")
                                                            <a target="{{ $type_href_2 }}" href="{{ $url_2}}"><i class="fab fa-instagram"></i></a>
                                                        @endif
                                                    </li>
                                                    <li class="social-instagram">
                                                        @if(trim($social_3[\App::getLocale()])!="")
                                                            <a target="{{ $type_href_3 }}" href="{{ $url_3}}"><i class="fab fa-linkedin"></i></a>
                                                        @endif
                                                    </li>
                                                    <li class="social-linkedin">
                                                        @if(trim($social_4[\App::getLocale()])!="")
                                                            <a target="{{ $type_href_4 }}" href="{{ $url_4}}"><i class="fab fa-twitter"></i></a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <!-- / ciclo -->

                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
