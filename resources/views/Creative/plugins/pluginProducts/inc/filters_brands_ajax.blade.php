@if(count($brands) && $plugin->show_brands_sidebar == 1)
    <div class="widget widget-collapsible">
        <h3 class="widget-title">Brand<span class="toggle-btn"></span></h3>
        @if($brands)
            <ul class="widget-body filter-items search-ul">
                @foreach($brands as $key => $brandName)
                    <?php
                    $checked_id = null;
                    if(request()->has('brands_check')){
                        $checked_id = request()->get('brands_check');
                    }

                    if(count($brands) == 1){
                        $checked_id = $key;
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
