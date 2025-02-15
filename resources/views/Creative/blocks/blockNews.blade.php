<?php
$fullwidth = null;
?>


<div class="blog-section-two mt-200 lg-mt-120">
    <div class="container">
        <div class="row align-items-center mb-70 md-mb-20">
            <div class="col-sm-6">
                <div class="title-style-five">
                    <div class="upper-title">In evidenza</div>
                    <h2 class="title">Ultime News/Promo.</h2>
                </div>
            </div>
            <div class="col-sm-6 d-sm-flex justify-content-end">
                <a href="/news" class="theme-btn-four ripple-btn">Tutte le News</a>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-11 m-auto">
                <div class="row gx-xl-5">

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


                                <div class="col-lg-4 col-md-6 md-mt-40">
                                    <article class="blog-meta-three">
                                        @if(count($v_category))
                                            @foreach($v_category as $t)
                                                <?php
                                                $url = route('news.category', trim($t));
                                                ?>
                                                <a href="{{ $url }}" class="tag">{{ $t }}</a>
                                            @endforeach
                                        @endif
                                        <a href="{{ $news_url }}" class="title">{{ $title[\App::getLocale()] }}</a>

                                        @if($value->date)
                                            <div class="post-info">Scritta il: <span class="date">{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d/m/Y") }}</span></div>
                                        @endif
                                        <div class="post-footer d-flex align-items-center justify-content-between">

                                            <a href="{{ $news_url }}" class="read-more tran3s">
                                                <!-- nascondo la foto nella home per adesso
                                                 @if(trim($foto) != "")
                                                    <img src="{{ $foto }}" alt="News foto">
                                                @endif
                                                -->
                                                <img src="templates/Creative/images/icon/icon_16.svg" alt="">
                                            </a>
                                        </div> <!-- /.post-footer -->
                                    </article>
                                </div>

                        @endforeach
                    @endif


                </div>
            </div>
        </div>



    </div>
</div>


