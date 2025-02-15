@if($block->position == "header")
<?php
   $page = \App\Models\Page::where("id", $block->page_id)->first();
   $height_header = $item->height_header;
   $alpha = $item->alpha;
   $bgcolor = $item->bgcolor;
?>

  @include("Creative.blocks.blockImage.section_$item->style")

@else
    <section class="page-section-ptb">
        <div class="container">
            <div class="row">
                @if($item->foto)
                    <img src="{{ $item->foto }}" alt="" class="img-fluid">
                @endif
            </div>
        </div>
    </section>

@endif
