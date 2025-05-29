<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();  ?>
<form action="{{ route("pluginProducts.search_results.".\App::getLocale()) }}" method="get">
    {{ csrf_field() }}
    <div class="widget-search widget-topbar">
        <div class="input-group w-100 rounded bg-white">
            <input type="text" class="form-control border-0" id="search-autocomplete-desktop" placeholder="{{ @$labels['cerca'] }}" name="search">
            <div class="input-group-append">
                <button class="btn btn-link" type="submit">
                    <i class="fa fa-search text-dark"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="autocomplete-results-desktop" class="search-results-autocomplete"></div>
</form>
