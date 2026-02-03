<?php
    $website = \App\Models\WebsiteSetting::first();
?>

<section class="block-htmlimage">
    <div class="container">
        @if($array)
            @foreach($array as $value)
                <?php
                $title = json_decode($value->title, true);
                if($title === null){
                    $title = [];
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

                $type_href = $value->type_href;

                if(!key_exists(\App::getLocale(), $description)){
                    $description[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $title)){
                    $title[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $button)){
                    $button[\App::getLocale()] = "";
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

                $alt_img = '';
                if($title[\App::getLocale()]){
                    $alt_img = strip_tags($title[\App::getLocale()]);
                }elseif ($description[\App::getLocale()]) {
                    $alt_img = strip_tags($description[\App::getLocale()]);
                }

                switch ($item->style) {
                    case 1: // Testo a sinistra ?>
                        <div class="row space-{{ $item->pb }} txt-sx">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="title" style="color:{{ $website->color_gen1 }}!important;">{{ $title[\App::getLocale()] }}</h3>
                                        <p class="description">{!! $description[\App::getLocale()] !!}</p>
                                        @if(trim($button[\App::getLocale()])!="")
                                            <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                                                <span>{{ $button[\App::getLocale()] }}</span>
                                            </a><p></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="carousel-block-{{ $value->id }}" class="owl-carousel owl-theme owl-block-carousel"
                                     data-toggle='owlcarousel'
                                     data-margin='[0,0,0,0,0,0,0]'
                                     data-autowidth='[false,false,false,false,false,false,false]'
                                     data-autoplay='[true,5000]'
                                     data-responsive='[1,1,1,1,1,1,1]'
                                     data-dots='[true,true,true,true,true,true,true]'
                                     data-nav='[false,false,false,false,false,false,false]'
                                     data-loop='true'
                                >
                                    <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width" loading="lazy">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto2;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width" loading="lazy">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto3;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width" loading="lazy">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto4;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto5;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto6;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto7;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto8;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto9;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto10;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <?php break;
                    case 2: // Immagini a sinistra ?>
                        <div class="row space-{{ $item->pb }} txt-dx">
                            <div class="col-lg-6 order-2 order-lg-1"><div id="carousel-block-{{ $value->id }}" class="owl-carousel owl-theme owl-block-carousel"
                                     data-toggle='owlcarousel'
                                     data-margin='[0,0,0,0,0,0,0]'
                                     data-autowidth='[false,false,false,false,false,false,false]'
                                     data-autoplay='[true,5000]'
                                     data-responsive='[1,1,1,1,1,1,1]'
                                     data-dots='[true,true,true,true,true,true,true]'
                                     data-nav='[false,false,false,false,false,false,false]'
                                >

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto2;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto3;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto4;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto5;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto6;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto7;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto8;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto9;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto10;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                </div></div>
                            <div class="col-lg-6 order-1 order-lg-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="title" style="color:{{ $website->color_gen1 }}!important;">{{ $title[\App::getLocale()] }}</h3>
                                        <p class="description">{!! $description[\App::getLocale()] !!}</p>
                                        @if(trim($button[\App::getLocale()])!="")
                                            <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                                                <span>{{ $button[\App::getLocale()] }}</span>
                                            </a><p></p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php break;

                        case 3: // Immagini in alto e titolo sotto ?>

                    <div class="row space-{{ $item->pb }}">
                        <div class="col-lg-8 mx-auto mb-4">
                            <div id="carousel-block-{{ $value->id }}" class="owl-carousel owl-theme owl-block-carousel owl-autoheight"
                                 data-autoheight="true"
                                 data-toggle='owlcarousel'
                                 data-margin='[0,0,0,0,0,0,0]'
                                 data-autowidth='[false,false,false,false,false,false,false]'
                                 data-autoplay='[true,5000]'
                                 data-responsive='[1,1,1,1,1,1,1]'
                                 data-dots='[true,true,true,true,true,true,true]'
                                 data-nav='[false,false,false,false,false,false,false]'
                            >
                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto2;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto3;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto4;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto5;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto6;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto7;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto8;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto9;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                                    <?php
                                    // serve per le thumb
                                    $foto = "";
                                    $photo = $value->foto10;
                                    if($photo){
                                        $basename = basename($photo);
                                        $temp = explode(".", $basename);

                                        $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                        if(file_exists($check)){
                                            $foto = url($check);
                                        }else{
                                            $foto = url($photo);
                                        }
                                    }
                                    // fine thumb
                                    ?>
                                @if(trim($foto) != "")
                                    <div class="item">
                                        <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card" style="text-align: center;">
                                <div class="card-body">
                                    <h3 class="title" style="color:{{ $website->color_gen1 }}!important;">{{ $title[\App::getLocale()] }}</h3>
                                    <p class="description">{!! $description[\App::getLocale()] !!}</p>
                                    @if(trim($button[\App::getLocale()])!="")
                                        <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                                            <span>{{ $button[\App::getLocale()] }}</span>
                                        </a><p></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                  <?php break;

                    case 4: // Testo alto e Immagini in basso ?>
                        <div class="row space-{{ $item->pb }}">

                            <!-- Testo in alto -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="text-align: center;">
                                        <h3 class="title" style="text-align: center; color:{{ $website->color_gen1 }}!important;">{{ $title[\App::getLocale()] }}</h3>
                                        <p class="description">{!! $description[\App::getLocale()] !!}</p>
                                        @if(trim($button[\App::getLocale()])!="")
                                            <a target="{{ $type_href }}" class="btn btn-primary" href="{{ $url }}">
                                                <span>{{ $button[\App::getLocale()] }}</span>
                                            </a><p></p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Immagini in basso -->
                            <div class="col-lg-8 mx-auto mb-4">
                                <div id="carousel-block-{{ $value->id }}" class="owl-carousel owl-theme owl-block-carousel owl-autoheight"
                                     data-autoheight="true"
                                     data-toggle='owlcarousel'
                                     data-margin='[0,0,0,0,0,0,0]'
                                     data-autowidth='[false,false,false,false,false,false,false]'
                                     data-autoplay='[true,5000]'
                                     data-responsive='[1,1,1,1,1,1,1]'
                                     data-dots='[true,true,true,true,true,true,true]'
                                     data-nav='[false,false,false,false,false,false,false]'
                                >
                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto2;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto3;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto4;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto5;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto6;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto7;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto8;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto9;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                        <?php
                                        // serve per le thumb
                                        $foto = "";
                                        $photo = $value->foto10;
                                        if($photo){
                                            $basename = basename($photo);
                                            $temp = explode(".", $basename);

                                            $check = "thumb/blocks_htmlimages/$temp[0]-large.webp";
                                            if(file_exists($check)){
                                                $foto = url($check);
                                            }else{
                                                $foto = url($photo);
                                            }
                                        }
                                        // fine thumb
                                        ?>
                                    @if(trim($foto) != "")
                                        <div class="item">
                                            <img src="{{ $foto }}" alt="{{ $alt_img }}" class="img-fluid full-width">
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                            <?php break;

                    default:
                        echo '';
                } ?>
            @endforeach
        @endif
    </div>
</section>
