<?php
   $fullwidth = null;
?>

@if($blockNews)
    <?php
    $padre = \App\Models\BlockNews::where("id", $blockNews->block_id)->first();
    $title = $blockNews->title;
    $description = $blockNews->description;
    $slug =$blockNews->slug;

    $labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
    $category = $blockNews->category;
    $tag = $blockNews->tag;

    $news_id = $blockNews->id;

    $news_url = route('news.slug', $slug);
    $news_url_all = "".route('news')."?id=$padre->id";
    $news_url_category = "".route('news')."?id=$padre->id&category={$category}";

    $v_category = explode(",", $category);
    $v_tag = explode(",", $tag);

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

    if($blockNews->foto){
        $basename = basename($blockNews->foto);
        $temp = explode(".", $basename);

        if(key_exists(1,$temp)){
            $check = "thumb/blocks_news/$temp[0]-large.webp";
        }else{
            $check = "thumb/blocks_news/$temp[0]-large";
        }

        if(file_exists($check)){
            $foto = url($check);
        }else{
            $foto = url($blockNews->foto);
        }
    }
    ?>

    <!-- Dettaglio News -->
    <div class="blog-details-one mb-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 m-auto">
                    <div class="blog-meta-wrapper pe-xxl-5 ps-xxl-5">
                        <article class="blog-details-content">
                            <p><h4>{{ $title }}</h4></p>

                            @if(trim($foto) != "")
                                <img src="{{ $foto }}" alt="" class="image-meta w-100">
                            @endif

                            <p>{!! $description !!}</p>

                            <div class="bottom-widget d-sm-flex align-items-center justify-content-between">
                                <ul class="d-flex tags style-none pb-20">
                                    <li>Tag:</li>
                                    @foreach($v_tag as $t)
                                        <?php
                                        $news_url_tag = route('news.tag', trim($t));
                                        ?>
                                        <li><a href="{{ $news_url_tag }}">{{ $t }}</a>&nbsp;</li>
                                    @endforeach
                                </ul>
                                @if(count($v_category))
                                <ul class="d-flex align-items-center style-none pb-20 comment-text">
                                    <li><b>Categorie:</b>&nbsp;</li>
                                    @foreach($v_category as $t)
                                        <?php
                                        $news_url_tag = route('news.category', $t);
                                        ?>
                                        <li><a class="reply-btn" href="{{ $news_url_tag }}">{{ $t }}</a>&nbsp;</li>
                                    @endforeach
                                </ul>
                                @endif
                            </div> <!-- /.bottom-widget -->
                        </article>


                    </div>
                    <p><br /><a class="theme-btn-four ripple-btn" href="/news">{{ $labelSite['back-to-news'] }} <i class="fa fa-angle-right"></i></a></p>
                </div>
            </div>
        </div>
    </div>

@else

    <!-- Grid news -->
    <div class="blog-section-two mt-200 lg-mt-120">
        @if($news)
            @foreach($news as $value)
              <?php
                $contenitore = \App\Models\BlockNews::where("id", $value->block_id)->first();
                $col = $contenitore->col;
                $height = $contenitore->height;
                $fullwidth = $contenitore->fullwidth;
                break;
               ?>
            @endforeach
        @endif

        <div class="{{ $fullwidth }}">
            <div class="row">
                <div class="col-xxl-11 m-auto">
                    <div class="row gx-xl-5">
                        @if($news)

                            @foreach($news as $value)
                                <?php

                                $title = $value->title;
                                $abstract = $value->abstract;
                                $description = $value->description;
                                $slug = $value->slug;
                                $labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
                                $category = $value->category;
                                $tag = $value->tag;
                                //$col = $item->col;
                                $v_category = explode(",", $category);
                                $v_tag = explode(",", $tag);

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
                                $news_url = route('news.slug', $slug);
                                $news_url_category = route('news.category', $category);

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


                                <!-- CICLO NEWS -->

                                <div class="col-md-{{ $col }}">
                                    <article class="blog-meta-four tran3s">
                                        @if(trim($foto) != "")
                                            <div class="img-meta position-relative">
                                                <a href="{{ $news_url }}">
                                                    <img class="tran3s" src="{{ $foto }}" style="height:{{ $height }}px; object-fit:cover; width: 100%;" alt="">

                                                        @if(count($v_category))
                                                            @foreach($v_category as $t)
                                                                <?php
                                                                $url = route('news.category', trim($t));
                                                                ?>
                                                                <a class="tag" href="{{ $url }}">{{ $t }}</a>
                                                            @endforeach
                                                        @endif
                                                </a>

                                            </div>
                                        @endif

                                            @if($value->date)
                                                <div class="post-info">
                                                    <b>Scritta il:</b><span> {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d/m/Y") }} </span></div>
                                            @endif

                                            <h4><a href="{{ $news_url }}" class="title">{{ $title }}</a></h4>
                                            <p><a href="{{ $news_url }}">{{ $abstract }}</a></p>
                                            <a href="{{ $news_url }}" class="theme-btn-three">{{ $labelSite['read-news'] }} <i class="fas fa-angle-right"></i></a>

                                    </article> <!-- /.blog-meta-two -->
                                </div>



                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <!-- Paginazione -->
            <div class="row mt-80 mb-120">
            <div class="page-pagination-one pt-30">
                <ul class="d-flex align-items-center justify-content-center style-none">
                    {{ $news->links() }}
                </ul>
            </div>
            </div>


           </div>
        </div>
    <!-- / Grid News -->

@endif
