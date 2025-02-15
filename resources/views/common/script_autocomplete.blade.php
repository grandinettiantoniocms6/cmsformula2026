
<!-- autocomplete cerca cat prod -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
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
                    @if(env("PROJECT_NAME") == "Manega" && strpos(\URL::current(),"luxury"))
                        jQuery.getJSON('/'+primo_nodo+'/search?luxury=1&q=' + request.term + '', function(data) {
                            // The json object data is returned by the AJAX request
                            response(data);
                        });
                    @else
                        jQuery.getJSON('/'+primo_nodo+'/search?q=' + request.term + '', function(data) {
                            // The json object data is returned by the AJAX request
                            response(data);
                        });
                    @endif

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
                    if(item.add_cart != ""){
                        var button_cart = "<a class='button button-border black x-small' href='" + item.add_cart + "'>" + item.button_cart + "</a>";
                    }else{
                        var button_cart = "";
                    }

                    return $('<li>')
                        .data("ui-autocomplete-item", item)
                        .append("<img src='" + item.cover + "' width='50'><div><span>" + item.label + "</span>  <small> " + item.price_view + "</small> "+button_cart+"</div>")
                        .appendTo(ul);
                }else{

                    if(lang == "it"){
                        return $('<li>')
                            .data("ui-autocomplete-item", item)
                            .append("<div style='font-size:15px;'><span>Nessun risultato</span></div>")
                            .appendTo(ul);
                    }else{
                        return $('<li>')
                            .data("ui-autocomplete-item", item)
                            .append("<div style='font-size:15px;'><span>No results</span></div>")
                            .appendTo(ul);
                    }

                }


            };
        }
    });
</script>
