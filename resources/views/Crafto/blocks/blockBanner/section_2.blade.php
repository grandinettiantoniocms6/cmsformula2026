
<section class="md-pt-0">
    <div class="{{ $item->fullwidth }}">
       <div class="row">

            @if($array)
                @foreach($array as $value)
                        <?php
                        $title = json_decode($value->title, true);
                        if($title === null){
                            $title = [];
                        }

                        $description = json_decode($value->description, true);
                        if($description === null){
                            $description = [];
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

                        $url = "#";

                        if(!key_exists(\App::getLocale(), $url_interno)){
                            $url = "";
                        }else{
                            if(trim($url_interno[\App::getLocale()]) != ""){
                                $url = "/{$url_interno[\App::getLocale()]}";
                            }else{
                                if(trim($url_esterno[\App::getLocale()]) != ""){
                                    $url = $url_esterno[\App::getLocale()];
                                }
                            }
                        }

                        if(!key_exists(\App::getLocale(), $title)){
                            $title[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $button)){
                            $button[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $description)){
                            $description[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $url_interno)){
                            $url_interno[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $url_esterno)){
                            $url_esterno[\App::getLocale()] = "";
                        }

                        // serve per le thumb /
                        $photo = $value->foto;

                        // serve per le thumb
                        if($photo){
                            $basename = basename($photo);
                            $temp = explode(".", $basename);

                            $check = "thumb/blocks_banners/$temp[0]-large.webp";
                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($photo);
                            }
                        }

                        ?>


                           <div class="col-lg-{{ $item->col }} mb-30px mt-30px">
                               <div class="interactive-banner-style-04 transition-inner-all">
                                   <figure class="m-0 hover-box position-relative overflow-hidden border-radius-6px">
                                       @if(trim($foto) != "")
                                           <img class="lg-w-100" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" title="{{ $title[\App::getLocale()] }}" />
                                       @endif
                                           <div class="overlay-bg bg-gradient-gray-light-dark-transparent opacity-full-dark"></div>
                                               <figcaption class="d-flex flex-column justify-content-end h-100 w-100 p-25px">

                                                   <div class="d-flex flex-column justify-content-center align-items-center last-paragraph-no-margin text-center features-content p-40px lg-p-50px md-p-25px">
                                                       @if(trim($title[\App::getLocale()]) != "" || trim($description[\App::getLocale()]) != "")

                                                           <div class="position-relative z-index-1">

                                                               @if(trim($button[\App::getLocale()])!="")
                                                                   @if(trim($button[\App::getLocale()])!="")
                                                                        <a href="{{ $url }}" target="{{ $type_href }}" class="d-block fw-600 text-dark-gray text-dark-gray-hover box-title fs-22 mb-5px">{{ $button[\App::getLocale()] }}</a>
                                                                   @endif

                                                                   @if(trim($description[\App::getLocale()]) != "")
                                                                       <p class="text-dark-gray opacity-6 fw-500">{!! $description[\App::getLocale()] !!}</p>
                                                                   @endif


                                                                   <a href="{{ $url }}" target="{{ $type_href }}" class="d-flex justify-content-center align-items-center w-60px h-60px rounded-circle bg-dark-gray mx-auto mt-20px"><i class="fa-solid fa-arrow-right text-white icon-small"></i></a>
                                                               @endif
                                                           </div>
                                                           <div class="box-overlay bg-white border-radius-6px"></div>

                                                   </div>

                                                   @if(trim($title[\App::getLocale()]) != "")
                                                       <div class="fs-26 fw-500 text-center text-white box-button p-15px border-radius-2px d-inline-block">{{ $title[\App::getLocale()] }}</div>
                                                   @endif

                                                      @endif

                                               </figcaption>
                                   </figure>
                               </div>
                           </div>


                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>
