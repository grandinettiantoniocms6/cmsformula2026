@if($plugin->show_form_contact == 1)
    <?php
    $item = $formContact;
    $title = $item->title_form;
    $subtitle = $item->subtitle_form;
    $fields = $item->content;
    ?>
    <div class="container" id="form_contact">
        <h2 class="title justify-content-center">{{ $title }}</h2>
        <p>{{ $subtitle }}</p>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div id="register-form" class="register-form">

                    @if(session()->has('messageContact'))
                        <div class="alert alert-success">
                            {{ session()->get('messageContact') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{$errors->first()}}
                        </div>
                    @endif

                    @if($item)
                        <form method="post" action="{{ route("pluginProducts.contact_form.send.".\App::getLocale()) }}" >
                            @honeypot

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
    </div>
@endif
