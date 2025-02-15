<?php
$title = json_decode($item->title_form, true);
if($title === null){
    $title = [];
}

$subtitle = json_decode($item->subtitle_form, true);
if($subtitle === null){
    $subtitle = [];
}

$content = json_decode($item->content, true);
if($content === null){
    $content = [];
}


if(!key_exists(\App::getLocale(), $content)){
    $content[\App::getLocale()] = "";
}
if(!key_exists(\App::getLocale(), $title)){
    $title[\App::getLocale()] = "";
}
if(!key_exists(\App::getLocale(), $subtitle)){
    $subtitle[\App::getLocale()] = "";
}

$fields = json_decode($content[\App::getLocale()], true);
$new_fields = [];
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
<section class="page-section-ptb o-hidden">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section-title text-center">
                    <h2 class="title-effect">{{ $title[\App::getLocale()] }}</h2>
                    <p class="">{{ $subtitle[\App::getLocale()] }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div id="register-form" class="register-form">

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{$errors->first()}}
                        </div>
                    @endif

                    @if($item)
                    <form method="post" action="{{ route('contact_form.send') }}">
                        {{ csrf_field() }}
                            <input type="hidden" name="block_contact_id" value="{{ $item->id }}">
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
                                         <?php $i++; ?>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </form>
                      @endif
                </div>
            </div>
        </div><!-- end contact-form -->
    </div><!-- end container -->
</section>
