<section class="block-news style-1" id="block-news-{{ $item->id }}">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            @if($array)
                @foreach($array as $value)
                        <?php

                        $title = json_decode($value->title, true);
                        if($title === null){
                            $title = [];
                        }

                        $abstract = json_decode($value->abstract, true);
                        if($abstract === null){
                            $abstract = [];
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

                        $slug = json_decode($value->slug, true);
                        if($slug === null){
                            $slug = [];
                        }

                        if(!key_exists(\App::getLocale(), $abstract)){
                            $abstract[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $title)){
                            $title[\App::getLocale()] = "";
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

                        $url = "#";
                        if(trim($url_interno[\App::getLocale()]) != ""){
                            $url = "/{$url_interno[\App::getLocale()]}";
                        }else{
                            if(trim($url_esterno[\App::getLocale()]) != ""){
                                $url = $url_esterno[\App::getLocale()];
                            }
                        }

                        $category = json_decode($value->category, true);
                        if($category === null){
                            $category = [];
                        }

                        $tag = json_decode($value->tag, true);
                        if($tag === null){
                            $tag = [];
                        }

                        if(!key_exists(\App::getLocale(), $category)){
                            $category[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $tag)){
                            $tag[\App::getLocale()] = "";
                        }

                        if(!key_exists(\App::getLocale(), $slug)){
                            $slug[\App::getLocale()] = "";
                        }

                        $v_category = explode(",", $category[\App::getLocale()]);
                        $v_tag = explode(",", $tag[\App::getLocale()]);

                        if($v_category){
                            foreach ($v_category as $k=>$c){
                                if(trim($c) == ""){
                                    unset($v_category[$k]);
                                }
                            }
                        }

                        if($v_tag){
                            foreach ($v_tag as $k=>$c){
                                if(trim($c) == ""){
                                    unset($v_tag[$k]);
                                }
                            }
                        }


                        $news_id = $value->id;
                        $news_url = route('news.slug', $slug[\App::getLocale()]);
                        $news_url_category = route('news.category', $category[\App::getLocale()]);

                        // serve per le thumb foto 1
                        $foto = "";
                        if($value->foto){
                            $basename = basename($value->foto);
                            $temp = explode(".", $basename);

                            if(key_exists(1,$temp)){
                                $check = "thumb/blocks_news/$temp[0]-large.webp";
                            }else{
                                $check = "thumb/blocks_news/$temp[0]-large";
                            }

                            if(file_exists($check)){
                                $foto = url($check);
                            }else{
                                $foto = url($value->foto);
                            }
                        }



                        // serve per le thumb foto 2
                        $foto2 = "";
                        if($value->foto2){
                            $basename = basename($value->foto2);
                            $temp = explode(".", $basename);

                            if(key_exists(1,$temp)){
                                $check = "thumb/blocks_news/$temp[0]-large.webp";
                            }else{
                                $check = "thumb/blocks_news/$temp[0]-large";
                            }

                            if(file_exists($check)){
                                $foto2 = url($check);
                            }else{
                                $foto2 = url($value->foto2);
                            }
                        }
                        ?>


                    <div class="col-lg-{{ $item->col }} my-2">
                        <div class="card card-news wow animate__fadeInUp" data-wow-duration="1s" style="height: {{ $item->height }}rem;">
                            @if(trim($foto) != "")
                                <figure class="card-img-top overlay hover-scale">
                                    <a href="{{ $news_url }}">
                                        <img class="img-fluid" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" style="height:auto; object-fit:cover; width: 100%" loading="lazy">
                                        <span class="bg"></span>
                                    </a>
                                    <figcaption>
                                        <h5 class="from-top">Leggi tutto</h5>
                                    </figcaption>
                                </figure>
                            @endif

                            <div class="card-body">
                                <div class="post-header">
                                    <div class="post-category text-line">
                                        @if(count($v_category))
                                            @foreach($v_category as $t)
                                                    <?php $url = route('news.category', trim($t)); ?>
                                                <a style="color: {{ $item->title_cat_color }}!important;" class="category" href="{{ $url }}">{{ $t }}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <h3 class="post-title"><a style="color: {{ $item->title_news_color }}!important;" href="{{ $news_url }}">{{ $title[\App::getLocale()] }}</a></h3>
                                    <ul class="post-meta">
                                        @if($value->date)
                                            <li class="post-date"><i class="bi bi-calendar"></i><span>{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d/m/Y") }}</span></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="post-content">

                                    {{ $abstract[\App::getLocale()] }}

                                    @if(trim($foto2) != "")
                                        <img class="img-fluid" src="{{ $foto2 }}" style="height:auto; object-fit:cover; width: 100%" loading="lazy">
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
