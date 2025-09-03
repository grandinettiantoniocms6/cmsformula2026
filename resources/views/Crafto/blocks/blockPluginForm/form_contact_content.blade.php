<?php
$website = \App\Models\WebsiteSetting::first();

echo "<div class='col-md-$col'>";

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
    //$placeholder = "";
    // placeholder='$title{$required_label}'
    $label_iubenda_first_name = "";
    if($field == "nome" || $field == "name"){
        $label_iubenda_first_name = "data-cons-subject='first_name'";
    }

    $label_iubenda_last_name = "";
    if($field == "cognome" || $field == "surname"){
        $label_iubenda_last_name = "data-cons-subject='last_name'";
    }
    echo "
    <label class='form-label fw-600 text-dark-gray mb-0'>$title{$required_label}</label>
    <div class='position-relative form-group mb-25px'>
        <input class='ps-0 border-radius-0px border-color-extra-medium-gray bg-transparent form-control' type='$type' name='$field' $label_iubenda_first_name $label_iubenda_last_name placeholder='$placeholder' $required />
    </div>
    ";
    break;
case "file":
    echo "<div class='form-group'>
            <label for='files' class='form-label'>$title{$required_label}</label>
            <input type='$type' class='form-control' id='files' name='file' $required>
         </div>";
    break;
case "email":
    echo "
    <label class='form-label fw-600 text-dark-gray mb-0'>$title{$required_label}</label>
    <div class='position-relative form-group mb-25px'>
        <input class='ps-0 border-radius-0px border-color-extra-medium-gray bg-transparent form-control' type='$type' name='email' $required data-cons-subject='email' placeholder='$placeholder' />
    </div>
    ";
    break;
case "textarea":
    echo "
    <label class='form-label fw-600 text-dark-gray mb-0'>$title{$required_label}</label>
        <div class='position-relative form-group form-textarea mb-0'>
            <textarea class='ps-0 border-radius-0px border-color-extra-medium-gray bg-transparent form-control' name='$field' placeholder='$placeholder' $required></textarea>
        </div>
    ";
    break;
// aggiunta Webisland campo data e ora //
case "date":
        echo "<div class='form-group'>
            <label class='form-label'>$title{$required_label}</label>
            <input type='$type' class='form-control' name='$field' $required>
          </div>";
        break;
case "time":
    echo "<div class='form-group'>
        <label class='form-label'>$title{$required_label}</label>
        <input type='$type' class='form-control' name='$field' $required>
      </div>";
    break;
// aggiunta Webisland campo data//

case "checkbox":
// Con Iubenda o senza //
    $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
    $classCheck = "";

    if ($url_pagina){
        $contenuto_pagina = "";

        if(is_numeric(strpos($url_pagina, "https"))){

            if(is_numeric(strpos($url_pagina, "https://www.iubenda.com"))){
                 echo "
                 <div class='position-relative terms-condition-box text-start d-inline-block mb-40px mt-10px form-check $classCheck'>
                    <label class='form-check-label' for='pfc_privacy_control_$id'>
                        <input type='checkbox' name='$field' value='1' class='check-box' id='pfc_privacy_control_$id' $required data-cons-preference='$field'>
                        <span class='box fs-14'>
                            <a href='$url_pagina' class='iubenda-nostyle no-brand iubenda-noiframe iubenda-embed iubenda-noiframe' target='_blank'>$title</a>
                        </span>
                    </label>
                </div>
                <script>(function (w,d) {var loader = function () {var s = d.createElement('script'), tag = d.getElementsByTagName('script')[0]; s.src='https://cdn.iubenda.com/iubenda.js'; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener('load', loader, false);}else if(w.attachEvent){w.attachEvent('onload', loader);}else{w.onload = loader;}})(window, document);</script>";

                 } else {

                echo "
                <div class='position-relative terms-condition-box text-start d-inline-block mb-20px mt-20px form-check $classCheck'>
                    <label class='form-check-label' for='pfc_privacy_control_$id'>
                        <input type='checkbox' name='$field' value='1' class='terms-condition check-box align-middle form-check-input' id='pfc_privacy_control_$id' $required data-cons-preference='$field'>
                        <span class='box fs-14'>
                            <a class='iubenda-nostyle no-brand iubenda-noiframe iubenda-embed iubenda-noiframe' href='$url_pagina' target='_blank'>$title</a>
                        </span>
                    </label>
                </div>

                ";
            }
        }else{

            echo "
            <div class='position-relative terms-condition-box text-start d-inline-block mb-20px mt-20px form-check $classCheck'>
                <label class='form-check-label' for='pfc_privacy_control_$id'>
                    <input type='checkbox' name='$field' value='1' class='terms-condition check-box align-middle form-check-input' id='pfc_privacy_control_$id' $required data-cons-preference='$field'>
                        <span class='box fs-14'>
                            <a href='#' data-bs-toggle='modal' data-bs-target='#checkbox_$id'>$title</a>
                        </span>
                </label>
            </div>
            ";

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
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
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
        echo "<div class='form-group form-check mb-2'><input type='checkbox' name='$field' value='1' class='form-check-input' id='check_$id' $required data-cons-preference='$field'> <label class='form-check-label' for='check_$id'>$title</label></div>";
    }
    break;
case "select":
    $values = explode(",", $value['values']);
    if(count($values)){
        echo "<div class='position-relative form-group mb-25px'>
                <label class='form-label fw-600 text-dark-gray mb-0'>$title{$required_label}</label>";

        echo "<select class='ps-0 border-radius-0px border-color-extra-medium-gray bg-transparent form-control form-select' name='$field' $required>";
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
<br><div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
    {!! app('captcha')->display() !!}
@if ($errors->has('g-recaptcha-response'))
    <span class="help-block text-danger">
        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
    @endif
</div> -->

    <?php
    $key = config('app.recaptcha_key');
    echo "<button class='button btn btn-medium btn-dark-gray btn-box-shadow btn-round-edge primary-font mb-20px mt-20px submit g-recaptcha' data-sitekey='$key' data-callback='onSubmit' data-action='submit' style='background-color: {$website->btn_background}; border-color: {$website->btn_colorborder};' type='submit' id='submit_button' > <span style='color: {$website->btn_txt_color}'> $title </span></button>";
    break;
case "attributes":
    if($plugin->show_attributes_form_contact == 1){
        if(count($itemProduct->related)){
            echo "<label class='form-label'>$title{$required_label}</label>";
            foreach($itemProduct->related as $related){
                if($related->product){
                    $name = $related->product->name;
                    echo "<div class='form-group form-check mb-2'><input type='checkbox' name='accessori[]' value='{$name}' class='form-check-input' id='ck_{$related->product->id}'><label class='form-check-label' for='ck_{$related->product->id}'>{$name}</label></div>";
                }
            }
        }
    }
    break;
}
echo "</div>";
