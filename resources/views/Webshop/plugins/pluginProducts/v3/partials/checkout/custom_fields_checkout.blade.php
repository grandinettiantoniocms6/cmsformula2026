@if($shopSetting->custom_fields_checkout)
    <?php
    if(is_array($shopSetting->custom_fields_checkout)){
        $fields = $shopSetting->custom_fields_checkout;
    }else{
        $fields = json_decode($shopSetting->custom_fields_checkout, true);
    }

    ?>
    @if($fields)
        <?php $i = 0;?>
        @foreach($fields as $value)
            <?php
            if($value['type'] != $choose){
                continue;
            }

            $required = $value['required'] == 1 ? "required" : "";
            $field = trim(\Str::slug($value['title'], '_'));
            $title = $value['title'];
            $type = "text";
            $col = $value['col'];
            $required_label = $value['required'] == 1 ? "*" : "";
            $url_pagina = null;
            $id = $i;
            $placeholder = "";
            if(key_exists('placeholder', $value)){
                $placeholder = $value['placeholder'];
            }

            if(trim($title) == ""){
                continue;
            }

            echo "<div class='form-group'><label class='form-label'>$title{$required_label}</label><input type='$type' class='form-control custom_fields_checkout' id='$field' placeholder='{$placeholder}' name='custom_fields[$field]' $required></div>";
            $i++;?>
        @endforeach
    @endif


@endif
