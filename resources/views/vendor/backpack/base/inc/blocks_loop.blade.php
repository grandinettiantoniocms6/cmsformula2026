<?php
$pages_blocks = \App\Models\PageBlock::selectRaw("blocks_pages.*, admin_blocks.name_table")
    ->where("position", $position)
    ->join("admin_blocks", "admin_blocks.name", "=", "blocks_pages.type")
    ->where("col", $col)
    ->where("page_id", $page->id)
    ->orderBy("order", "asc")->get();
if($pages_blocks){
    $admin_blocks_orders = \App\Models\AdminBlock::where("is_active", 1)->where("is_ordinable", 1)->get()->pluck("label", "name")->toArray();

    foreach ($pages_blocks as $pb){
        //$item = null;
        /*$adminBlock = \App\Models\AdminBlock::where("name", $pb->type)->first();
        if($adminBlock){
            $item = \DB::table($pb->name_table)->find($pb->obj_id);
        }*/
        $item = \DB::table($pb->name_table)->find($pb->obj_id);
        ?>
        @if($item)
            <div id="header_row_{{ $pb->id }}" data-index="{{ $pb->id }}" data-position="{{ $pb->order }}">

            </div>
        @endif
        <?php
    }
}
?>
