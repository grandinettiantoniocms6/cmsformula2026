<?php
$pages_blocks = \App\Models\PageBlock::selectRaw("blocks_pages.*, admin_blocks.name_table")
    ->join("admin_blocks", "admin_blocks.name", "=", "blocks_pages.type")
    ->where("position", $position)
    ->where("col", ">", $col)
    ->where("page_id", $page->id)
    ->orderBy("order", "asc")->get();
if($pages_blocks && count($pages_blocks) > 0){ ?>
    <div class="text-danger d-flex align-items-center py-1 px-2">
        <div><i class="la la-warning la-lg"></i> Blocchi non visibili nella pagina a causa del cambio di layout</div>
        <button type="button" class="btn btn-sm btn-outline-danger ml-2" data-toggle="modal" data-target="#modal_limbo_{{ $position }}_col{{ $col }}_block">Guarda</button>
    </div>
    <div class="modal fade" id="modal_limbo_{{ $position }}_col{{ $col }}_block" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Blocchi non visibili</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="la la-close la-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                <?php foreach ($pages_blocks as $pb){
                    /*$item = null;
                    $adminBlock = \App\Models\AdminBlock::where("name", $pb->type)->first();
                    if($adminBlock){
                        $item = \DB::table($adminBlock->name_table)->find($pb->obj_id);
                    }*/
                    $item = \DB::table($pb->name_table)->find($pb->obj_id);
                    ?>
                    @if($item)
                        <div id="header_row_{{ $pb->id }}" class="page-block-sort-item" data-index="{{ $pb->id }}" data-position="{{ $pb->order }}">
                            @include('vendor.backpack.base.inc.block')
                        </div>
                    @endif
                    <?php
                } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
