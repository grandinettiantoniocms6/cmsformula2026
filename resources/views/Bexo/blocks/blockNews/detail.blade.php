<!-- SE ENTRO QUI SIAMO NEL DETTAGLIO NEWS -->

<?php

$website = \App\Models\WebsiteSetting::first();
$padre = \App\Models\BlockNews::where("id", $blockNews->block_id)->first();
$title = $blockNews->title;
$description = $blockNews->description;
$slug =$blockNews->slug;
$col = "";

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
        $foto2 = url($blockNews->foto2);
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
        $foto3 = url($blockNews->foto3);
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
        $foto4 = url($blockNews->foto4);
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
        $foto5 = url($blockNews->foto5);
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
        $foto6 = url($blockNews->foto6);
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

<section class="tj-blog-section section-gap slidebar-stickiy-container">
    <div class="container">
        <div class="row row-gap-5">
            <div class="col-lg-8">

                <div class="post-details-wrapper">
                    <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
                        @if($blockNews->foto)
                            <img src="{{ $foto }}" alt="Immagine news" class="border-radius-5px">
                        @endif
                    </div>
                    <h2 class="title title-anim">{{ $title }}</h2>
                    <div class="blog-category-two wow fadeInUp" data-wow-delay=".3s">

                        <div class="category-item">
                            <div class="cate-icons">
                                <i class="tji-calendar"></i>
                            </div>
                            <div class="cate-text">
                                <span class="degination">Date Released</span>
                                <h6 class="text">29 December, 2025</h6>
                            </div>
                        </div>

                    </div>
                    <div class="blog-text">
                        <p class="wow fadeInUp" data-wow-delay=".3s">{!! $description !!}</p>
                    </div>

                    <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
                        @if($blockNews->foto2)
                            <img src="{{ $foto2 }}" alt="Immagine 2 news" class="border-radius-5px">
                        @endif
                    </div>

                    <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
                        @if($blockNews->foto3)
                            <img src="{{ $foto3 }}" alt="Immagine news" class="border-radius-5px">
                        @endif
                    </div>

                    <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
                        @if($blockNews->foto4)
                            <img src="{{ $foto4 }}" alt="Immagine 3 news" class="border-radius-5px">
                        @endif
                    </div>

                    <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
                        @if($blockNews->foto5)
                            <img src="{{ $foto5 }}" alt="Immagine 4 news" class="border-radius-5px">
                        @endif
                    </div>

                    <div class="blog-images wow fadeInUp" data-wow-delay=".1s">
                        @if($blockNews->foto6)
                            <img src="{{ $foto6 }}" alt="Immagine 5 news" class="border-radius-5px">
                        @endif
                    </div>


                    <div class="tj-comments-container">
                        <div class="tj-comments__container">
                            <div class="comment-respond">
                                <div class="row">
                                    <div class="comments-btn">
                                        <a class="tj-primary-btn" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }}; color: {{ $website->btn_txt_color }};" href="/news">
                                            <span class="btn-text"><span>{{ $labelSite['back-to-news'] }}</span></span>
                                            <span class="btn-icon"><i class="tji-arrow-right-long"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

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

                    ->take(5) // è il numero di quante ultime news voglio far vedere
                    ->get();
            }

            ?>

            <div class="col-lg-4">
                <div class="tj-main-sidebar slidebar-stickiy">
                    <div class="tj-sidebar-widget tj-recent-posts wow fadeInUp" data-wow-delay=".3s">

                        <h4 class="widget-title">{{ $labelSite['last-news'] }}</h4>

                        @if($altre_news)
                            @foreach($altre_news as $altre)
                                    <?php
                                    $news_url = route('news.slug', $altre->slug);
                                    ?>
                                        <ul>
                                            <li>
                                                <div class="post-content">
                                                    <h6 class="post-title">
                                                        <a href="{{ $news_url }}">{{ $altre->title }}</a>
                                                    </h6>
                                                    <div class="blog-meta">
                                                        <ul>
                                                            <li>{{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$altre->date)->format("d/m/Y") }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><br>

                                        </ul>

                            @endforeach
                        @endif
                    </div>

                    <div class="tj-sidebar-widget widget-categories wow fadeInUp" data-wow-delay=".5s">
                        <h4 class="widget-title">Categories</h4>
                        @if(count($v_category))
                            <ul>

                                @foreach($v_category as $t)
                                        <?php
                                        $news_url_tag = route('news.category', $t);
                                        ?>
                                    <li><a href="{{ $news_url_tag }}">{{ $t }}</a></li>

                                @endforeach
                        @endif

                            </ul>
                    </div>

                    <!-- Tags -->
                    <div class="tj-sidebar-widget widget-tag-cloud wow fadeInUp" data-wow-delay=".7s">
                        <h4 class="widget-title">Tags</h4>
                        @foreach($v_tag as $t)
                                <?php
                                    $news_url_tag = route('news.tag', trim($t));
                                ?>
                        <nav>
                            <div class="tagcloud">
                                <a href="{{ $news_url_tag }}">{{ $t }}</a>
                        @endforeach

                            </div>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
