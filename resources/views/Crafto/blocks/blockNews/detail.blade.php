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

<!-- ++++++++ Dettaglio News -->
<section class="p-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 overlap-section text-center">
                <div class="p-10 box-shadow-extra-large border-radius-4px bg-white text-center">

                    @if(count($v_category))
                        @foreach($v_category as $t)
                                <?php
                                $news_url_tag = route('news.category', $t);
                                ?>
                            <a class="bg-solitude-blue text-uppercase fs-13 ps-25px pe-25px alt-font fw-500 text-base-color lh-40 sm-lh-55 border-radius-100px d-inline-block mb-3 sm-mb-15px" href="{{ $news_url_tag }}">{{ $t }}</a>
                        @endforeach
                    @endif

                    <h3 class="alt-font text-dark-gray fw-600 ls-minus-1px mb-15px">{{ $title }}</h3><br><br>
                    <h5><i class="fas fa-tags"></i></h5>
                    @foreach($v_tag as $t)
                            <?php
                            $news_url_tag = route('news.tag', trim($t));
                            ?>
                        <a class="bg-solitude-blue text-uppercase fs-13 ps-25px pe-25px alt-font fw-500 text-base-color lh-40 sm-lh-55 border-radius-100px d-inline-block mb-3 sm-mb-15px" href="{{ $news_url_tag }}">{{ $t }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


<!-- start section -->
<section class="half-section pb-0">
    <div class="container">
        <div class="row justify-content-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
            <div class="col-lg-10 mb-6 sm-mb-35px last-paragraph-no-margin text-center">

                <!-- commendo per non far vedere la foto 1 nel dettaglio news -->
                @if($blockNews->foto)
                    <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                        <img src="{{ $foto }}" alt="" class="border-radius-5px">
                    </div>
                @endif

                @if($blockNews->foto2)
                    <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                        <img src="{{ $foto2 }}" alt="" class="border-radius-5px">
                    </div>
                @endif

                @if($blockNews->foto3)
                    <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                        <img src="{{ $foto3 }}" alt="" class="border-radius-5px">
                    </div>
                @endif

                @if($blockNews->foto4)
                    <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                        <img src="{{ $foto4 }}" alt="" class="border-radius-5px">
                    </div>
                @endif

                @if($blockNews->foto5)
                    <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                        <img src="{{ $foto5 }}" alt="" class="border-radius-5px">
                    </div>
                @endif

                @if($blockNews->foto6)
                    <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin text-center">
                        <img src="{{ $foto6 }}" alt="" class="border-radius-5px">
                    </div>
                @endif

                <div class="col-lg-12 mb-6 sm-mb-35px last-paragraph-no-margin">
                    <p>{!! $description !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- +++++end section dettaglio news-->

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
        // il numero nella riga seguente (5) è il numero delle ultime news in dettaglio news
        ->take(4)
        ->get();
}

?>

    <!-- start section altre News -->
<section class="bg-solitude-blue position-relative sm-pb-20px">
    <div class="container">
        <div class="row justify-content-center mb-1">
            <div class="col-lg-7 text-center">
                <h3 class="alt-font text-dark-gray fw-600 ls-minus-1px" data-anime='{ "el": "lines", "translateY": [30, 0], "opacity": [0,1], "delay": 500, "staggervalue": 100, "easing": "easeOutQuad" }'>{{ $labelSite['last-news'] }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-0">
                @if($altre_news)
                    <ul class="blog-classic blog-wrapper grid grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-double-extra-large" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <li style="list-style: none!important;" class="grid-sizer"></li>
                        @foreach($altre_news as $altre)
                                <?php
                                $news_url = route('news.slug', $altre->slug);
                                ?>
                            <li class="grid-item">
                                <div class="card bg-transparent border-0 h-100">
                                    <!-- commento in quanto mette sempre la foto della 1° news
                                                                                        <div class="blog-image position-relative overflow-hidden border-radius-4px">
                                                                                            @if($blockNews->foto)
                                        <a href="{{ $news_url }}"><img src="/{{ $blockNews->foto }}" alt="" /></a>
                                                                                            @endif
                                    </div>
                                    -->

                                    <div class="card-body px-0 pb-30px pt-30px xs-pb-15px last-paragraph-no-margin">
                                        <a href="{{ $news_url }}" class="card-title mb-0 fw-500 fs-18 lh-30 text-dark-gray d-inline-block">{{ $altre->title }}</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <!-- end blog item -->
                        @endif

                    </ul>
            </div>
        </div>

        <!-- TORNA ALLE NEWS -->
        <div class="row">
            <div class="col-12">
                <a class="btn btn-small btn-round-edge" style="background-color: {{ $website->btn_background }}; border-color: {{ $website->btn_colorborder }}; color: {{ $website->btn_txt_color }};" href="/news">{{ $labelSite['back-to-news'] }}</a>
            </div>
        </div>

    </div>
</section>
<!-- End altre news - Related News dettaglio -->
