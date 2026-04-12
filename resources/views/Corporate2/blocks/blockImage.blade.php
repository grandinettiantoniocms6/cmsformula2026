@if($block->position == "header")
<?php
   $agent = new \Jenssegers\Agent\Agent();
   $page = \App\Models\Page::where("id", $block->page_id)->first();
   $height_header = $item->height_header;
   $alpha = $item->alpha;

    $foto = "";
    if($item->foto){
        $basename = basename($item->foto);
        $temp = explode(".", $basename);

        if(key_exists(1,$temp)){
            $check = "thumb/blocks_images/$temp[0]-large.webp";
        }else{
            $check = "thumb/blocks_images/$temp[0]-large";
        }

        if(file_exists($check)){
            $foto = url($check);
        }else{
            $foto = url($item->foto);
        }
    }

    if($agent->isMobile() || $agent->isTablet()){
        if($item->foto_mobile){
            $foto = url($item->foto_mobile);
        }
    }
?>
    @include("Corporate2.blocks.blockImage.section_$item->style")
@else
    <?php
        $foto = "";
        if($item->foto){
            $basename = basename($item->foto);
            $temp = explode(".", $basename);

            if(key_exists(1,$temp)){
                $check = "thumb/blocks_images/$temp[0]-large.webp";
            }else{
                $check = "thumb/blocks_images/$temp[0]-large";
            }

            if(file_exists($check)){
                $foto = url($check);
            }else{
                $foto = url($item->foto);
            }
        }
    ?>

    <section class="block-image image-wrapper bg-overlay-black-{{ $item->alpha }} wow animate__fadeInUp" data-wow-duration=".3s">
        <div class="container">
            <div class="row">
                @if(trim($foto) != "")
                    <img src="{{ $foto }}" class="img-fluid" loading="lazy">
                @endif
            </div>
        </div>
    </section>

@endif

