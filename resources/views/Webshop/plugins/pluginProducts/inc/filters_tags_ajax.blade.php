<?php $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray(); ?>

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

                        $checked = "";
                        $v_temp = explode(",", $checked_tag);

                        if(count($v_temp) > 1){
                            foreach ($v_temp as $t){
                                if(trim($tag) == trim($t)){
                                    $checked = "checked";
                                }
                            }
                        }else{
                            if(trim($tag) == trim($checked_tag)){
                                $checked = "checked";
                            }
                        }
                        ?>
                        <div class="tag-element">
                            <input onclick="filters_check('tags_check');" type="checkbox" class="btn-check tags_check" id="check-tag-<?php echo $k;?>" name="tags_check[]" value="{{ $tag }}" <?php echo $checked; ?>>
                            <label class="btn btn-sm btn-outline-primary" for="check-tag-<?php echo $k;?>">{{ $tag }}</label>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endif

