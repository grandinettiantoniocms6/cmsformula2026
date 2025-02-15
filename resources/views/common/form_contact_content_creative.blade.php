<?php
$website = \App\Models\WebsiteSetting::first();

echo "<div class='section-field col-md-$col'>";

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
        // New Fancybox Modal by Antonio G.
        echo '<div id="text_free_'.$id.'" style="display:none; width: 50%;" data-height="450">
                '.$contenuto_pagina.'
              </div>';

        echo "<p><a href='#text_free_$id' data-fancybox='#text_free_$id'>$title{$required_label}</a></p>";

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

    echo "<div class='field-widget input-group-meta form-group mb-25'>
            <input type='$type' class='form-control-commons' placeholder='$title{$required_label}' name='$field' $required $label_iubenda_first_name $label_iubenda_last_name>
         </div>";
    break;
case "file":
    echo "<div class='field-widget'>
            <label for='files' class='btn'>$title{$required_label}</label>
            <input type='$type' class='form-control-commons' id='files' name='file' $required>
         </div>";
    break;
case "email":
    echo "<div class='field-widget input-group-meta form-group mb-25'>
            <input type='$type' class='form-control-commons' placeholder='$title{$required_label}' name='email' $required data-cons-subject='email'>
          </div>";
    break;
case "textarea":
    echo "<div class='field-widget input-group-meta form-group mb-35'>
            <textarea class='form-control-commons' placeholder='$title{$required_label}' name='$field' $required></textarea>
          </div>";
    break;
case "checkbox":
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();

    /*$classCheck = "";
    if($adminPlugin->version < 3){
        $classCheck = "custom-checkbox";
    }*/
    $classCheck = "custom-checkbox";

    if ($url_pagina){
        $contenuto_pagina = "";

        if(is_numeric(strpos($url_pagina, "https"))){
            echo "<div class='field-widget'>
                <div class='custom-control $classCheck'>
                    <input type='checkbox' name='$field' value='1' class='custom-control-input' id='customControlAutosizing_$id' $required data-cons-preference='$field'>
                    <label class='custom-control-label' for='customControlAutosizing_$id'><a href='$url_pagina' target='_blank'>$title</a></label>
                </div>
              </div>";

        }else{
            echo "<div class='field-widget'>
                <div class='custom-control $classCheck'>
                    <input type='checkbox' name='$field' value='1' class='custom-control-input' id='customControlAutosizing_$id' $required data-cons-preference='$field'>
                    <label class='custom-control-label' for='customControlAutosizing_$id'><a href='#' data-toggle='modal' data-target='#checkbox_$id'>$title</a></label>
                </div>
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

        /*echo '<div id="checkbox_'.$id.'" data-height="450">
                ' .$contenuto_pagina. '
              </div>';*/

    } else {
        echo "<div class='field-widget'>
            <div class='custom-control custom-checkbox'>
             <input type='checkbox' name='$field' value='1' class='custom-control-input' id='customControlAutosizing_$id' data-cons-preference='$field' $required>
             <label class='custom-control-label' for='customControlAutosizing_$id'>$title</label>
           </div>
          </div>";
    }
    break;

case "select":
    $values = explode(",", $value['values']);
    if(count($values)){
        echo "<label class='mb-10 mt-30'>$title{$required_label}</label><div class='section-field mb-30 input-group-meta form-group mb-25 selectdiv'>";
        echo "<select placeholder='Selezionare una voce' name='$field' required>";
        //echo "<option disabled selected value style='display:none;'>Selezionare una voce</option>";
        echo "<option value=''>Selezionare una voce</option>";
        foreach ($values as $opt){
            echo "<option value='$opt'>$opt</option>";
        }
        echo "</select>";
        echo "</div>";
    }

    break;

case "button":
?>
<!--
if(env('NOCAPTCHA_SITEKEY'))
<br><div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
    {!! app('captcha')->display() !!}
    @if ($errors->has('g-recaptcha-response'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
    @endif
</div>
endif -->

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
                    echo "<br><div class='field-widget'>
                                <div class='custom-control custom-checkbox'>
                                 <input type='checkbox' name='accessori[]' value='{$name}' class='custom-control-input' id='customControlAutosizing_{$related->product->id}'>
                                 <label class='custom-control-label' for='customControlAutosizing_{$related->product->id}'>{$name}</label>
                               </div>
                              </div>";
                }
            }
            echo"<br>";
        }
    }
    break;
}
echo "</div>";

