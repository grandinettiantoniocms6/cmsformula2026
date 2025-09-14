@extends(backpack_view('blank'))

@section('header')
    <h3 class="page-title mb-0">Import/Export</h3>
@endsection


@section('content')
    <div class="row gutter-3">
        @if(env("PROJECT_NAME") != "Maison-Flaneur")
        <div class="col-sm-6">
            <div class="card h-100 shadow-none">
                <div class="card-header bg-light font-weight-bold">Export</div>
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

                        <button type="submit" name="submit" class="btn btn-dark btn-block"><span>Carica</span></button>
                    </form>
                </div>
            </div>
        </div>

        @if(env('IMPORT_SPECIAL') == 1)
        <div class="col-sm-12">
            <div class="card h-100 shadow-none">
                <div class="card-header bg-light font-weight-bold">Import SPECIAL</div>
                <div class="card-body">

                    <?php
                    $url = route('pluginProducts.importSpecialMapping');
                    ?>

                    <form method="post" action="{{ $url }}" enctype="multipart/form-data" class="position-relative" id="form-import-special">
                        {{ csrf_field() }}

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif


                        <div class="form-loader" hidden>
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="form-control" id="file-special">
                                <label class="custom-file-label" for="file-special">Scegli file</label>
                            </div>
                        </div>

                        <?php
                            $configs = \App\Models\PluginProductImport::get();
                        ?>

                        <div class="form-group">
                            <label>Configurazioni</label>
                            <select class="form-control" name="config_id">
                                <option value="0">Nuova Configurazione</option>
                                @if(count($configs))
                                    @foreach($configs as $config)
                                        <option value="{{ $config->id }}">{{ $config->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        @if(count($configs))
                        <button type="submit" name="submit" value="view" class="btn btn-light btn-block"><span>Vedi</span></button>
                        @endif
                        <button type="submit" name="submit" value="load" class="btn btn-dark btn-block"><span>Carica</span></button>

                    </form>

                    @if(\request()->has('id'))
                        <?php
                           $url = route('pluginProducts.importSpecialMappingSave');
                           $pluginImport = \App\Models\PluginProductImport::find(\request()->get('id'));
                           $v_mapping = json_decode($pluginImport->mapping, true);

                           $fields = config('cmsformula.fields_import_special');
                           $fields = array_combine($fields, $fields);
                           ?>

                        <hr>
                        <form method="post" action="{{ $url }}" enctype="multipart/form-data" class="position-relative">
                             {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $pluginImport->id }}">

                            <div class="form-group">
                                <label>Nome configurazione</label>
                                <input type="text" class="form-control" name="name" value="{{ $pluginImport->name }}">
                            </div>

                            <div class="form-group">
                                <label>Nome primo attributo da creare</label>
                                <input type="text" class="form-control" name="name_attribute_1" value="{{ @$pluginImport->name_attribute_1 }}">
                            </div>

                            <div class="form-group">
                                <label>Nome secondo attributo da creare</label>
                                <input type="text" class="form-control" name="name_attribute_1" value="{{ @$pluginImport->name_attribute_2 }}">
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
                                                        if(trim($field) == "options_1"){
                                                            $field = "options_1 (string)";
                                                        }
                                                        if(trim($field) == "options_2"){
                                                            $field = "options_2 (string)";
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
                                                        ?>
                                                        <option value="{{ $k }}"
                                                            {{ old("mapping.$key") == $k ? 'selected' : '' }}>
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
