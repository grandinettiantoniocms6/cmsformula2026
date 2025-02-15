<?php
    $website = \App\Models\WebsiteSetting::first();
    $fullwidth = null;
    $labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();
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

    $news_url_all = "".route('news')."";
    $news_url_category = "".route('news')."?category={$category}";
    if($padre){
        $news_url_all = "".route('news')."?id=$padre->id";
        $news_url_category = "".route('news')."?id=$padre->id&category={$category}";
    }

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

    $foto = "";
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

    // foto aggiuntive

    $foto2 = "";
        if($blockNews->foto2){
            $basename = basename($blockNews->foto2);
            $temp = explode(".", $basename);

            if(key_exists(1,$temp)){
                $check = "thumb/blocks_news/$temp[0]-large.webp";
            }else{
                $check = "thumb/blocks_news/$temp[0]-large";
            }

            if(file_exists($check)){
                $foto2 = url($check);
            }else{
                $foto2 = url($blockNews->foto);
            }
        }

    $foto3 = "";
        if($blockNews->foto3){
            $basename = basename($blockNews->foto3);
            $temp = explode(".", $basename);

            if(key_exists(1,$temp)){
                $check = "thumb/blocks_news/$temp[0]-large.webp";
            }else{
                $check = "thumb/blocks_news/$temp[0]-large";
            }

            if(file_exists($check)){
                $foto3 = url($check);
            }else{
                $foto3 = url($blockNews->foto);
            }
        }

    $foto4 = "";
        if($blockNews->foto4){
            $basename = basename($blockNews->foto4);
            $temp = explode(".", $basename);

            if(key_exists(1,$temp)){
                $check = "thumb/blocks_news/$temp[0]-large.webp";
            }else{
                $check = "thumb/blocks_news/$temp[0]-large";
            }

            if(file_exists($check)){
                $foto4 = url($check);
            }else{
                $foto4 = url($blockNews->foto);
            }
        }

    $foto5 = "";
        if($blockNews->foto5){
            $basename = basename($blockNews->foto5);
            $temp = explode(".", $basename);

            if(key_exists(1,$temp)){
                $check = "thumb/blocks_news/$temp[0]-large.webp";
            }else{
                $check = "thumb/blocks_news/$temp[0]-large";
            }

            if(file_exists($check)){
                $foto5 = url($check);
            }else{
                $foto5 = url($blockNews->foto);
            }
        }

    $foto6 = "";
        if($blockNews->foto6){
            $basename = basename($blockNews->foto6);
            $temp = explode(".", $basename);

            if(key_exists(1,$temp)){
                $check = "thumb/blocks_news/$temp[0]-large.webp";
            }else{
                $check = "thumb/blocks_news/$temp[0]-large";
            }

            if(file_exists($check)){
                $foto6 = url($check);
            }else{
                $foto6 = url($blockNews->foto);
            }
        }


    ?>

    @section('meta')
        <title>@if($blockNews && trim($blockNews->meta_title != "")) {{ $website->title }} - {{ $blockNews->meta_title }} @else {{ $blockNews->title }} @endif</title>
        <meta property="og:title" content="@if($blockNews && trim($blockNews->meta_title != "")) {{ $website->title }} - {{ $blockNews->meta_title }} @else {{ $blockNews->title }} @endif" />
        <meta property="og:url" content="{{ env('APP_URL') }}<?php echo $_SERVER['REQUEST_URI'];?>" />

        @if($blockNews && (trim($blockNews->meta_description) != ""))
            <meta name="description" content="{{ $blockNews->meta_description }}">
            <meta property="og:description" content="{{ $blockNews->meta_description }}" />
        @else
            <meta name="description" content="{{ $website->meta_description }}">
            <meta property="og:description" content="{{ $website->meta_description }}" />
        @endif
        @if($blockNews && (trim($blockNews->meta_keywords) != ""))
            <meta name="keywords" content="{{ $blockNews->meta_keywords }}">
        @else
            <meta name="keywords" content="{{ $website->meta_keywords }}">
        @endif

        @if($website->favicon)
            <meta property="og:image" content="{{ url("$website->favicon") }}" />
        @endif

    @endsection

    {{-- Dettaglio News --}}
    <section class="news-single py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    @if(trim($foto) != "")
                        <figure class="mb-3">
                            <img class="img-fluid full-width" src="{{ $foto }}" alt="{{ $title }}">
                        </figure>
                    @endif

                    <article class="post">
                        <ul class="list-inline post-meta">
                            @if($blockNews->date)
                                <li class="post-date"><i class="fa-regular fa-calendar"></i> <span class="font-weight-600">{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$blockNews->date)->format("d/m/Y") }}</span></li>
                            @endif
                        </ul>
                        <h2 class="mb-3">{{ $title }}</h2>
                        {!! $description !!}

                        @if(trim($foto2) != "")
                            <figure class="mb-3">
                                <img class="img-fluid full-width" src="{{ $foto2 }}" alt="">
                            </figure>
                        @endif

                        @if(trim($foto3) != "")
                            <figure class="mb-3">
                                <img class="img-fluid full-width" src="{{ $foto3 }}" alt="">
                            </figure>
                        @endif

                        @if(trim($foto4) != "")
                            <figure class="mb-3">
                                <img class="img-fluid full-width" src="{{ $foto4 }}" alt="">
                            </figure>
                        @endif

                        @if(trim($foto5) != "")
                            <figure class="mb-3">
                                <img class="img-fluid full-width" src="{{ $foto5 }}" alt="">
                            </figure>
                        @endif

                        @if(trim($foto6) != "")
                            <figure class="mb-3">
                                <img class="img-fluid full-width" src="{{ $foto6 }}" alt="">
                            </figure>
                        @endif


                        <div class="card p-2">
                            <div class="row">
                                @if(count($v_category))
                                    <div class="col-auto">
                                        <ul class="list-inline cat-list mb-0">
                                            <li class="list-inline-item"><i class="fas fa-folder-open"></i></li>
                                            @foreach($v_category as $t)
                                                <?php
                                                $news_url_tag = route('news.category', $t);
                                                ?>
                                                <li class="list-inline-item"><a class="font-weight-600" href="{{ $news_url_tag }}">{{ $t }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if(count($v_tag))
                                    <div class="col-auto border-start">
                                        <ul class="list-inline tag-list mb-0">
                                            <li class="list-inline-item"><i class="fas fa-tags"></i></li>
                                            @foreach($v_tag as $t)
                                                <?php $news_url_tag = route('news.tag', trim($t)); ?>
                                                <li class="list-inline-item"><a class="font-weight-600" href="{{ $news_url_tag }}">{{ $t }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>

                    <a class="btn btn-primary my-3" href="/news">{{ $labelSite['back-to-news'] }} <i class="bi bi-chevron-right"></i></a>
                </div>

                <!-- Pannello LAST 4 NEWS -->
                <div class="col-lg-4">
                    <?php
                    $lang = \App::getLocale();
                    $page_temp = \App\Models\Page::whereRaw("slug LIKE '%\"$lang\":\"news\"%'")->first();

                    $altre_news  = null;
                    if($page_temp){
                        $pages_blocks = \App\Models\PageBlock::where("type", "blockNews")
                            //->where("is_active", 1)
                            ->where("page_id", $page_temp->id)->get()->pluck("obj_id")->toArray();

                        $now = \Carbon\Carbon::now()->toDateString();
                        $altre_news = \App\Models\BlockNews::whereIn("block_id", $pages_blocks)
                            ->whereRaw("(date_end is null OR date_end >= '$now')")
                            ->where("id", "!=", $blockNews->id)
                            ->orderBy("id", "DESC")
                            // a riga 128 il (5) è il numero delle ultime news in dettaglio news
                            ->take(5)
                            ->get();
                    }

                    ?>
                    @if($altre_news)
                    <div class="widget widget-news widget-collapsible">
                        <h3 class="widget-title">{{ $labelSite['last-news'] }} <i class="bi bi-chevron-down"></i></h3>
                        <div class="widget-body collapse show" id="widget-news">

                            <ul class="list-group list-group-flush">
                                @foreach($altre_news as $altre)
                                    <?php
                                     $news_url = route('news.slug', $altre->slug);
                                     ?>
                                     <li class="list-group-item"><a href="{{ $news_url }}">{{ $altre->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@else
    @section('meta')
        @include("$thema.inc.meta")
    @endsection

        <?php
        $style = 1;
        $date = null;
        $bg_color = "#000";
        $date_color = "#fff";
        $id_block = 0;
        $height = null;
        ?>
        @if($news)
            @foreach($news as $value)
                <?php
                $contenitore = \App\Models\BlockNews::where("id", $value->block_id)->first();
                $col = $contenitore->col;
                $height = $contenitore->height;
                $fullwidth = $contenitore->fullwidth;
                $style = $contenitore->style;
                $date = $contenitore->date;
                $bg_color = $contenitore->bgcolor;
                $date_color = $contenitore->date_color;
                $id_block = $contenitore->id;
                $height = $contenitore->height;

                $title_cat_color = $contenitore->title_cat_color;
                $title_news_color = $contenitore->title_news_color;

                if($style == null){
                    $style = 1;
                }
                break;
                ?>
            @endforeach
        @endif

    <section class="block-news style-{{ $style }}" id="block-news-{{ $id_block }}">
        <div class="{{ $fullwidth }}">
            @if($news)
                <div class="row">
                    @foreach($news as $value)
                        <?php
                        $title = $value->title;
                        $abstract = $value->abstract;
                        $description = $value->description;
                        $slug = $value->slug;
                        $labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();

                        $category = $value->category;
                        $tag = $value->tag;

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

                        <!--Elenco News -->

                        @if($id_block > 0)
                            <style>
                                #block-news-{{ $id_block }} .post-date {
                                    color: {{ $date_color }};
                                    background-color: {{ $bg_color }};
                                }
                            </style>
                        @endif

                        <div class="col-lg-{{ $col }} my-2">
                            <div class="card card-news wow animate__fadeInUp" data-wow-duration="1s" @if($height) style="height: {{ $height }}rem; @endif">
                                @if(trim($foto) != "")
                                    @if($value->date && ($style == 3) )
                                        <div class="post-date">
                                            <span class="day">{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d") }}</span>
                                            <span class="month">
                                                <?php
                                                   $month = \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("m");
                                                   $month_view = config("cmsformula.months")[$month];
                                                ?>
                                                {{ $month_view }}
                                            </span>
                                            <span class="year">{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("y") }}</span>
                                        </div>
                                    @endif

                                    @if($col != 12)
                                        <figure class="card-img-top overlay hover-scale">
                                            <a href="{{ $news_url }}">
                                                <img class="img-fluid" src="{{ $foto }}" alt="{{ $title }}" style="height:auto; object-fit:cover; width: 100%" loading="lazy">
                                                <span class="bg"></span>
                                            </a>
                                        </figure>
                                    @endif
                                @endif

                                <div class="card-body">
                                    <div class="post-header">
                                        <div class="post-category text-line">
                                            @if(count($v_category))
                                                @foreach($v_category as $t)
                                                    <?php $url = route('news.category', trim($t)); ?>
                                                    <a style="color: {{ $contenitore->title_cat_color }}!important;" class="category" href="{{ $url }}">{{ $t }}</a>
                                                @endforeach
                                            @endif
                                        </div>
                                        <h3 class="post-title"><a style="color: {{ $contenitore->title_news_color }}!important;" href="{{ $news_url }}">{{ $title }}</a></h3>

                                        @if( $value->date && ($style != 3) )
                                            <ul class="post-meta">
                                                <li class="post-date"><i class="fa-regular fa-calendar"></i> <span class="font-weight-600">{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d/m/Y") }}</span></li>
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="post-content">{{ $abstract }}</div>
                                </div>

                                <div class="card-footer">
                                    <a class="btn btn-primary" href="{{ $news_url }}"> {{ $labelSite['read-news'] }} <i class="bi bi-chevron-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row-pagination mt-5">
                    @if($news)
                        {{ $news->links() }}
                    @endif
                </div>
            @endif
        </div>
    </section>
@endif
