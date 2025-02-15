<?php
$form = \App\Models\PluginForms::find($item->form_id); ?>
@if($form)
<?php
$title = $form->title_form;
$subtitle = $form->subtitle_form;
$content = $form->content;
$fields = json_decode($content, true);

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
<div id="formpro-{{ $item->form_id }}" class="contact-section-four mt-120 lg-mt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-40">
                    <h2 class="title-effect">{{ $title }}</h2>
                    <p class="">{{ $subtitle }}</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-11 m-auto">
                    <div class="form-style-one">
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

                            @if($form)
                                    <form method="post" action="{{ route('blockPluginForm.contact_form.send') }}" enctype="multipart/form-data" id="form">
                                        @honeypot

                                            <?php
                                            if(\request()->has('product_id')){
                                                $product = \App\Models\PluginProducts::find(\request()->get('product_id'));
                                                if($product){
                                                    echo "<h5>$product->name</h5>";
                                                    echo "<input type='hidden' name='product_id' value='$product->id'>";
                                                }
                                            }
                                            ?>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="form_id" value="{{ $form->id }}">
                                        <div class="row">
                                            @if($fields)
                                                    <?php $i = 0;?>
                                                @foreach($fields as $value)
                                                        <?php
                                                        $required = $value['required'] == 1 ? "required" : "";
                                                        $field = \Str::slug($value['title'], '_');
                                                        $title = $value['title'];
                                                        $type = $value['type'];

                                                        $placeholder = "";
                                                        if(key_exists('placeholder', $value)){
                                                            $placeholder = $value['placeholder'];
                                                        }

                                                        $col = $value['col'];
                                                        $required_label = $value['required'] == 1 ? "*" : "";
                                                        $url_pagina = $value['url_pagina'];
                                                        $id = $i;
                                                        ?>
                                                    @include('Creative.blocks.blockPluginForm.form_contact_content')
                                                        <?php $i++; ?>
                                                @endforeach
                                            @endif
                                        </div>
                                    </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div><!-- end contact-form -->
        </div>
    </div><!-- end container -->
</div>
@endif
@push('custom_scripts')
    <script>
        $( "div.alert-success" ).fadeIn( 300 ).delay( 5000 ).fadeOut( 500 );
    </script>
@endpush
<div class="map-area-one mt-150 mb-90 lg-mt-100 lg-mb-50"></div>
<section class="action-box full-width"></section>
