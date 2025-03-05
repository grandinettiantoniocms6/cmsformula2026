<?php

$padre = \App\Models\PluginProducts::where("group_id", $itemProduct->group_id)->where("is_variant", 0)->first();

$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$search = \App\Models\PluginProductsSearch::where("plugin_product_id", $padre->id)->first();
$vet_ids = [];
if($search->vet_ids_list){
    $vet_ids = json_decode($search->vet_ids_list, true);
}
?>
@if(count($vet_ids) > 0)

    <div class="product-variations">
        <div class="variation-list container-fluid ps-0">
            <div class="row gx-1">
                @foreach($vet_ids as $attribute_name => $options)
                    @if($options)
                        @foreach($options as $option)
                                <?php
                                $option_value = $option['value'][\App::getLocale()];

                                //background_color
                                if($option['type_layout'] == 0){
                                    $type_layout = "checkbox-size";
                                }else{
                                    $type_layout = "checkbox-color";
                                }

                                $IconImage = null;
                                $itemOption = \App\Models\ShopAttributesOptions::find($option['option_id']);

                                if($itemOption->icon){
                                    $IconImage = $itemOption->icon;
                                }


                                $checked = "";
                                if($itemProduct->id == $option['product_id']){
                                    $checked = "checked";
                                }
                                ?>
                            <div class="col-3xl mb-1">
                                <a class="card card-variant text-decoration-none mb-2 {{ $checked }}" title="{{ $option_value }}" href="{{ $option['url_product'] }}">
                                    <div class="row no-gutters">
                                        @if($IconImage)
                                            <div class="col-auto">
                                                <div class="px-3 py-2">
                                                    <img width="50" height="50" class="img-fluid" src="{{ url($IconImage) }}" alt="{{ $option_value }}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col border-left bg-light d-flex flex-column px-3 py-2 text-truncate">
                                            <div class="fw-bold text-uppercase text-truncate">{{ $option_value }}</div>
                                            <div class="small text-dark text-truncate">Contattaci</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
