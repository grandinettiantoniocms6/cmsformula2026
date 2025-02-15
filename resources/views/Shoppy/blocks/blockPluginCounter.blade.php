<?php $plugin = \App\Models\PluginProductsSettings::first(); ?>
<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$now = \Carbon\Carbon::now()->toDateString();
?>

<section class="theme-bg page-section-ptb">
    <div class="container">
        <div class="row">
            @if($array)
                @foreach($array as $value)
                    <?php
                    $counter = \App\Models\PluginCounter::find($value->plugin_counter_id);
                    $days = json_decode($counter->days, true);
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 mb-30">
                        <div class="counter left-icon text-white">
                            <h2 class="text-white">
                                @if($days)
                                    <span class="timer" data-to="<?php echo $days["$now"];?>" data-speed="5000"><?php echo number_format($days["$now"],2, ",", ".");?>.</span>
                                @else
                                    <span class="timer" data-to="<?php echo $counter->start;?>" data-speed="5000"><?php echo $counter->start;?>.</span>
                                @endif
                            </h2>
                            <!--<h2 class="text-white"><?php echo $days["$now"];?><span class="text-black">.</span></h2>-->
                            <h5 class="text-white">{{ $counter->title }}</h5>
                            <p class="text-white">{{ $counter->description }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
