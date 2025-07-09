@if($plugin->show_form_contact == 1)
<?php
$item = $formContact;
$title = $item->title_form;
$subtitle = $item->subtitle_form;
$fields = $item->content;
?>
<section class="block-contact wow animate__fadeInUp" data-wow-duration=".3s" id="block-product-contact">
    <h3 class="title">{{ $title }}</h3>
    <h5 class="subtitle">{{ $subtitle }}</h5>
    <div class="card">
        <div class="card-body">
            @if(session()->has('messageContact'))
                <div class="alert alert-success">{{ session()->get('messageContact') }}</div>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-success">{{ session()->get('message') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif

            @if($item)
                <form method="post" action="{{ route("pluginProducts.contact_form.send.".\App::getLocale()) }}" id="form">
                    @honeypot

                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $itemProduct->id }}">
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
                                @include('Webshop.blocks.blockContact.form_contact_content')
                                <?php $i++;?>
                            @endforeach
                        @endif
                    </div>
                </form>
            @endif
        </div>
    </div>
</section>
@endif
