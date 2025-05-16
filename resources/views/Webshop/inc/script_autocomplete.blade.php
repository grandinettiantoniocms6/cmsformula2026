<!-- autocomplete cerca cat prod -->
<?php
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
$pluginSetting = \App\Models\PluginProductsSettings::first();
?>
<script>
    $( function() {
        var searchExist = $('#search-autocomplete-topbar').length;
        if(searchExist > 0){
            $.widget( 'custom.catcomplete', $.ui.autocomplete, {
                _create: function() {
                    this._super();
                    this.widget().menu( 'option', 'items', '> :not(.ui-autocomplete-category)' );
                },
            });

            var lang = '{{ \App::getLocale() }}';
            var primo_nodo = "{{ env("PLUGIN_PRODUCTS_URL_IT") }}"

            $('#search-autocomplete-topbar').catcomplete({
                delay: 0,
                html: true,
                minLength: 3,
                source: function(request, response) {
                    // request is the object that contains the field term which is the users input
                    // response is the function that takes the data and calls the render
                    // function of the autocomplete
                    jQuery.getJSON('/'+primo_nodo+'/search?q=' + request.term + '', function(data) {
                        // The json object data is returned by the AJAX request
                        response(data);
                    });

                },
                select: function(event, ui) {
                    // Sets the text of the input textbox to the title of the object referenced
                    // by the selected list item

                    var valore_slug = "";
                    $.each(ui.item.slug, function(key, element) {
                        if(lang == key){
                            return valore_slug = element;
                        }
                    });

                    window.location.href = "/"+primo_nodo+"/"+ui.item.slug_category+"/"+valore_slug;

                    return false;
                },
                appendTo: '#autocomplete-results-topbar',
                open: function() {

                },
            }).data('custom-catcomplete')._renderItem = function (ul, item) {
                console.log(item);
                if( item.value != "0"){
                    var button_cart = "";
                    @if($adminPlugin->version == 3 && $pluginSetting->is_add_to_cart == 1)
                        if(item.add_cart != ""){

                            var button_cart = "<a class='btn btn-product btn-sm' href='" + item.add_cart + "'>" + item.button_cart + "</a>";
                        }else{
                            var button_cart = "";
                        }
                    @endif

                    return $('<li>')
                        .data("ui-autocomplete-item", item)
                        .append("<img src='" + item.cover + "' width='50'><div class='col'><span>" + item.label + "</span> @if($adminPlugin->version == 3 && $pluginSetting->show_prices == 1)<small> " + item.price_view + "</small>@endif</div><div class='col-auto'>"+button_cart+"</div>")
                        .appendTo(ul);
                }else{

                    if(lang == "it"){
                        return $('<li>')
                            .data("ui-autocomplete-item", item)
                            .append("<div class='font-lg'><span>Nessun risultato</span></div>")
                            .appendTo(ul);
                    }else{
                        return $('<li>')
                            .data("ui-autocomplete-item", item)
                            .append("<div class='font-lg'><span>No results</span></div>")
                            .appendTo(ul);
                    }
                }
            };
        }
    });

    $( function() {
        var searchExist = $('#search-autocomplete-desktop').length;
        if(searchExist > 0){
            $.widget( 'custom.catcomplete', $.ui.autocomplete, {
                _create: function() {
                    this._super();
                    this.widget().menu( 'option', 'items', '> :not(.ui-autocomplete-category)' );
                },
            });

            var lang = '{{ \App::getLocale() }}';
            var primo_nodo = "{{ env("PLUGIN_PRODUCTS_URL_IT") }}"

            $('#search-autocomplete-desktop').catcomplete({
                delay: 0,
                html: true,
                minLength: 3,
                source: function(request, response) {
                    // request is the object that contains the field term which is the users input
                    // response is the function that takes the data and calls the render
                    // function of the autocomplete
                    jQuery.getJSON('/'+primo_nodo+'/search?q=' + request.term + '', function(data) {
                        // The json object data is returned by the AJAX request
                        response(data);
                    });

                },
                select: function(event, ui) {
                    // Sets the text of the input textbox to the title of the object referenced
                    // by the selected list item

                    var valore_slug = "";
                    $.each(ui.item.slug, function(key, element) {
                        if(lang == key){
                            return valore_slug = element;
                        }
                    });

                    window.location.href = "/"+primo_nodo+"/"+ui.item.slug_category+"/"+valore_slug;

                    return false;
                },
                appendTo: '#autocomplete-results-desktop',
                open: function() {

                },
            }).data('custom-catcomplete')._renderItem = function (ul, item) {
                console.log(item);
                if( item.value != "0"){
                    var button_cart = "";
                    @if($adminPlugin->version == 3 && $pluginSetting->is_add_to_cart == 1)
                        if(item.add_cart != ""){
                            var button_cart = "<a class='btn btn-product btn-sm' href='" + item.add_cart + "'>" + item.button_cart + "</a>";
                        }else{
                            var button_cart = "";
                        }
                    @endif
                    return $('<li>')
                        .data("ui-autocomplete-item", item)
                        .append("<img src='" + item.cover + "' width='50'><div class='col'><span>" + item.label + "</span>  @if($adminPlugin->version == 3 && $pluginSetting->show_prices == 1)<small> " + item.price_view + "</small>@endif</div><div class='col-auto'>"+button_cart+"</div>")
                        .appendTo(ul);
                }else{

                    if(lang == "it"){
                        return $('<li>')
                            .data("ui-autocomplete-item", item)
                            .append("<div class='font-lg'><span>Nessun risultato</span></div>")
                            .appendTo(ul);
                    }else{
                        return $('<li>')
                            .data("ui-autocomplete-item", item)
                            .append("<div class='font-lg'><span>No results</span></div>")
                            .appendTo(ul);
                    }

                }


            };
        }
    });
</script>
