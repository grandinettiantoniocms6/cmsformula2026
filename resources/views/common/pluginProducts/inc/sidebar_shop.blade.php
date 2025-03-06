<aside class="col-lg-3 @if($shopSetting->sidebar_position == "sx") sidebar @else right-sidebar @endif sidebar-fixed sidebar-toggle-remain shop-sidebar sticky-sidebar-wrapper @if(env("PROJECT_NAME") == "Manega") closed @endif">
    <div class="sidebar-overlay"></div>
    <a class="sidebar-close" href="#"><i class="fas fa-times"></i></a>
    <div class="sidebar-content">
        <div class="pin-wrapper">
            <div class="sticky-sidebar" data-sticky-options="{'top': 10}" style="border-bottom: 0px none rgb(102, 102, 102); width: 225px;">
                <div class="filter-actions mb-4">
                    <a href="#" class="sidebar-toggle-btn toggle-remain btn btn-icon-right btn-rounded" @if($website->btn_background) style="background-color: {{ $website->btn_background }}; @if($website->btn_txt_color) color: {{ $website->btn_txt_color }}; @endif" @endif>{{ @$labels['shop-filtri'] }}</a>
                </div>
                <br>

                @if($shopSetting->show_search_in_list == 1)
                    @include("common.pluginProducts.inc.search")
                @endif

                <div class="widget widget-collapsible">
                    <h3 class="widget-title">{{ @$labels['shop-varie-categorie'] }}<span class="toggle-btn"></span></h3>

                    @if($categories)
                        <ul class="widget-body filter-items search-ul"> <!-- search-ul -->

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
                                        <li class="with-ul">
                                            <a href="{{ route("pluginProducts.".\App::getLocale(), [$categoryItem->slug]) }}">{{ $categoryItem->name }} ({{ $tot }})<i class="fas fa-chevron-down"></i></a>
                                            <ul style="display: block">
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
                                                                <ul>
                                                                    @foreach($figlio->figli_2 as $figli2)
                                                                        @if($figli2->count > 0)
                                                                            <li>
                                                                                <a href="{{ route("pluginProducts.".\App::getLocale(), [$figli2->slug]) }}">
                                                                                    @if($figli2->id == @$category->id)
                                                                                        <strong> {{ $figli2->name }} ({{ $figli2->count }})</strong>
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
                                                                                                            <strong> {{ $figli3->name }} ({{ $figli3->count }}) </strong>
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
                    @endif

                </div>

                <div id="box_brands_filters">
                    @if(count($brands) && $plugin->show_brands_sidebar == 1)
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">{{ @$labels['shop-brand'] }}<span class="toggle-btn"></span></h3>
                            @if($brands)
                                <ul class="widget-body filter-items search-ul">
                                    @foreach($brands as $key => $brandName)
                                        <?php
                                        $checked_id = null;
                                        if(request()->has('brands_check')){
                                            $checked_id = request()->get('brands_check');
                                        }
                                        ?>

                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input onclick="filters_check('brands_check');" type="checkbox" class="custom-control-input brands_check" id="check-brand-<?php echo $key;?>" name="brands_check[]" value="{{ $key }}" @if($checked_id == $key) checked @endif>
                                                <label class="custom-control-label" for="check-brand-<?php echo $key;?>">{{ $brandName }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                </div>

                @if($prices && $plugin->show_prices_sidebar == 1)
                    <?php
                    $symbol = "&euro;";
                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                        $symbol = "&#36;";
                    }
                    if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                        $symbol = "&euro;";
                    }
                    ?>
                    <div id="box_prices_filters">
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Filtra per prezzo<span class="toggle-btn"></span></h3>
                            <input type="range" class="custom-range" step="1" min="{{ round(reset($prices),2) }}" max="{{ round(end($prices),2) }}" id="myRange" value="{{ round(end($prices),2) }}">
                            <div id="resultRange" class="mb-4 mt-3 small">Prezzo massimo: {{ round(end($prices),2) }} {!! $symbol !!} </div>
                            <a href="javascript:apply_price_max()" class="btn btn-block btn-xs">Applica filtro prezzo</a>
                        </div>
                    </div>
                @endif

                @if($category)
                    <div id="box_attributes_filters">
                        @if(count($attributes_v) && $plugin->show_attributes_sidebar == 1)
                            @foreach($attributes_v as $attribute_id => $options)
                                <?php
                                $item_attribute = \App\Models\ShopAttributes::find($attribute_id);
                                ?>
                                @if($item_attribute)
                                    @if(count($options))
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title">{{ $item_attribute->name }}<span class="toggle-btn"></span></h3>
                                            <ul class="widget-body filter-items">
                                                @foreach($options as $option_id => $option_value)
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input onclick="filters_check('options_check');" type="checkbox" class="custom-control-input options_check" id="check-option-<?php echo $option_id;?>" name="options_check[]" value="{{ $option_id }}">
                                                            <label class="custom-control-label" for="check-option-<?php echo $option_id;?>">{{ $option_value }}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <div id="box_tags_filters">
                        @if(count($tags) && $plugin->show_tags == 1)
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">{{ @$labels['shop-varie-tag'] }}<span class="toggle-btn"></span></h3>
                                @if($tags)
                                    <ul class="widget-body filter-items search-ul">
                                        @foreach($tags as $k=>$tag)
                                            @if(trim($tag) != "")
                                                <?php
                                                $checked_tag = "";
                                                if(request()->has('tags_check')){
                                                    $checked_tag = request()->get('tags_check');
                                                }
                                                ?>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input onclick="filters_check('tags_check');" type="checkbox" class="custom-control-input tags_check" id="check-tag-<?php echo $k;?>" name="tags_check[]" value="{{ $tag }}" @if($checked_tag == $tag) checked @endif>
                                                        <label class="custom-control-label" for="check-tag-<?php echo $k;?>">{{ $tag }}</label>
                                                    </div>
                                                <!--<a href="{{ route("pluginProductsTags.".\App::getLocale(), $tag) }}">{{ $tag }} </a>-->
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                    </div>

                @endif

            </div>
        </div>
    </div>
</aside>
