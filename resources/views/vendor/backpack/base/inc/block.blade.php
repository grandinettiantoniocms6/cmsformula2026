<div class="p-2 list-group-item d-flex align-items-center page-block-row">
    <?php
        $admin_blocks_orders = \App\Models\AdminBlock::where("is_active", 1)->get()->pluck("label", "name")->toArray();
        $type = $pb->type;

        $url_edit = "/admin/$type/$item->id/edit";
        $url_list = "#";

        $url_eredita = "/admin/eredita/$pb->id";
        $url_attivazione = "/admin/attivazione/$pb->id";

        $url_order = "#";

        $is_multi = 0;
        $order = 0;
        if(key_exists($pb->type, $admin_blocks_orders)){
            $order = 1;

            $admin_block = \App\Models\AdminBlock::where("name", $pb->type)->first();
            if($admin_block){
                $url_order = "/admin/block/order/{$admin_block->name_table}/$item->id";
                $url_edit = "/admin/$type/$item->id/edit?multi";

                $is_multi = $admin_block->is_multi;

                $item_block = \DB::table($admin_block->name_table)->where("id", $pb->obj_id)->first();
                if($item_block){
                    $url_list = "/admin/$type?block_id={$item_block->id}&block={$admin_block->name}&page_id={$pb->page_id}";
                }
            }
        }

       $block_name = json_decode($item->name, true);
       if($block_name === null){
           $name = $item->name;
       }else{
           $name = $block_name['it'];
       }
    ?>
    <span class="page-block-drag" aria-hidden="true"><i class="las la-grip-vertical"></i></span>
    <div class="px-3 page-block-meta" id="block_id_{{ $item->id }}">
        <h6 class="font-weight-bold mb-1 page-block-name">{{ $name }}</h6>
        <em class="text-info page-block-type">
            @if(key_exists($pb->type, $admin_blocks_orders))
                {{ $admin_blocks_orders[$pb->type] }}
            @endif
        </em>
        <span class="page-block-status {{ $pb->is_active == 1 ? 'is-on' : 'is-off' }}">
            {{ $pb->is_active == 1 ? 'Attivo' : 'Disattivo' }}
        </span>
    </div>
    <div class="ml-auto page-block-actions">
        @if($pb->is_active == 1)
            <a href="<?php echo $url_attivazione;?>" class="btn btn-light btn-sm text-success page-block-action-btn page-block-toggle-btn is-on" data-toggle="Attivazione" title="Attivazione id {{ $item->id }}"><i class="las la-eye"></i></a>
        @else
            <a href="<?php echo $url_attivazione;?>" class="btn btn-light btn-sm text-danger page-block-action-btn page-block-toggle-btn is-off" data-toggle="Attivazione" title="Attivazione id {{ $item->id }}"><i class="las la-eye"></i></a>
        @endif

        @if($page->is_homepage == 1)
            @if($pb->is_ereditable != 1)
                <a href="<?php echo $url_eredita;?>" class="btn btn-light btn-sm page-block-action-btn page-block-inherit-btn" data-toggle="Eredita" title="Eredita">Eredita</a>
            @else
                <a href="<?php echo $url_eredita;?>" class="btn btn-warning btn-sm page-block-action-btn page-block-inherit-btn" data-toggle="Eredita" title="Eredita">Ereditato</a>
            @endif
        @endif

        @if($page->is_homepage == 0 && ($position == "footer" || $position == "header" || $position = "content"))
            @if($pb->is_ereditable_from_id !== null)

            @else
                <a href="<?php echo $url_edit;?>" class="btn btn-light btn-sm page-block-action-btn" data-toggle="Modifica" title="Modifica"><i class="las la-cog"></i></a>

                @if($is_multi == 1)
                 <a href="<?php echo $url_list;?>" class="btn btn-light btn-sm page-block-action-btn" data-toggle="Lista" title="Lista"><i class="las la-pen"></i></a>
                @endif

                <button class="btn btn-danger btn-sm page-block-action-btn page-block-action-btn-danger" aria-label="" onclick="deleteBlock('<?php echo route('pages.blocks.delete', [$page->id, $pb->id]);?>')">
                    <i class="las la-times"></i>
                </button>
                <!--<a href="{{ route('pages.blocks.delete', [$page->id, $pb->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Cancella"><i class="las la-times"></i></a>-->
                @if($order == 1 && $is_multi == 0)
                    <!--
                    <a href="<?php echo $url_order;?>" class="btn btn-dark btn-sm" data-toggle="tooltip" title="Ordina"><i class="la la-arrows-v"></i></a>
                    -->
                @endif
            @endif
        @else
            <a href="<?php echo $url_edit;?>" class="btn btn-light btn-sm page-block-action-btn" data-toggle="Modifica" title="Modifica"><i class="las la-cog"></i></a>
            @if($is_multi == 1)
                 <a href="<?php echo $url_list;?>" class="btn btn-light btn-sm page-block-action-btn" data-toggle="Lista" title="Lista"><i class="las la-pen"></i></a>
            @endif

            <button class="btn btn-danger btn-sm page-block-action-btn page-block-action-btn-danger" aria-label="" onclick="deleteBlock('<?php echo route('pages.blocks.delete', [$page->id, $pb->id]);?>')">
                <i class="las la-times"></i>
            </button>

            <!--<a href="{{ route('pages.blocks.delete', [$page->id, $pb->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Cancella"><i class="las la-times"></i></a>-->
            @if($order == 1 && $is_multi == 0)
               <!-- <a href="<?php echo $url_order;?>" class="btn btn-dark btn-sm" data-toggle="tooltip" title="Ordina"><i class="la la-arrows-v"></i></a>-->
            @endif
        @endif

    </div>
</div>
