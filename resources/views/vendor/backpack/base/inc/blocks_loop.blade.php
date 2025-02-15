<?php
$pages_blocks = \App\Models\PageBlock::where("position", $position)
    ->where("col", $col)
    ->where("page_id", $page->id)
    ->orderBy("order", "asc")->get();
if($pages_blocks){
    foreach ($pages_blocks as $pb){
        $item = null;
        $adminBlock = \App\Models\AdminBlock::where("name", $pb->type)->first();
        if($adminBlock){
            $item = \DB::table($adminBlock->name_table)->find($pb->obj_id);
        }
        ?>
        @if($item)
            <div id="header_row_{{ $pb->id }}" data-index="{{ $pb->id }}" data-position="{{ $pb->order }}">
                @include('vendor.backpack.base.inc.block')
            </div>
        @endif
        <?php
    }
}
?>
