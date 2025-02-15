@if(count($attributes_v) && $plugin->show_attributes_sidebar == 1)
    @foreach($attributes_v as $attribute_id => $options)
        <?php $item_attribute = \App\Models\ShopAttributes::find($attribute_id); ?>
        @if($item_attribute)
            @if(count($options))
                <div class="widget widget-collapsible">
                    <h3 class="widget-title">{{ $item_attribute->name }}<span class="toggle-btn"></span></h3>
                    <div class="widget-body">
                        <ul>
                            @foreach($options as $option_id => $option_value)
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        <input onclick="filters_check('options_check');" type="checkbox" class="custom-control-input options_check" id="check-option-<?php echo $option_id;?>" name="options_check[]" value="{{ $option_id }}" @if(in_array($option_id, $v_checked)) checked @endif>
                                        <label class="custom-control-label" for="check-option-<?php echo $option_id;?>">{{ $option_value }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
@endif


