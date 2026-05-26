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

if(is_array($content[\App::getLocale()])){
    $fields = $content[\App::getLocale()];
}else{
    $fields = json_decode($content[\App::getLocale()], true);
}
?>


<section class="block-contact wow animate__fadeInUp" data-wow-duration=".3s">
    <div class="container">

        <h2 class="title">{{ $title[\App::getLocale()] }}</h2>
        <h5 class="subtitle">{{ $subtitle[\App::getLocale()] }}</h5>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-body">

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
                        <form method="post" action="{{ route('contact_form.send') }}" id="form-{{ $item->id }}" data-crafto-contact-form="1">
                            @honeypot
                            {{ csrf_field() }}
                            <input type="hidden" name="block_contact_id" value="{{ $item->id }}">
                            <div class="row">
                                @if($fields)
                                    <?php $i = 0;?>
                                    @foreach($fields as $value)
                                        <?php
                                        $required = $value['required'] == 1 ? "required" : "";
                                        $field = \Str::slug($value['title'], '_');
                                        $title = $value['title'];

                                        $placeholder = "";
                                        if(key_exists('placeholder', $value)){
                                            $placeholder = $value['placeholder'];
                                        }

                                        $type = $value['type'];
                                        $col = $value['col'];
                                        $required_label = $value['required'] == 1 ? "*" : "";
                                        $url_pagina = $value['url_pagina'];
                                        $id = $i;
                                        ?>
                                            @include('Crafto.blocks.blockContact.form_contact_content')
                                        <?php $i++; ?>
                                    @endforeach
                                @endif
                            </div>
                        </form>
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
