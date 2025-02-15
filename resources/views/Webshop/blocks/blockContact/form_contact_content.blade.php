<?php
$website = \App\Models\WebsiteSetting::first();

echo "<div class='wow animate__fadeInUp section-field col-md-$col'>";

switch ($type){
case "text_free":
    if ($url_pagina){
        $lang = \App::getLocale();
        $url_pagina = trim($url_pagina);
        $contenuto_pagina = "";
        $page = \App\Models\Page::whereRaw("slug LIKE '%\"$lang\":\"$url_pagina\"%'")->first();
        if($page){
            $block = \App\Models\PageBlock::where("page_id", $page->id)->where("position", "content")->first();
            if($block){
                $content = \App\Models\BlockHtml::where("id", $block->obj_id)->first();
                if($content){
                    $contenuto_pagina = $content->content;
                }
            }
        }
        echo '<div class="modal" id="text_free_'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                '.$contenuto_pagina.'
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>';

        echo "<p><a href='#' data-bs-toggle='modal' data-target='#text_free_$id'>$title{$required_label}</a></p>";
    }else{
        echo "<p>$title{$required_label}</p>";
    }
    break;
case "text":
    $label_iubenda_first_name = "";
    if($field == "nome" || $field == "name"){
        $label_iubenda_first_name = "data-cons-subject='first_name'";
    }

    $label_iubenda_last_name = "";
    if($field == "cognome" || $field == "surname"){
        $label_iubenda_last_name = "data-cons-subject='last_name'";
    }

    echo "<div class='form-group'>
            <label class='form-label'>$title{$required_label}</label>
            <input type='$type' class='form-control' placeholder='$title{$required_label}' name='$field' $required $label_iubenda_first_name $label_iubenda_last_name>
         </div>";
    break;
case "file":
    echo "<div class='form-group'>
            <label for='files' class='form-check-label'>$title{$required_label}</label>
            <input type='$type' class='form-control' id='files' name='file' $required>
         </div>";
    break;
case "email":
    echo "<div class='form-group'>
            <label class='form-label'>$title{$required_label}</label>
            <input type='$type' class='form-control' placeholder='$title{$required_label}' name='email' $required data-cons-subject='email'>
          </div>";
    break;
case "textarea":
    echo "<div class='form-group'>
            <label class='form-label'>$title{$required_label}</label>
            <textarea class='form-control' placeholder='$title{$required_label}' name='$field' $required></textarea>
          </div>";
    break;
case "checkbox":
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
    $classCheck = "custom-checkbox";

    if ($url_pagina){
        $contenuto_pagina = "";

        if(is_numeric(strpos($url_pagina, "https"))){
            echo "<div class='mb-2 form-group form-check $classCheck'>
                <input type='checkbox' name='$field' value='1' class='form-check-input' id='bc_privacy_control_$id' $required data-cons-preference='$field'>
                <label class='form-check-label' for='bc_privacy_control_$id'><a class='iubenda-nostyle no-brand iubenda-noiframe iubenda-embed iubenda-noiframe' href='$url_pagina' target='_blank'>$title</a></label>
              </div>";

        }else{
            echo "<div class='mb-2 form-group form-check $classCheck'>
                <input type='checkbox' name='$field' value='1' class='form-check-input' id='bc_privacy_control_$id' $required data-cons-preference='$field'>
                <label class='form-check-label' for='bc_privacy_control_$id'><a href='#' data-bs-toggle='modal' data-target='#checkbox_$id'>$title</a></label>
            </div>";
        }

        $lang = \App::getLocale();
        $url_pagina = trim($url_pagina);
        $page = \App\Models\Page::whereRaw("slug LIKE '%\"$lang\":\"$url_pagina\"%'")->first();
        if($page){
            $block = \App\Models\PageBlock::where("page_id", $page->id)->where("position", "content")->first();
            if($block){
                $content = \App\Models\BlockHtml::where("id", $block->obj_id)->first();
                if($content){
                    $contenuto_pagina = $content->content;
                }
            }
        }

        echo '<div class="modal" id="checkbox_'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                '.$contenuto_pagina.'
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>';

    } else {
        echo "<div class='mb-2 form-group form-check'><input type='checkbox' name='$field' value='1' class='form-check-input' id='check_$id' $required data-cons-preference='$field'> <label class='form-check-label' for='check_$id'>$title</label></div>";
    }
    break;
case "select":
    $values = explode(",", $value['values']);
    if(count($values)){
        echo "<div class='form-group'><label class='form-label'>$title{$required_label}</label>";
        echo "<select class='form-select' name='$field' $required>";
        foreach ($values as $opt){
            echo "<option value='$opt'>$opt</option>";
        }
        echo "</select>";
        echo "</div>";
    }

    break;
case "button":
?>
<div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
    {!! app('captcha')->display() !!}
    @if ($errors->has('g-recaptcha-response'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
    @endif
</div>
<?php
    $key = config('app.recaptcha_key');
    echo "<button class='button btn g-recaptcha' data-sitekey='$key' data-callback='onSubmit' data-action='submit' style='background-color: {$website->btn_background}; border-color: {$website->btn_colorborder};' type='submit' id='submit_button' > <span style='color: {$website->btn_txt_color}'> $title </span></button>";
break;
case "attributes":
    if($plugin->show_attributes_form_contact == 1){
        if(count($itemProduct->related)){
            echo "<label>$title{$required_label}</label>";
            foreach($itemProduct->related as $related){
                if($related->product){
                    $name = $related->product->name;
                    echo "<div class='mb-2 form-group form-check'><input type='checkbox' name='accessori[]' value='{$name}' class='form-check-input' id='ck_{$related->product->id}'><label class='form-check-label' for='ck_{$related->product->id}'>{$name}</label></div>";
                }
            }
        }
    }
    break;
}
echo "</div>";
