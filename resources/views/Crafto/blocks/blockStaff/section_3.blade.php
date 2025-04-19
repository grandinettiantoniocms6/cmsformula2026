<?php $website = \App\Models\WebsiteSetting::first(); ?>

<section class="bg-very-light-gray position-relative">
    <div class="{{ $item->fullwidth }} position-relative z-index-1">
        <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center">
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

                        $social_1 = json_decode($value->social_1, true);
                        if($social_1 === null){
                            $social_1 = [];
                        }

                        $social_2 = json_decode($value->social_2, true);
                        if($social_2 === null){
                            $social_2 = [];
                        }

                        $social_3 = json_decode($value->social_3, true);
                        if($social_3 === null){
                            $social_3 = [];
                        }

                        $social_4 = json_decode($value->social_4, true);
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

                        if(!key_exists(\App::getLocale(), $url_interno)){
                            $url_interno[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $url_esterno)){
                            $url_esterno[\App::getLocale()] = "";
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

                        // serve per le thumb
                        $photo = $value->foto;

                        // serve per le thumb
                        if($photo){
                            $basename = basename($photo);
                            $temp = explode(".", $basename);

                            $check = "thumb/blocks_staffs/$temp[0]-large.webp";
                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($photo);
                            }
                        }

                        ?>

                            <!-- start team member item -->
                            <div class="col-lg-{{ $item->col }} text-center team-style-03 md-mb-30px mt-50px">
                                <div class="p-15 lg-p-13 bg-white box-shadow-large box-shadow-large-hover border-radius-6px">
                                    @if(trim($foto) != "")
                                        <img src="{{ $foto }}" alt="{{ $name_surname[\App::getLocale()] }}" class="mb-25px d-block mx-auto h-200px w-200px rounded-circle" />
                                    @endif

                                    <span class="d-inline-block fw-600 fs-18 text-dark-gray">{{ $name_surname[\App::getLocale()] }}</span>
                                        @if(trim($role[\App::getLocale()])!="")
                                            <div class="mb-10px text-uppercase fs-14 lh-22 fw-500">Director</div>
                                        @endif
                                        @if(trim($email[\App::getLocale()])!="")
                                            <p class="m-0">{{ $email[\App::getLocale()] }}</p>
                                        @endif
                                        @if(trim($phone[\App::getLocale()])!="")
                                            <p class="m-0">{{ $phone[\App::getLocale()] }}</p>
                                        @endif

                                    <div class="elements-social social-icon-style-04">
                                        <ul class="small-icon dark">
                                            @if(trim($social_1[\App::getLocale()])!="")
                                                <a href="{{ $url_1 }}" target="{{ $type_href_1 }}" class="facebook"><i class="fa-brands fa-facebook-f"></i><span></span></a>
                                            @endif
                                            @if(trim($social_2[\App::getLocale()])!="")
                                                <a target="{{ $type_href_2 }}" href="{{ $url_2 }}" class="instagram"><i class="fa-brands fa-instagram"></i><span></span></a>
                                            @endif
                                            @if(trim($social_3[\App::getLocale()])!="")
                                                <a target="{{ $type_href_3 }}" href="{{ $url_3 }}" class="linkedin"><i class="fa-brands fa-linkedin"></i><span></span></a>
                                            @endif
                                            @if(trim($social_4[\App::getLocale()])!="")
                                                <a href="{{ $url_4 }}" target="{{ $type_href_4 }}" class="fw-600 text-dark-gray">{{ $social_4[\App::getLocale()] }}</a>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- end team member item -->

                @endforeach
            @endif

        </div>
    </div>
</section>
