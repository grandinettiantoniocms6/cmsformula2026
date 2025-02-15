@if($blockNews)
    <?php
    $padre = \App\Models\BlockNews::where("id", $blockNews->block_id)->first();
    $title = $blockNews->title;
    $description = $blockNews->description;
    $slug =$blockNews->slug;

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
    ?>

    <section class="blog white-bg page-section-ptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="blog-entry mb-50">
                        @if($blockNews->foto)
                            <div class="entry-image clearfix">
                                <img src="/{{ $blockNews->foto }}" alt="">
                            </div>
                        @endif
                        <div class="blog-detail">
                            <div class="entry-title mb-10">
                                <h5>{{ $title }}</h5>
                            </div>
                            <div class="entry-meta mb-10">
                                <ul>
                                    @foreach($v_tag as $t)
                                        <?php
                                        $news_url_tag = route('news.tag', trim($t));
                                        ?>
                                        <li><a class="text-link-1" href="{{ $news_url_tag }}">{{ $t }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="entry-content">
                                {!! $description !!}
                            </div>
                            <div class="entry-share clearfix">
                                <div class="social list-style-none float-right">
                                    <strong>Categoria : </strong>
                                    @if(count($v_category))
                                        <ul>
                                            @foreach($v_category as $t)
                                                <?php
                                                $news_url_tag = route('news.category', $t);
                                                ?>
                                                <li><a class="text-link-1" href="{{ $news_url_tag }}">{{ $t }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@else
    <!-- Grid news -->
    <section class="blog white-bg page-section-ptb">
        <div class="container">
            <div class="row">
                @if($news)

                    @foreach($news as $value)
                        <?php
                        $title = $value->title;
                        $abstract = $value->abstract;
                        $description = $value->description;
                        $slug = $value->slug;

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
                        ?>

                        <!-- CICLO NEWS -->
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog-entry mb-50">
                                    <div class="entry-image clearfix">
                                        @if($value->foto)
                                            <a href="{{ $news_url }}">
                                                <img class="img-fluid" src="/{{ $value->foto }}" alt="">
                                            </a>
                                        @endif

                                    </div>
                                    <div class="blog-detail">
                                        <div class="entry-title mb-10">
                                            <a href="{{ $news_url }}">{{ $title }}</a>
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
                                            <p>{{ $abstract }} </p>
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

            </div>
            <div class="row">
                {{ $news->links() }}
            </div>
            @endif
           </div>
        </div>
    </section>
    <!-- / Grid News -->

@endif
