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

<!-- Dettaglio news -->
<div class="blog-single py-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="blog-single-wrap">
                    <div class="blog-single-content">

                        <div class="blog-info">

                            <div class="blog-details">
                                <h3 class="blog-details-title mb-20">{{ $title }}</h3>
                                    <p class="mb-10">
                                        {!! $description !!}
                                    </p>
                                <hr>
                            </div>

                        </div>

                        <div class="blog-thumb-img">
                            <!-- commendo per non far vedere la foto 1 nel dettaglio news -->
                            @if($blockNews->foto)
                                <img src="{{ $foto }}" alt="" class="border-radius-5px">
                            @endif
                        </div>

                        <div class="blog-thumb-img">
                            @if($blockNews->foto2)
                                <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                                    <img src="{{ $foto2 }}" alt="" class="border-radius-5px">
                                </div>
                            @endif
                        </div>

                        <div class="blog-thumb-img">
                            @if($blockNews->foto3)
                                <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                                    <img src="{{ $foto3 }}" alt="" class="border-radius-5px">
                                </div>
                            @endif
                        </div>

                        <div class="blog-thumb-img">
                            @if($blockNews->foto4)
                                <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                                    <img src="{{ $foto4 }}" alt="" class="border-radius-5px">
                                </div>
                            @endif
                        </div>

                        <div class="blog-thumb-img">
                            @if($blockNews->foto5)
                                <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                                    <img src="{{ $foto5 }}" alt="" class="border-radius-5px">
                                </div>
                            @endif
                        </div>

                        <div class="blog-thumb-img">
                            @if($blockNews->foto6)
                                <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                                    <img src="{{ $foto6 }}" alt="" class="border-radius-5px">
                                </div>
                            @endif

                        </div>

                        <!-- Torna indietro -->
                        <div class="blog-author">
                            <a class="theme-btn" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }}; color: {{ $website->btn_txt_color }};" href="/news">{{ $labelSite['back-to-news'] }}<i class="fas fa-arrow-right"></i></a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <aside class="blog-sidebar">

                    <!-- Categorie -->
                    @if(count($v_category))
                        <div class="widget tag">
                            <h5 class="widget-title"><i class="fas fa-folder"></i> Categoria</h5>
                            <div class="tag-list">
                                @foreach($v_category as $t)
                                        <?php
                                        $news_url_tag = route('news.category', $t);
                                        ?>
                                       <a href="{{ $news_url_tag }}">{{ $t }}</a>
                                @endforeach
                    @endif

                            </div>
                        </div>


                    <!-- Tags -->
                    <div class="widget tag">
                        <h5 class="widget-title"><i class="fas fa-tags"></i> Tags</h5>
                        <div class="tag-list">

                            @foreach($v_tag as $t)
                                    <?php
                                    $news_url_tag = route('news.tag', trim($t));
                                    ?>
                                <a href="{{ $news_url_tag }}">{{ $t }}</a>
                            @endforeach

                        </div>
                    </div>

                        <!-- Altre news - Related News dettaglio -->

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


                            <!-- Altre News -->
                            <div class="widget category">
                                <h5 class="widget-title"><i class="fas fa-clock"></i> {{ $labelSite['last-news'] }}</h5>

                                @if($altre_news)
                                    @foreach($altre_news as $altre)
                                        <?php
                                            $news_url = route('news.slug', $altre->slug);
                                        ?>

                                            <div class="category-list">
                                                <a href="{{ $news_url }}"><i class="far fa-arrow-right"></i>{{ $altre->title }}<br>
                                                    <i class="far fa-clock"></i> {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$altre->date)->format("d/m/Y") }}
                                                </a>

                                            </div>

                                    @endforeach
                                @endif

                            </div>


                </aside>
            </div>
        </div>
    </div>
</div>
<!-- fine -->

