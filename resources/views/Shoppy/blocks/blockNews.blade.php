<section class="blog white-bg page-section-ptb">
    <div class="container">
        <div class="row">

            @if($array)
                @foreach($array as $value)

                    <?php
                    $title = json_decode($value->title, true);
                    $abstract = json_decode($value->abstract, true);
                    $description = json_decode($value->description, true);
                    $url_interno = json_decode($value->url_interno, true);
                    $url_esterno = json_decode($value->url, true);
                    $button = json_decode($value->button, true);
                    $slug = json_decode($value->slug, true);

                    if(!key_exists(\App::getLocale(), $abstract)){
                        $abstract[\App::getLocale()] = "";
                    }

                    if(!key_exists(\App::getLocale(), $title)){
                        $title[\App::getLocale()] = "";
                    }

                    if(!key_exists(\App::getLocale(), $description)){
                        $description[\App::getLocale()] = "";
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
                    $tag = json_decode($value->tag, true);

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

                    $padre = \App\Models\BlockNews::where("id", $value->block_id)->first();

                    $news_id = $value->id;
                    $news_url = route('news.slug', $slug[\App::getLocale()]);
                    $news_url_category = route('news.category', $category[\App::getLocale()]);
                    ?>


                    <!-- CICLO NEWS -->

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="blog-entry mb-50">
                                <div class="entry-image clearfix">
                                    @if($value->foto)
                                        <a href="{{ $news_url }}">
                                            <img class="img-fluid" src="{{ $value->foto }}" alt="">
                                        </a>
                                    @endif

                                </div>
                                <div class="blog-detail">
                                    <div class="entry-title mb-10">
                                        <a href="{{ $news_url }}">{{ $title[\App::getLocale()] }}</a>
                                    </div>
                                    <div class="entry-meta mb-10">
                                        <ul>
                                            @if(count($v_category))
                                                <li> <i class="fa fa-folder-open-o"></i>
                                                    @foreach($v_category as $t)
                                                        <?php
                                                        $url = route('news.category', trim($t));
                                                        ?>
                                                        <a href="{{ $url }}">{{ $t }}</a>
                                                    @endforeach
                                                </li>
                                            @endif
                                            <li>@if($value->date)
                                                    <i class="fa fa-calendar-o"></i>{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d/m/Y") }}
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="entry-content">
                                        <p>{{ $abstract[\App::getLocale()] }} </p>
                                    </div>
                                    <div class="entry-share clearfix">
                                        <div class="entry-button">
                                            <a class="button arrow" href="{{ $news_url }}">Leggi<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    <!-- / CICLO NEWS -->

                @endforeach
            @endif

            @if(count($array) > $padre->number_news)
                <nav>
                    <a class="page-link" href="{{ route('news') }}">Vedi altre news</a>
                </nav>
            @endif
        </div>
    </div>
</section>
