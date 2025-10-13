<!-- SE ENTRO QUI VADO NELLA LISTA DELLE NEWS ++++++++++ Grid news -->
<?php
$style = 1;
$date = null;
$bg_color = "#13ab68";
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


<?php
$col = "";
?>

<section class="pt-3 ps-11 pe-11 xl-ps-2 xl-pe-1">

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

    <div class="{{ $fullwidth }}">
        <div class="row">
            <div class="col-12">
                <ul style="list-style: none!important;" class="blog-grid blog-wrapper grid-loading grid grid-{{ $col }}col xl-grid-{{ $col }}col lg-grid-{{ $col }}col md-grid-{{ $col }}col sm-grid-1col xs-grid-1col gutter-extra-large">
                    <li style="list-style: none!important;" class="grid-sizer"></li>
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

                            <!-- CICLO NEWS -->
                            @include("Crafto.blocks.blockNews.section_$style")
                            <!-- / CICLO NEWS -->

                        @endforeach
                    @endif
                </ul>
            </div>

            <!-- Paginazione News -->
            <div class="w-100 d-flex mt-4 justify-content-center md-mt-30px">
                <ul style="list-style: none!important;" class="pagination pagination-style-01 fs-13 fw-500 mb-0">
                    @if($news)
                        {{ $news->links() }}
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
