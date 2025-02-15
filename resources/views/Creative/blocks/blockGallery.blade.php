<?php
    $website = \App\Models\WebsiteSetting::first();
?>

<section class="page-section-ptb">
    <div class="{{ $item->fullwidth }}">
        <div class="row mt-10">
            <div class="col-lg-12 col-md-12 ">
                <div class="section-title text-center">
                    <h2 class="mb-30">{{ $item->name }} </h2>
                </div>
                <div class="isotope columns-{{ $item->col }} popup-gallery">
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

                            if($title){
                                if(!key_exists(\App::getLocale(), $title)){
                                    $title[\App::getLocale()] = "";
                                }
                            }else{
                                $title[\App::getLocale()] = "";
                            }

                            if($description){
                                if(!key_exists(\App::getLocale(), $description)){
                                    $description[\App::getLocale()] = "";
                                }
                            }else{
                                $description[\App::getLocale()] = "";
                            }

                            // serve per le thumb
                            if($value->foto){
                                $basename = basename($value->foto);
                                $temp = explode(".", $basename);

                                if(key_exists(1,$temp)){
                                    $check = "thumb/blocks_galleries/$temp[0]-large.{$temp[1]}";
                                }else{
                                    $check = "thumb/blocks_galleries/$temp[0]-large";
                                }

                                if(file_exists($check)){
                                    $foto = url($check);
                                }else{
                                    $foto = url($value->foto);
                                }
                            }

                            ?>

                                <div class="grid-item">
                                    <div class="portfolio-item only-popup">
                                        @if(trim($foto) != "")
                                            <img loading="lazy" src="{{ $foto }}" alt="" width="400px" height="350px">
                                            <a class="popup portfolio-img" href="{{ $value->foto }}" style="background-color: {{ $website->btn_background }};"><i class="fa fa-plus"></i></a>
                                        @endif
                                    </div>
                                    <div class="feature-info">
                                        <h5 class="text-back">{{ $title[\App::getLocale()] }}</h5>
                                        <p>{!! $description[\App::getLocale()] !!} </p>
                                    </div>
                                </div>


                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
