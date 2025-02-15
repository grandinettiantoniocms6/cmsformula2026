@if($shopSetting->custom_fields_shipping)
    <?php
    $fields = json_decode($shopSetting->custom_fields_shipping, true);
    if($fields){
        foreach ($fields as $k=>$v){
            if(key_exists("ordine", $v)){
                $fields[$v["ordine"]] = $v;
                $new_fields[$v["ordine"]] = $v;
                unset($fields[$k]);
            }
        }
        ksort($new_fields);
        $fields = $new_fields;
    }

    ?>
    @if($fields)
        <?php $i = 0;?>
        @foreach($fields as $value)
            <?php
            $required = $value['required'] == 1 ? "required" : "";
            $field = trim(\Str::slug($value['title'], '_'));
            $title = $value['title'];
            $type = "text";
            $col = $value['col'];
            $required_label = $value['required'] == 1 ? "*" : "";
            $url_pagina = null;
            $id = $i;

            $placeholder = $value['placeholder'];
            //$title{$required_label}

            echo "<div class='form-group'>";
            echo "<label>$title{$required_label}</label><input type='$type' class='form-control custom_fields_shipping' id='$field' placeholder='{$placeholder}' name='custom_fields_shipping[$field]' $required>";
            echo "</div>";
            ?>
            <?php $i++;?>
        @endforeach
    @endif
@endif
