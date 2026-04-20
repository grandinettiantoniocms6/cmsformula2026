<?php

$form = \App\Models\PluginForms::find($item->form_id); ?>
@if($form)
        <?php
        $title = $form->title_form;
        $subtitle = $form->subtitle_form;
        $content = $form->content;
        if(is_array($form->content)){
            $fields = $form->content;
        }else{
            $fields = json_decode($form->content, true);
        }
        ?>
    <section id="formpro-{{ $item->form_id }}" class="tj-contact-section-2" data-anime='{"translateX": [-50, 0], "opacity": [0,1], "duration": 800, "staggervalue": 300, "easing": "easeOutQuad" }'>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-form wow fadeInUp" data-wow-delay=".1s">
                        <h3 class="title">{{ $title }}</h3>
                            <p>{{ $subtitle }}</p>

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
                                    <form method="post" action="{{ route('blockPluginForm.contact_form.send') }}" enctype="multipart/form-data" id="form" class="contact-form">
                                    @honeypot

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
                                                    @include('Bexo.blocks.blockPluginForm.form_contact_content')
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
    </section>
@endif

@push('custom_scripts')
    <script>
        $( "div.alert-success" ).fadeIn( 300 ).delay( 5000 ).fadeOut( 500 );
    </script>
@endpush
