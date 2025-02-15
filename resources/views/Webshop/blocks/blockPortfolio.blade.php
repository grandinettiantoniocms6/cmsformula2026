<section class="block-portfolio">
    <div class="container">
        <h3 class="section-title">Gallery</h3>

        @if($array)
            <div class="grid row row-cols-1 row-cols-sm-2 row-cols-md-3">
            @foreach($array as $value)
                <?php

                $title = json_decode($value->title, true);
                if($title === null){
                    $title = [];
                }

                $category = json_decode($value->category, true);
                if($category === null){
                    $category = [];
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

                $url = "#";
                if(trim($url_interno[\App::getLocale()]) != ""){
                    $url = "/{$url_interno[\App::getLocale()]}";
                }else{
                    if(trim($url_esterno[\App::getLocale()]) != ""){
                        $url = $url_esterno[\App::getLocale()];
                    }
                }

                if(!key_exists(\App::getLocale(), $description)){
                    $description[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $title)){
                    $title[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $button)){
                    $button[\App::getLocale()] = "";
                }
                ?>
                    <div class="card mb-4">
                        @if(trim($value->foto) != "")
                            <img class="img-fluid" src="{{ $value->foto }}" alt="{{ $description[\App::getLocale()] }}" loading="lazy">
                        @endif
                        <div class="card-overlay bg-primary">
                            @if(trim($button[\App::getLocale()])!="")
                                <h4 class="title">{{ $title[\App::getLocale()] }}</h4>
                                <a class="text" target="{{ $type_href }}" href="{{ $url }}"> {{ $description[\App::getLocale()] }} | {{ $button[\App::getLocale()] }} </a>
                            @endif
                        </div>
                        <a class="glightbox-p" href="{{ $value->foto }}"><i class="bi bi-arrows-move"></i></a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
