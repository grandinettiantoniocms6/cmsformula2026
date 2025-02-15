<style>
    #block-news-{{ $item->id }} .post-date {
        color: {{ $item->date_color }};
        background-color: {{ $item->bgcolor }};
    }
</style>

<section class="block-news style-3" id="block-news-{{ $item->id }}">
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

                        // serve per le thumb
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
                        ?>

                    <div class="col-lg-{{ $item->col }} my-2">
                        <div class="card card-news wow animate__fadeInUp" data-wow-duration="1s" style="height: {{ $item->height }}rem;">
                            @if(trim($foto) != "")
                                @if($value->date)
                                    <div class="post-date">
                                        <span class="day">{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d") }}</span>
                                        <span class="month">
                                            {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("M") }}
                                        </span>
                                        <span class="year">{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("y") }}</span>
                                    </div>
                                @endif
                                <figure class="card-img-top overlay hover-scale">
                                    <a href="{{ $news_url }}">
                                        <img class="img-fluid" src="{{ $foto }}" alt="{{ $title[\App::getLocale()] }}" style="height:auto; object-fit:cover; width: 100%" loading="lazy">
                                        <span class="bg"></span>
                                    </a>
                                </figure>
                            @endif

                            <div class="card-body">
                                <div class="post-header">
                                    <div class="post-category text-line">
                                        @if(count($v_category))
                                            @foreach($v_category as $t)
                                                    <?php $url = route('news.category', trim($t)); ?>
                                                <a class="category" href="{{ $url }}" style="color: {{ $item->title_cat_color }}!important;">{{ $t }}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <h3 class="post-title"><a style="color: {{ $item->title_news_color }}!important;" href="{{ $news_url }}">{{ $title[\App::getLocale()] }}</a></h3>
                                </div>
                                <div class="post-content">{{ $abstract[\App::getLocale()] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
