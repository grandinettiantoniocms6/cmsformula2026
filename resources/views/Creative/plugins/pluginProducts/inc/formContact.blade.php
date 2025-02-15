@if($plugin->show_form_contact == 1)
<?php
$item = $formContact;
$title = $item->title_form;
$subtitle = $item->subtitle_form;
$content = json_decode($item->content, true);
$new_fields = [];
$fields = $content;
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
    <div class="container" id="form_contact">
        <div class="title mt-30 mb-30 text-center">
           <br><br><h3>{{ $title }}</h3>
            <p class="">{{ $subtitle }}</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div id="register-form" class="register-form">

                    @if(session()->has('messageContact'))
                        <div class="alert alert-success" style="color:white;">
                            {{ session()->get('messageContact') }}
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <div class="alert alert-success" style="color:white;">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{$errors->first()}}
                        </div>
                    @endif

                    @if($item)
                        <form method="post" action="{{ route("pluginProducts.contact_form.send.".\App::getLocale()) }}" >
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" value="{{ $itemProduct->id }}">
                            <div class="container-fluid">
                                <div class="row">
                                    @if($fields)
                                        <?php $i = 0;?>
                                        @foreach($fields as $value)
                                            <?php
                                            $required = $value['required'] == 1 ? "required" : "";
                                            $field = \Str::slug($value['title'], '_');
                                            $title = $value['title'];
                                            $type = $value['type'];
                                            $col = $value['col'];
                                            $required_label = $value['required'] == 1 ? "*" : "";
                                            $url_pagina = $value['url_pagina'];
                                            $id = $i;
                                            ?>
                                            @include("common.form_contact_content")
                                            <?php $i++;?>
                                        @endforeach
                                    @endif
                                 </div>
                            </div>
                        </form>
                @endif
            </div>
        </div>
    </div><!-- end contact-form -->
@endif
