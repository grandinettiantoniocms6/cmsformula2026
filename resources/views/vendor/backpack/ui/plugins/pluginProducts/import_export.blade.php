@extends(backpack_view('blank'))

@section('content')
    <h3 class="mt-3"><span class="text-capitalize">Import/Export</span></h3>
    <hr>

    <div class="row">
        @if(env("PROJECT_NAME") != "Maison-Flaneur")
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Export</div>
                <div class="card-body">
                    <form method="post" action="{{ route('pluginProducts.export') }}" class="position-relative" id="form-export">
                        {{ csrf_field() }}

                        <div class="form-loader" hidden>
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>

                        <div class="form-group">
                            <select class="custom-select" name="category">
                                <option value="0">Tutti i prodotti</option>
                                @if($categories)
                                    @foreach($categories as $id=>$label)
                                        <option value="{{ $id }}">{{ $label }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <button class="btn btn-primary btn-block" type="submit">Esporta</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">Import</div>
                <div class="card-body">

                    <?php
                    $url = route('pluginProducts.import');
                    if(env("PROJECT_NAME") == "Maison-Flaneur"){
                        $url = route('pluginProducts.import_maison');
                    }
                    ?>
                    <form method="post" action="{{ $url }}" enctype="multipart/form-data" class="position-relative" id="form-import">
                        {{ csrf_field() }}

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-loader" hidden>
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="form-control" id="file">
                                <label class="custom-file-label" for="file">Scegli file</label>
                            </div>
                        </div>
                        @if(env("PROJECT_NAME") == "Maison-Flaneur")
                            <div class="form-group">
                                <h6><strong>* Al cambio collezione ti ricordo di selezionare tutti e 4 i checkbox</strong></h6>

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="svuota">
                                    <label class="custom-control-label" for="customSwitch1">Svuota tutto</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch2" name="edit_dati">
                                    <label class="custom-control-label" for="customSwitch2">Inserisci o Aggiorna dati</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch3" name="edit_foto">
                                    <label class="custom-control-label" for="customSwitch3">Inserisci o Aggiorna foto</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch4" name="edit_correlati">
                                    <label class="custom-control-label" for="customSwitch4">Inserisci o Aggiorna correllati</label>
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch3" name="edit_foto">
                                    <label class="custom-control-label" for="customSwitch3">Inserisci o Aggiorna foto</label>
                                </div>
                            </div>
                        @endif

                        <button type="submit" name="submit" class="btn btn-primary btn-block"><span>Carica</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" type="text/css" href="{{ url("css/admin.css") }}">
@endsection

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            bsCustomFileInput.init();
        });

        //jQuery('form').each(function(){
            //var id = jQuery(this).attr('id');
            var id = "form-import";
            jQuery('#'+id).ajaxForm({
                beforeSend: function() {
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    jQuery('#'+id).find('.form-loader').attr('hidden', false);
                },
                error: function (response, status, e) {
                    jQuery('#'+id).find('.form-loader').attr('hidden', true);
                    jQuery('#'+id).prepend('<div class="alert alert-danger py-2"><strong>Campo File obbligatorio</strong></div>');
                },
                success: function () {
                    console.log('success');
                    jQuery('#'+id).find('.form-loader').attr('hidden', true);
                    jQuery('#'+id).find('input[type="file"]').val('');
                    jQuery('#'+id).prepend('<div class="alert alert-success py-2"><strong>File caricato con successo</strong></div>');
                }
            });
       // });
    </script>
@endsection
