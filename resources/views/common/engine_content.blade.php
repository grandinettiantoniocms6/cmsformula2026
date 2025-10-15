@if($blocks)
    <?php $theme = env('TEMA');?>
    @foreach($blocks as $block)
        <?php
        $item = null;
        $content = "";
        $adminBlock = \App\Models\AdminBlock::where("name", $block->type)->first();
        if($adminBlock){
            if($adminBlock->is_multi == 1){
                $item = \DB::table($adminBlock->name_table)->find($block->obj_id);
                if($item){
                    switch ($adminBlock->name_table){
                        case "blocks_news":
                            $tempOrder = explode("|", $item->type_order);

                            if($item->number_news > 0){
                                $number = \DB::table($adminBlock->name_table)
                                    ->where("block_id", $item->id)
                                    ->orderBy($tempOrder[0], $tempOrder[1])
                                    ->count();
                                if($number > 0){
                                    $array = \DB::table($adminBlock->name_table)
                                        ->where("block_id", $item->id)
                                        ->orderBy($tempOrder[0], $tempOrder[1])
                                        ->paginate($item->number_news);
                                }else{
                                    $array = \DB::table($adminBlock->name_table)
                                        ->whereNotNull("block_id")
                                        ->orderBy($tempOrder[0], $tempOrder[1])
                                        ->paginate($item->number_news);
                                }
                            }else{
                                $array = \DB::table($adminBlock->name_table)
                                    ->whereNotNull("block_id")
                                    ->orderBy($tempOrder[0], $tempOrder[1])
                                    // riga 36 serve per le news in home
                                    ->take($item->number_news_home)
                                    ->get();
                            }

                            break;
                        case "blocks_gallerys":
                            if($item->is_pagination == 1){
                                $array = \DB::table($adminBlock->name_table)
                                    ->where("block_id", $item->id)
                                    ->orderBy("lft", "asc")
                                    ->paginate($item->number_pagination);

                            }else{
                                $array = \DB::table($adminBlock->name_table)
                                    ->where("block_id", $item->id)->orderBy("lft", "asc")->get();
                            }
                            break;

                        // Blocco documenti ordinamento automatico per data di creazione
                        case "blocks_documents":
                            $array = \DB::table($adminBlock->name_table)
                                ->where("block_id", $item->id)->orderBy("id", "desc")->get();
                            break;
                        // fine

                        default:
                            $array = \DB::table($adminBlock->name_table)
                                ->where("block_id", $item->id)->orderBy("lft", "asc")->get();
                            break;
                    }

                    $content = view("$theme.blocks.$block->type", compact('item','array','block', 'position'))->render();
                }
            }else{
                $item = \DB::table($adminBlock->name_table)->find($block->obj_id);
                $content = view("$theme.blocks.$block->type", compact('item','block','position'))->render();
            }
        }
        ?>
        {!! $content !!}
    @endforeach
@endif

<?php
if($position == "header"){
    $checkImage = \App\Models\PageBlock::where("position", "header")
        ->whereRaw("(type = 'blockImage' OR type = 'blockSlideshow' OR type = 'blockVideobg' OR type = 'blockHero')")
        ->where("page_id", $page->id)
        ->where("is_active", 1)
        ->count();
    if($checkImage == 0){
        if(in_array($page->slug, config('config.slug_shop_formula'))){
            $content = view("$theme.blocks.headerVuotaShop")->render();
        }else{
            $content = view("$theme.blocks.headerVuota")->render();
        }
        echo $content;
    }
}
?>
