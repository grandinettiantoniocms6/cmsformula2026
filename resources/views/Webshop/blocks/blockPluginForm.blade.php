<?php
$form = \App\Models\PluginForms::find($item->form_id); ?>
@if($form)
<?php
$title = $form->title_form;
$subtitle = $form->subtitle_form;
$fields = json_decode($form->content, true);
?>
<section id="formpro-{{ $item->form_id }}" class="block-formpro">
    <div class="container">

        <h3 class="title">{{ $title }}</h3>
        <p>{{ $subtitle }}</p>

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

                @if($form)
                    <form method="post" action="{{ route('blockPluginForm.contact_form.send') }}" enctype="multipart/form-data" id="form">
                        @honeypot

                        <?php
                        if(\request()->has('product_id')){
                            $product = \App\Models\PluginProducts::find(\request()->get('product_id'));
                            if($product){
                                echo "<h5>$product->name ($product->sku)</h5>";
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
                                    @include('Webshop.blocks.blockPluginForm.form_contact_content')
                                    <?php $i++; ?>
                                @endforeach
                            @endif
                        </div>
                    </form>
                @endif
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
