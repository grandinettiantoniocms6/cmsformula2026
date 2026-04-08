@extends(backpack_view('blank'))

@section('header')
    <h3 class="page-title mb-0">Import/Export</h3>
@endsection


@section('content')
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if(count($errors) > 0)
        <ul class="alert alert-danger list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="row gutter-3">
        @if(env("PROJECT_NAME") != "Maison-Flaneur")
        <div class="col-sm-6">
            <div class="card h-100 shadow-none">
                <div class="card-header bg-light font-weight-bold">Export</div>
                <div class="card-body">
                    <form method="post" action="{{ route('pluginProducts.export') }}" class="position-relative">
                        {{ csrf_field() }}

                        <div class="form-loader" hidden>
                            <div class="upload-progress-wrapper">
                                <div class="progress upload-progress">
                                    <div class="progress-bar upload-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
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

                        <button class="btn btn-dark btn-block" type="submit">Esporta</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <div class="col-sm-6">
            <div class="card h-100 shadow-none">
                <div class="card-header bg-light font-weight-bold">Import</div>
                <div class="card-body">

                    <?php
                    $url = route('pluginProducts.import');
                    if(env("PROJECT_NAME") == "Maison-Flaneur"){
                        $url = route('pluginProducts.import_maison');
                    }
                    ?>
                    <form method="post" action="{{ $url }}" enctype="multipart/form-data" class="position-relative" id="form-import">
                        {{ csrf_field() }}

                        <div class="form-loader" hidden>
                            <div class="upload-progress-wrapper">
                                <div class="progress upload-progress">
                                    <div class="progress-bar upload-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="form-control form-control-file invisible" id="file">
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

                        <button type="submit" name="submit" class="btn btn-dark btn-block"><span>Carica</span></button>
                    </form>
                </div>
            </div>
        </div>

        @if(env('IMPORT_SPECIAL') == 1)
        <div class="col-sm-12 mt-4">
            <div class="card h-100 shadow-none">
                <div class="card-header bg-light font-weight-bold">Import SPECIAL</div>
                <div class="card-body">

                    <?php $url = route('pluginProducts.importSpecialMapping'); ?>

                    <form method="post" action="{{ $url }}" enctype="multipart/form-data" class="position-relative" id="form-import-special">
                        {{ csrf_field() }}

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif


                        <div class="form-loader" hidden>
                            <div class="upload-progress-wrapper">
                                <div class="progress upload-progress">
                                    <div class="progress-bar upload-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="file_special" class="form-control form-control-file invisible" id="file-special" value="{{ old('file') }}">
                                <label class="custom-file-label" for="file-special">Scegli file (csv con separatore ; oppure xls)</label>
                            </div>
                        </div>

                        <?php $configs = \App\Models\PluginProductImport::get(); ?>

                        <div class="form-group">
                            <label>Configurazioni</label>
                            <select class="custom-select" name="config_id" id="config_id">
                                <option value="0">Nuova Configurazione</option>
                                @if(count($configs))
                                    @foreach($configs as $config)
                                        <option value="{{ $config->id }}" @if($config->id == \request()->get("id")) selected @endif>{{ $config->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        @if(count($configs))
                        <button type="submit" name="submit" value="view" id="view_config" class="btn btn-light btn-block" style="display: none;"><span>Vedi configurazione</span></button>
                        @endif
                        <button type="submit" name="submit" value="load" class="btn btn-dark btn-block"><span>Importa</span></button>
                    </form>

                    <?php $postImportUrl = route('pluginProducts.importSpecialPostImportActions'); ?>
                    <form method="post" action="{{ $postImportUrl }}" class="position-relative mt-4 p-3 border rounded bg-light">
                        {{ csrf_field() }}
                        <h6 class="mb-2">Fase successiva post-import</h6>
                        <p class="mb-3">Dopo ogni import file, esegui queste operazioni per aggiornare gli indici.</p>

                        <div class="form-group mb-2">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="runProductsSearchPost" name="run_products_search" value="1">
                                <label class="custom-control-label" for="runProductsSearchPost">Aggiorna indice prodotti (`set:products_search`)</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="runProductsCategoriesSearchPost" name="run_products_categories_search" value="1">
                                <label class="custom-control-label" for="runProductsCategoriesSearchPost">Aggiorna indice categorie (`set:products_categories_search`)</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-dark btn-block"><span>Esegui operazioni post-import</span></button>
                    </form>

                    @if(\request()->has('id'))
                        <?php
                           $url = route('pluginProducts.importSpecialMappingSave');
                           $pluginImport = \App\Models\PluginProductImport::find(\request()->get('id'));
                           $v_mapping = json_decode($pluginImport->mapping, true);

                           $fields = config('cmsformula.fields_import_special');
                           $fields = array_combine($fields, $fields);
                           ?>

                        <form method="post" action="{{ $url }}" enctype="multipart/form-data" class="position-relative mt-4">
                             {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $pluginImport->id }}">

                            <div class="form-group">
                                <label>Nome configurazione</label>
                                <input type="text" class="form-control" name="name" value="{{ $pluginImport->name }}">
                            </div>

                            <div class="form-group">
                                <label>Nome attributo 1</label>
                                <input type="text" class="form-control" name="name_attribute_1" value="{{ @$pluginImport->name_attribute_1 }}">
                            </div>

                            <div class="form-group">
                                <label>Nome attributo 2</label>
                                <input type="text" class="form-control" name="name_attribute_2" value="{{ @$pluginImport->name_attribute_2 }}">
                            </div>

                            @if($v_mapping)
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-error">
                                        <strong>{!! $message !!}</strong>
                                    </div>
                                @endif

                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nome colonna</th>
                                            <th>Nome campo DB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      $fields_labels = config('cmsformula.fields_import_special_labels');
                                    ?>
                                    @foreach($v_mapping as $key=>$value)

                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>
                                                <select class="form-control" name="mapping[{{ $key }}]">
                                                    <option value=""></option>
                                                    @foreach($fields as $k=>$field)
                                                        <?php
                                                        if(trim($field) == "category"){
                                                            $field = "category* (CASO 1: string, CASO 2: string,string,string)";
                                                        }
                                                        if(trim($field) == "images"){
                                                            $field = "images (CASO 1: string, CASO 2: string,string,string)";
                                                        }
                                                        if(trim($field) == "sku"){
                                                            $field = "sku*";
                                                        }
                                                        if(trim($field) == "name"){
                                                            $field = "name*";
                                                        }
                                                        if(trim($field) == "price"){
                                                            $field = "price*";
                                                        }
                                                        if(trim($field) == "qty"){
                                                            $field = "qty (integer, se non associata mette di default 1000)";
                                                        }
                                                        if(trim($field) == "tax"){
                                                            $field = "tax (integer, se non associata mette di default 22%)";
                                                        }
                                                        if(trim($field) == "is_active"){
                                                            $field = "is_active (integer, 0-1, se non associata mette 1 in creazione prodotto)";
                                                        }
                                                        if(trim($field) == "options_1"){
                                                            $field = "options_1 (string, opzioni per l'attributo 1)";
                                                        }
                                                        if(trim($field) == "options_2"){
                                                            $field = "options_2 (string, opzioni per l'attributo 2)";
                                                        }
                                                        ?>
                                                        <option value="{{ $k }}"
                                                            {{ old("mapping.$key") == $k || $value == $k ? 'selected' : '' }}>
                                                            {{ $field }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <button type="submit" name="submit" class="btn btn-dark btn-block"><span>Salva</span></button>

                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" type="text/css" href="{{ url("css/admin.css") }}">
    <style>
        .upload-progress-wrapper {
            padding: .25rem 0 .75rem;
        }

        .upload-progress {
            height: 1.25rem;
            background: #e9ecef;
        }

        .upload-progress-bar {
            font-size: .75rem;
            font-weight: 600;
            line-height: 1.25rem;
            transition: width .2s ease;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            bsCustomFileInput.init();
        });

        $("#config_id").change(function (){
            var value = $(this).val();
            if(value != 0){
                $("#view_config").show();
            }else{
                $("#view_config").hide();
            }
        });

        jQuery('form').each(function(){
            var id = jQuery(this).attr('id');
            if (!id) {
                return;
            }

            var $form = jQuery('#' + id);
            var $loader = $form.find('.form-loader');
            var $progressBar = $form.find('.upload-progress-bar');

            function updateProgress(percentComplete) {
                var safePercent = Number.isFinite(percentComplete) ? Math.max(0, Math.min(100, Math.round(percentComplete))) : 0;
                $progressBar
                    .css('width', safePercent + '%')
                    .attr('aria-valuenow', safePercent)
                    .text(safePercent + '%');
            }

            jQuery('#'+id).ajaxForm({
                beforeSend: function() {
                    updateProgress(0);
                    $loader.attr('hidden', false);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    updateProgress(percentComplete);
                    $loader.attr('hidden', false);
                },
                error: function (response, status, e) {
                    var message = '';

                    if (status === "error" && response.responseJSON && response.responseJSON.message) {
                        if (response.responseJSON.message === "validation.required"  ) {
                            message = 'Campo File obbligatorio';
                        } else {
                            message = 'Nessun messaggio disponibile';
                        }

                        jQuery('#'+id).prepend('<div class="alert alert-danger py-2">' + message +'</div>');
                    }

                    updateProgress(0);
                    $loader.attr('hidden', true);
                },
                success: function (data) {
                    if(data.url){
                        window.location.href = data.url;
                    }else{
                        console.log('success', data);
                        updateProgress(100);
                        setTimeout(function () {
                            updateProgress(0);
                            $loader.attr('hidden', true);
                        }, 400);
                        jQuery('#'+id).find('input[type="file"]').val('');
                        jQuery('#'+id).prepend('<div class="alert alert-success py-2">File caricato con successo</div>');
                    }

                }
            });
        });
    </script>
@endsection
