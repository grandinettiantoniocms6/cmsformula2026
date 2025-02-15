<?php
$website = \App\Models\WebsiteSetting::first();
$labelSite = \App\Models\Label::get()->pluck("value", "key")->toArray();

$titleBlocco = json_decode($item->title, true);
if($titleBlocco){
    if(!key_exists(\App::getLocale(), $titleBlocco)){
        $titleBlocco[\App::getLocale()] = "";
    }
}else{
    $titleBlocco[\App::getLocale()] = "";
}

$descriptionBlocco = json_decode($item->description, true);
if($descriptionBlocco){
    if(!key_exists(\App::getLocale(), $descriptionBlocco)){
        $descriptionBlocco[\App::getLocale()] = "";
    }
}else{
    $descriptionBlocco[\App::getLocale()] = "";
}

?>

<section class="pt-5">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-xl-9 col-lg-8 text-center position-relative page-title-double-large">
                @if($titleBlocco[\App::getLocale()] != "" || $descriptionBlocco[\App::getLocale()] != "")
                    <div class="d-flex flex-column justify-content-center extra-very-small-screen">
                        <h1 class="text-dark-gray alt-font ls-minus-1px fw-700">{{ $titleBlocco[\App::getLocale()] }}</h1>
                        <h2 class="text-dark-gray d-inline-block fw-400 ls-0px w-80 xs-w-100 mx-auto">{!! $descriptionBlocco[\App::getLocale()] !!}</h2>
                    </div>
            </div>
            @endif
        </div>
    </div>
</section>

<section class="block-news style-2 pt-0 ps-4 pe-4 xl-ps-2 xl-pe-2 lg-px-0 pt-0 pb-5" id="block-news-{{ $item->id }}">
    <div class="{{ $item->fullwidth }}">
        <div class="row">
            <div class="col-12">
                <ul class="blog-side-image blog-wrapper grid-loading grid grid-{{ $item->col }}col xxl-grid-2col xl-grid-2col lg-grid-2col md-grid-1col sm-grid-1col xs-grid-1col gutter-extra-large">
                    <li class="grid-sizer"></li>
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


                                <!-- start blog item -->
                            <li class="grid-item">
                                <div class="blog-box d-md-flex d-block flex-row h-100 border-radius-6px overflow-hidden box-shadow-extra-large">
                                    @if(trim($foto) != "")
                                        <div class="blog-image w-50 sm-w-100 cover-background" style="background-image: url('{{ $foto }}')">
                                            @if($url != "#")
                                                <a href="{{ $url }}" target="{{ $type_href }}" class="blog-post-image-overlay"></a>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="blog-content w-50 sm-w-100 pt-50px pb-40px ps-40px pe-40px xl-p-30px bg-white d-flex flex-column justify-content-center align-items-start last-paragraph-no-margin">
                                        @if(count($v_category))
                                            @foreach($v_category as $t)
                                                    <?php $url = route('news.category', trim($t)); ?>
                                                <a class="category categories-btn bg-dark-gray text-white text-uppercase fw-500 mb-30px" href="{{ $url }}">{{ $t }}</a>
                                            @endforeach
                                        @endif

                                        <a href="{{ $news_url }}" class="card-title text-dark-gray text-dark-gray-hover mb-5px fw-600 fs-18 lh-28">{{ $title[\App::getLocale()] }}</a>
                                        <p>{{ $abstract[\App::getLocale()] }}</p>

                                        @if($value->date)
                                            <div class="mt-15px"><span class="separator bg-dark-gray"></span>
                                                {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("d") }}
                                                <!-- Nuovo metodo per il print dei mesi in ita -->
                                                    <?php
                                                    $month = \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("m");
                                                    $month_view = config("cmsformula.months")[$month];
                                                    ?>
                                                <a href="{{ $news_url }}" class="text-dark-gray text-dark-gray-hover d-inline-block fs-15 fw-500 fw-500">{{ $month_view }}</a>

                                                {{ \Carbon\Carbon::createFromFormat("Y-m-d" ,$value->date)->format("Y") }}
                                                <!-- / Date -->
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <!-- end blog item -->


                @endforeach
                @endif


            </div>

        </div>
    </div>
</section>
