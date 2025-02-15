<?php
$form = \App\Models\PluginForms::find($item->form_id);
?>
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
<section class="white-bg page-section-ptb o-hidden">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section-title text-center">
                    <h2 class="title-effect">{{ $title }}</h2>
                    <p class="">{{ $subtitle }}</p>
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

                    @if($form)
                    <form method="post" action="{{ route('blockPluginForm.contact_form.send') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <input type="hidden" name="form_id" value="{{ $form->id }}">
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
@endif

