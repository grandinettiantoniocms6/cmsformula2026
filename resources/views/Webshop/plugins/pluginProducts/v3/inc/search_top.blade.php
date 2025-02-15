<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>
<form action="{{ route("pluginProducts.search_results.".\App::getLocale()) }}" method="get">
    {{ csrf_field() }}
    <div class="widget-search widget-topbar">
        <div class="input-group">
            <input type="text" class="form-control" id="search-autocomplete-topbar" placeholder="{{ @$labels['cerca'] }}" name="search">
            <button class="btn" type="submit" aria-label="Cerca"><i class="bi bi-search"></i></button>
        </div>
    </div>
    <div id="autocomplete-results-topbar" class="search-results-autocomplete"></div>
</form>
