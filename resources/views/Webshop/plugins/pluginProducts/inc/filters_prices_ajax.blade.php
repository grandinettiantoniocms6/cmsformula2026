<?php
$symbol = "&euro;";
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
    $symbol = "&#36;";
}
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
    $symbol = "&euro;";
}
?>

@if(count($prices) > 1 && $plugin->show_prices == 1)
<div id="box_prices_filters">
    <div class="widget widget-collapsible">
        <h3 class="widget-title" data-bs-target="#widget-range" data-bs-toggle="collapse" aria-expanded="true">Filtra per prezzo <i class="bi bi-chevron-down"></i></h3>
        <div class="widget-body collapse show" id="widget-range">
            <input type="range" class="form-range" step="1" step="1" min="{{ round(reset($prices),2) }}" max="{{ round(end($prices),2) }}" id="myRange" value="{{ round($v_checked_price,2) }}">
            <div id="resultRange" class="font-sm">Prezzo massimo: {{ round($v_checked_price,2) }} {!! $symbol !!}</div>
            <button type="button" onclick="apply_price_max()" class="btn btn-sm btn-primary w-100 mt-3">Applica filtro prezzo</button>
            <a href="<?php echo URL::current(); ?>" class="btn btn-sm btn-danger w-100 mt-3 text-white">Rimuovi tutti i filtri</a>
        </div>
    </div>
</div>
<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementById("resultRange");
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
        output.innerHTML = "Prezzo massimo: "+parseFloat(this.value).toFixed(2)+" {!! $symbol !!}";
    }
</script>
@else
    <div id="box_prices_filters">
        <div class="widget widget-collapsible">
            <div class="widget-body collapse show" id="widget-range">
                <a href="<?php echo URL::current(); ?>" class="btn btn-sm btn-danger w-100 mt-3 text-white">Rimuovi tutti i filtri</a>
            </div>
        </div>
    </div>
@endif
