<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
@if(count($tags) && $plugin->show_tags == 1)
    <div class="widget widget-collapsible">
        <h3 class="widget-title">{{ @$labels['shop-varie-tag'] }}<span class="toggle-btn"></span></h3>
        @if($tags)
            <ul class="widget-body filter-items search-ul">
                @foreach($tags as $tag)
                    @if(trim($tag) != "")
                        <li>
                            <div class="custom-control custom-checkbox">
                                <input onclick="filters_check('tags_check');" type="checkbox" class="custom-control-input tags_check" id="check-tag-<?php echo $tag;?>" name="tags_check[]" value="{{ $tag }}" @if(in_array($tag, $v_checked)) checked @endif>
                                <label class="custom-control-label" for="check-tag-<?php echo $tag;?>">{{ $tag }}</label>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
@endif

