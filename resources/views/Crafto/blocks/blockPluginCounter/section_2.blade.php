<?php $plugin = \App\Models\PluginProductsSettings::first(); ?>
<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$now = \Carbon\Carbon::now()->toDateString();
?>

@if($item->bgimage)
        <?php
        // serve per le thumb
        $foto = "";
        $photo = $item->bgimage;
        if($photo){
            $basename = basename($photo);
            $temp = explode(".", $basename);

            $check = "thumb/blocks_plugins_counters/$temp[0]-large.webp";
            if(file_exists($check)){
                $foto = url($check);
            }else{
                $foto = url($photo);
            }
        }
        // fine thumb
        ?>


@endif


<style>
    #block-counter-{{ $item->id }} {
        --counter-block-bg: {{ $item->bgcolor }};
    }
</style>


<section id="block-counter-{{ $item->id }}" class="big-section" style="background-color: {{ $item->bgcolor }};">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 justify-content-center counter-style-01">

            @if($array)
                @foreach($array as $value)
                        <?php
                        $counter = \App\Models\PluginCounter::find($value->plugin_counter_id);

                        $days = null;
                        if($counter->step != 0){
                            $days = json_decode($counter->days, true);
                            if($days == null){
                                continue;
                            }

                            if(!key_exists($now, $days)){
                                continue;
                            }
                        }

                        ?>

                        <!-- cicla Webshop-->
                    <div class="col feature-box md-mb-50px xs-mb-30px" style="text-align: {{ $counter->text_align }};">

                        <div class="feature-box-icon mb-8">
                            @if($counter->icon)
                                <span style="color: {{ $counter->icon_color }}; font-size: {{ $counter->icon_size }};">{!! $counter->icon !!} </span>
                            @else
                                @if(trim($counter->foto) != "")
                                    <img src="{{ $counter->foto }}" title="" loading="lazy" class="mx-auto">
                                @endif
                            @endif
                        </div>

                        <div class="feature-box-content mb-8">
                            @if($days)
                                <h2 style="color: {{ $counter->number_color }}; font-size: {{ $counter->counter_size }};" class="d-inline-block align-middle counter-number fw-700 counter" data-to="<?php echo $days["$now"];?>" data-speed="1000"><?php echo number_format($days["$now"],2, ",", ".");?>. </h2> <span style="font-size: 26px!important; color: {{ $counter->subtitle_color }};">{{ $counter->description }}</span>
                            @else
                                <h2 style="color: {{ $counter->number_color }}; font-size: {{ $counter->counter_size }};" class="d-inline-block align-middle counter-number fw-700 counter" data-to="<?php echo $counter->start;?>" data-speed="1000"><?php echo $counter->start;?>. </h2> <span style="font-size: 26px!important; color: {{ $counter->subtitle_color }};">{{ $counter->description }}</span>
                            @endif
                            <h6 style="color: {{ $counter->title_color }};">{{ $counter->title }}</h6>

                        </div>

                    </div>


                @endforeach
            @endif

        </div>
    </div>

</section>
