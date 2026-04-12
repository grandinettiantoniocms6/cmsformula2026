<?php $plugin = \App\Models\PluginProductsSettings::first(); ?>
<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$now = \Carbon\Carbon::now()->toDateString();
?>

<style>
    #block-counter-{{ $item->id }} {
        --counter-block-bg: {{ $item->bgcolor }};
    }
</style>

<section id="block-counter-{{ $item->id }}" class="block-counter image-wrapper bg-overlay bg-overlay-black-{!! $item->alpha !!}">
    <div class="container">
        <div class="row">
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

                    <div class="col-sm-6 col-lg-3 my-2">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="title">
                                    @if($days)
                                        <span class="timer" data-to="<?php echo $days["$now"];?>" data-speed="5000"><?php echo number_format($days["$now"],2, ",", ".");?>.</span>
                                    @else
                                        <span class="timer" data-to="<?php echo $counter->start;?>" data-speed="5000"><?php echo $counter->start;?>.</span>
                                    @endif
                                </h3>
                                <h5 class="subtitle">{{ $counter->title }}</h5>
                                <div class="description">{{ $counter->description }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

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

        <img src="{{ $foto }}" class="img-cover" loading="lazy">
    @endif
</section>
