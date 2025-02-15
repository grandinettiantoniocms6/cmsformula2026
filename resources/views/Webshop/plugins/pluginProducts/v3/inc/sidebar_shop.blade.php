<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>
<aside class="col-lg-3 @if($shopSetting->sidebar_position == "sx") sidebar-left @else sidebar-right @endif sidebar show-lg" id="sidebar-shop">
    <div class="sidebar-title close-navbar" data-bs-toggle="collapse" data-bs-target="#sidebar-shop">{{ @$labels['shop-filtri'] }}<i class="fas fa-times"></i></div>
    <div class="sidebar-content">
        @if($shopSetting->show_search_in_list == 1)
            <div class="widget widget-collapsible">
                @include("$thema.plugins.pluginProducts.v3.inc.search")
            </div>
        @endif

        <div class="widget widget-collapsible">
            <h3 class="widget-title" data-bs-target="#widget-categories" data-bs-toggle="collapse" aria-expanded="true">{{ @$labels['shop-varie-categorie'] }} <i class="bi bi-chevron-down"></i></h3>

            @if($categories)
                <div class="widget-body collapse show" id="widget-categories">
                    <ul>
                        @foreach($categories as $categoryItem)
                            <?php $tot = 0; ?>
                            @if(count($categoryItem->figli) > 0)
                                @foreach($categoryItem->figli as $figlio)
                                    <?php $tot = $tot + $figlio->count;?>
                                @endforeach

                                <?php
                                if($tot == 0){
                                    $tot = $tot + $categoryItem->count;
                                }
                                ?>
                            @else
                                <?php $tot = $tot + $categoryItem->count; ?>
                            @endif

                            @if($tot > 0)
                                @if(count($categoryItem->figli) > 0)
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{ route("pluginProducts.".\App::getLocale(), [$categoryItem->slug]) }}"><strong>{{ $categoryItem->name }} ({{ $tot }})</strong></a>
                                            <button type="button" class="btn-arrow" aria-label="Mostra {{ $categoryItem->name }}" data-bs-target="#submenu-{{ $categoryItem->id }}" data-bs-toggle="collapse" aria-expanded="true"><i class="bi bi-chevron-down"></i></button>
                                        </div>
                                        <ul class="collapse show" id="submenu-{{ $categoryItem->id }}">
                                            @foreach($categoryItem->figli as $figlio)
                                                @if($figlio->count > 0)
                                                    <li>
                                                        <a href="{{ route("pluginProducts.".\App::getLocale(), [$figlio->slug]) }}">
                                                            @if($figlio->id == @$category->id)
                                                                <strong>{{ $figlio->name }} ({{ $figlio->count }})</strong>
                                                            @else
                                                                {{ $figlio->name }} ({{ $figlio->count }})
                                                            @endif
                                                        </a>
                                                        @if(count($figlio->figli_2))
                                                            <ul class="collapse show" id="submenu-{{ $figlio->slug }}">
                                                                @foreach($figlio->figli_2 as $figli2)
                                                                    @if($figli2->count > 0)
                                                                        <li>
                                                                            <a href="{{ route("pluginProducts.".\App::getLocale(), [$figli2->slug]) }}">
                                                                                @if($figli2->id == @$category->id)
                                                                                    <strong>{{ $figli2->name }} ({{ $figli2->count }})</strong>
                                                                                @else
                                                                                    {{ $figli2->name }} ({{ $figli2->count }})
                                                                                @endif
                                                                            </a>
                                                                            @if($figli2->figli_3)
                                                                                <ul>
                                                                                    @foreach($figli2->figli_3 as $figli3)
                                                                                        @if($figli3->count > 0)
                                                                                            <li>
                                                                                                <a href="{{ route("pluginProducts.".\App::getLocale(), [$figli3->slug]) }}">
                                                                                                    @if($figli3->id == @$category->id)
                                                                                                        <strong>{{ $figli3->name }} ({{ $figli3->count }})</strong>
                                                                                                    @else
                                                                                                        {{ $figli3->name }} ({{ $figli3->count }})
                                                                                                    @endif
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="d-flex align-items-center">
                                        <a href="{{ route("pluginProducts.".\App::getLocale(), [$categoryItem->slug]) }}">
                                            @if($categoryItem->id == @$category->id)
                                                <strong> {{ $categoryItem->name }} ({{ $tot }})</strong>
                                            @else
                                                {{ $categoryItem->name }} ({{ $tot }})
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div id="box_brands_filters">
            @if(count($brands) && $plugin->show_brands_sidebar == 1)
                <div class="widget widget-collapsible">
                    @if($brands)
                        <?php
                        $v_brands = [];
                        foreach($brands as $key => $brand_id){
                            $brand_item = \App\Models\PluginProductsBrands::find($brand_id);
                            if($brand_item){
                                $v_brands[$brand_id] = $brand_item->name;
                            }
                        }

                        asort($v_brands);
                        ?>

                        <h3 class="widget-title" data-bs-target="#widget-brand" data-bs-toggle="collapse" aria-expanded="true">{{ @$labels['shop-brand'] }} <i class="bi bi-chevron-down"></i></h3>
                        <div class="widget-body collapse show" id="widget-brand">
                            @foreach($v_brands as $key => $brandName)
                                <?php
                                $checked_id = null;
                                if(request()->has('brands_check')){
                                    $checked_id = request()->get('brands_check');
                                }
                                ?>
                                    <div class="form-check">
                                        <input onclick="filters_check('brands_check');" type="checkbox" class="form-check-input brands_check" id="check-brand-<?php echo $key;?>" name="brands_check[]" value="{{ $key }}" @if($checked_id == $key) checked @endif>
                                        <label class="form-check-label" for="check-brand-<?php echo $key;?>">{{ $brandName }}</label>
                                    </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>

        @if($prices)
            <?php
            $symbol = "&euro;";
            if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                $symbol = "&#36;";
            }
            if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                $symbol = "&euro;";
            }
            ?>
            @if($pluginSetting->show_prices == 1)
                <div id="box_prices_filters">
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title" data-bs-target="#widget-range" data-bs-toggle="collapse" aria-expanded="true">Filtra per prezzo <i class="bi bi-chevron-down"></i></h3>
                        <div class="widget-body collapse show" id="widget-range">
                            <input type="range" class="form-range" step="1" min="{{ round(reset($prices),2) }}" max="{{ round(end($prices),2) }}" id="myRange" value="{{ round(end($prices),2) }}">
                            <div id="resultRange" class="font-sm">Prezzo massimo: {{ round(end($prices),2) }} {!! $symbol !!} </div>
                            <button type="button" onclick="apply_price_max()" class="btn btn-sm btn-primary w-100 mt-3">Applica filtro prezzo</button>
                            <a href="<?php echo URL::current(); ?>" class="btn btn-sm btn-danger w-100 mt-3 text-white">Rimuovi tutti i filtri</a>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @if($category)
            <div id="box_attributes_filters">
                @if(count($attributes_v) && $pluginSetting->show_attributes_sidebar == 1)
                    @foreach($attributes_v as $attribute_id => $options)
                        <?php $item_attribute = \App\Models\ShopAttributes::find($attribute_id); ?>
                        @if($item_attribute)
                            @if(count($options))
                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title" data-bs-target="#widget-attributes-{{ $item_attribute->id }}" data-bs-toggle="collapse" aria-expanded="true">{{ $item_attribute->name }} <i class="bi bi-chevron-down"></i></h3>
                                    <div class="widget-body collapse show" id="widget-attributes-{{ $item_attribute->id }}">
                                        @foreach($options as $option_id => $option_value)
                                            <div class="form-check">
                                                <input onclick="filters_check('options_check');" type="checkbox" class="form-check-input options_check" id="check-option-<?php echo $option_id;?>" name="options_check[]" value="{{ $option_id }}">
                                                <label class="form-check-label" for="check-option-<?php echo $option_id;?>">{{ $option_value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>

            <div id="box_tags_filters">
                @if(count($tags) && $plugin->show_tags == 1)

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title" data-bs-target="#widget-tags" data-bs-toggle="collapse" aria-expanded="true">{{ @$labels['shop-varie-tag'] }} <i class="bi bi-chevron-down"></i></h3>
                        @if($tags)
                            <div class="widget-body collapse show" id="widget-tags">
                                @foreach($tags as $k=>$tag)
                                    @if(trim($tag) != "")
                                        <?php
                                        $checked_tag = "";
                                        if(request()->has('tags_check')){
                                            $checked_tag = request()->get('tags_check');
                                        }
                                        ?>
                                        <div class="tag-element">
                                            <input onclick="filters_check('tags_check');" type="checkbox" class="btn-check tags_check" id="check-tag-<?php echo $k;?>" name="tags_check[]" value="{{ $tag }}" @if($checked_tag == $tag) checked @endif>
                                            <label class="btn btn-sm btn-outline-primary" for="check-tag-<?php echo $k;?>">{{ $tag }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

        @endif

    </div>
    <div class="sidebar-backdrop" data-bs-toggle="collapse" data-bs-target="#sidebar-shop"></div>
</aside>
