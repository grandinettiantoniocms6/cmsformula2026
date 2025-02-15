@if(count($prices) > 1)
<div id="box_prices_filters">
    <div class="widget widget-collapsible">
        <h3 class="widget-title">Filtra per prezzo<span class="toggle-btn"></span></h3>
        <input type="range" class="custom-range" step="1" min="{{ round(reset($prices),2) }}" max="{{ round(end($prices),2) }}" id="myRange" value="{{ round($v_checked_price,2) }}">
        <div id="resultRange" class="mb-4 mt-3 small">Prezzo massimo: {{ round($v_checked_price,2) }} &euro;</div>
        <a href="javascript:apply_price_max()" class="btn btn-block btn-xs">Applica filtro prezzo</a>
    </div>
</div>
<script>
    var slider = document.getElementById("myRange");
    var output = document.getElementById("resultRange");
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
        output.innerHTML = "Prezzo massimo: "+parseFloat(this.value).toFixed(2)+" &euro;";
    }
</script>
@endif
