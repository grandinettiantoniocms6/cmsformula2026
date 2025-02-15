<?php $plugin = \App\Models\PluginProductsSettings::first(); ?>
<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$now = \Carbon\Carbon::now()->toDateString();
$alpha = $item->alpha;


?>

<div class="counter-section-four dark-bg mt-80 lg-mt-40" style="@if($item->bgimage) background-image: url({{ url($item->bgimage) }})!important;@endif @if($item->bgcolor) background-color:{{ ($item->bgcolor) }}!important; @endif">
    <div class="box-layout">
        <div class="row gx-0">

            @if($array)
                @foreach($array as $value)
                    <?php
                        $counter = \App\Models\PluginCounter::find($value->plugin_counter_id);
                        $days = json_decode($counter->days, true);
                        $foto = '';
                    ?>

                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-block-five text-center">
                                <div class="d-flex align-items-end justify-content-center icon">
                                    <img src="{{ $foto }}" alt="">
                                </div>

                                @if($days)
                                <div class="main-count font-recoleta">
                                    <span class="counter" data-to="<?php echo $days["$now"];?>" data-speed="5000"><?php echo number_format($days["$now"],2, ",", ".");?>.</span>
                                @else
                                    <span class="counter" data-to="<?php echo $counter->start;?>" data-speed="5000"><?php echo $counter->start;?>.</span>
                                @endif
                                </div>
                                <!--<h2 class="text-white"><?php echo $days["$now"];?><span class="text-black">.</span></h2>-->
                                <p class="theme-mb-0">{{ $counter->title }} {{ $counter->description }}</p>
                        </div>
                    </div>

                @endforeach
            @endif

        </div>
    </div>
</div>
