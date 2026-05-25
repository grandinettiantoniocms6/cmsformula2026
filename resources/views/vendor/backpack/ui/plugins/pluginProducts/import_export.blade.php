@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@section('header')
    <div class="import-export-header-shell">
        <h3 class="page-title mb-0">Import/Export</h3>
    </div>
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
                            <div class="upload-progress-wrapper" aria-live="polite">
                                <div class="upload-progress-top">
                                    <span class="upload-progress-title">Caricamento file</span>
                                    <span class="upload-progress-value">0%</span>
                                </div>
                                <div class="progress upload-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated upload-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="upload-progress-hint">Preparazione upload...</small>
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
                            <div class="upload-progress-wrapper" aria-live="polite">
                                <div class="upload-progress-top">
                                    <span class="upload-progress-title">Caricamento file</span>
                                    <span class="upload-progress-value">0%</span>
                                </div>
                                <div class="progress upload-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated upload-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="upload-progress-hint">Preparazione upload...</small>
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

                        <div class="form-loader" hidden>
                            <div class="upload-progress-wrapper" aria-live="polite">
                                <div class="upload-progress-top">
                                    <span class="upload-progress-title">Caricamento file</span>
                                    <span class="upload-progress-value">0%</span>
                                </div>
                                <div class="progress upload-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated upload-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="upload-progress-hint">Preparazione upload...</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="file_special" accept=".csv,.xls,.xlsx" class="form-control form-control-file invisible" id="file-special" value="{{ old('file') }}">
                                <label class="custom-file-label" for="file-special">Scegli file (csv con separatore ;, xls oppure xlsx)</label>
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
                        <button type="submit" name="submit" value="load" class="btn btn-dark btn-block js-special-import-submit"><span>Importa</span></button>
                    </form>

                    <div class="mt-4 p-3 border rounded bg-light" id="import-special-runs" data-url="{{ route('pluginProducts.importSpecialRuns') }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Esecuzioni import recenti</h6>
                            <small class="text-muted">Aggiornamento automatico</small>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>File / Configurazione</th>
                                        <th>Stato</th>
                                        <th style="min-width: 180px;">Avanzamento</th>
                                        <th>Avviata</th>
                                        <th>Completata</th>
                                    </tr>
                                </thead>
                                <tbody class="js-import-runs-body">
                                    <tr><td colspan="5" class="text-muted">Caricamento esecuzioni...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php $postImportUrl = route('pluginProducts.importSpecialPostImportActions'); ?>
                    <form method="post" action="{{ $postImportUrl }}" class="position-relative mt-4 p-3 border rounded bg-light js-submit-progress">
                        {{ csrf_field() }}
                        <h6 class="mb-2">Fase successiva post-import</h6>
                        <p class="mb-3">Dopo ogni import file, esegui queste operazioni per aggiornare gli indici.</p>

                        <div class="form-loader" hidden>
                            <div class="upload-progress-wrapper" aria-live="polite">
                                <div class="upload-progress-top">
                                    <span class="upload-progress-title">Esecuzione operazioni</span>
                                    <span class="upload-progress-value">0%</span>
                                </div>
                                <div class="progress upload-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated upload-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="upload-progress-hint">Avvio operazioni post-import...</small>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="runProductsSearchPost" name="run_products_search" value="1" {{ old('run_products_search', 1) == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="runProductsSearchPost">Aggiorna indice prodotti (`set:products_search`)</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="runProductsCategoriesSearchPost" name="run_products_categories_search" value="1" {{ old('run_products_categories_search', 1) == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="runProductsCategoriesSearchPost">Aggiorna indice categorie (`set:products_categories_search`)</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-dark btn-block js-post-import-actions-button"><span>Esegui operazioni post-import</span></button>
                        <small class="form-text text-muted js-post-import-actions-hint" style="display: none;">Attendi il completamento degli import in corso prima di aggiornare gli indici.</small>
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
    @if($isModernAdminTemplate)
    <style>
        .upload-progress-wrapper {
            margin: .35rem 0 .9rem;
            padding: .75rem .9rem;
            border: 1px solid #e5e7eb;
            border-radius: .65rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 4px 14px rgba(15, 23, 42, .06);
        }

        .upload-progress-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .45rem;
            gap: .5rem;
        }

        .upload-progress-title {
            font-size: .78rem;
            font-weight: 600;
            color: #334155;
            letter-spacing: .02em;
            text-transform: uppercase;
        }

        .upload-progress-value {
            min-width: 48px;
            text-align: center;
            font-size: .76rem;
            font-weight: 700;
            line-height: 1.2;
            color: #0f172a;
            background: #e2e8f0;
            border-radius: 999px;
            padding: .2rem .5rem;
        }

        .upload-progress {
            height: .8rem;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .upload-progress-bar {
            background-image: linear-gradient(90deg, #1d4ed8 0%, #0ea5e9 100%);
            transition: width .2s ease;
        }

        .upload-progress-hint {
            display: block;
            margin-top: .45rem;
            color: #64748b;
            font-size: .74rem;
            line-height: 1.25;
        }
    </style>
    @endif
@endsection

@push('after_styles')
    @if($isModernAdminTemplate)
    <style>
        .import-export-header-shell {
            background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
            border: 1px solid #dae5fb;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;
            box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
        }

        .import-export-header-shell .page-title {
            color: #182f59;
            font-weight: 700;
        }

        .card.h-100.shadow-none {
            border: 1px solid #dfe7f6;
            border-radius: 12px;
            box-shadow: 0 10px 22px rgba(19, 38, 75, 0.08) !important;
        }

        .card.h-100.shadow-none .card-header {
            background: #f5f8ff !important;
            color: #233e6f;
            font-weight: 700;
            border-bottom: 1px solid #e0e8f7;
        }

        .card.h-100.shadow-none .btn {
            border-radius: 9px;
            font-weight: 700;
        }

        .card.h-100.shadow-none .form-control,
        .card.h-100.shadow-none .custom-select {
            border-radius: 8px;
            border-color: #d5def0;
            min-height: 40px;
        }
    </style>
    @endif
@endpush

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

        var $importRunsMonitor = jQuery('#import-special-runs');

        function refreshImportRuns() {
            if (!$importRunsMonitor.length) {
                return;
            }

            jQuery.getJSON($importRunsMonitor.data('url'), function (response) {
                var $tbody = $importRunsMonitor.find('.js-import-runs-body').empty();
                var runs = response.runs || [];
                var hasActiveRuns = runs.some(function (run) {
                    return run.status === 'queued' || run.status === 'processing';
                });

                jQuery('.js-post-import-actions-button').prop('disabled', hasActiveRuns);
                jQuery('.js-post-import-actions-hint').toggle(hasActiveRuns);
                jQuery('.js-special-import-submit').prop('disabled', hasActiveRuns);

                if (!runs.length) {
                    $tbody.append(jQuery('<tr/>').append(jQuery('<td/>', {
                        colspan: 5,
                        'class': 'text-muted',
                        text: 'Nessuna esecuzione disponibile.'
                    })));
                    return;
                }

                jQuery.each(runs, function (_, run) {
                    var statusLabels = {
                        queued: 'In coda',
                        processing: 'In lavorazione',
                        completed: 'Completata',
                        failed: 'Errore'
                    };
                    var statusClasses = {
                        queued: 'badge-secondary',
                        processing: 'badge-info',
                        completed: 'badge-success',
                        failed: 'badge-danger'
                    };
                    var $fileCell = jQuery('<td/>')
                        .append(jQuery('<div/>', { text: run.file_name }))
                        .append(jQuery('<small/>', { 'class': 'text-muted', text: run.config_name }));
                    var $statusCell = jQuery('<td/>').append(jQuery('<span/>', {
                        'class': 'badge ' + (statusClasses[run.status] || 'badge-secondary'),
                        text: statusLabels[run.status] || run.status
                    }));
                    if (run.error_message) {
                        $statusCell.append(jQuery('<div/>', {
                            'class': 'small text-danger mt-1',
                            text: run.error_message
                        }));
                    }
                    var progressText = run.processed_rows + ' / ' + run.total_rows + ' (' + run.percentage + '%)';
                    var $progressCell = jQuery('<td/>')
                        .append(jQuery('<div/>', {
                            'class': 'progress mb-1',
                            style: 'height: 8px;'
                        }).append(jQuery('<div/>', {
                            'class': 'progress-bar' + (run.status === 'failed' ? ' bg-danger' : ''),
                            role: 'progressbar',
                            style: 'width: ' + run.percentage + '%;',
                            'aria-valuenow': run.percentage,
                            'aria-valuemin': 0,
                            'aria-valuemax': 100
                        })))
                        .append(jQuery('<small/>', { text: progressText }));

                    $tbody.append(jQuery('<tr/>')
                        .append($fileCell)
                        .append($statusCell)
                        .append($progressCell)
                        .append(jQuery('<td/>', { text: run.queued_at || '-' }))
                        .append(jQuery('<td/>', { text: run.completed_at || '-' })));
                });
            });
        }

        refreshImportRuns();
        if ($importRunsMonitor.length) {
            setInterval(refreshImportRuns, 4000);
        }

        jQuery('form').each(function(){
            var id = jQuery(this).attr('id');
            if (!id) {
                return;
            }

            var $form = jQuery('#' + id);
            var $loader = $form.find('.form-loader');
            var $progressBar = $form.find('.upload-progress-bar');
            var $progressValue = $form.find('.upload-progress-value');
            var $progressHint = $form.find('.upload-progress-hint');
            var visualProgress = 0;
            var visualProgressTimer = null;
            var processingProgressTimer = null;

            function clearVisualProgressTimer() {
                if (visualProgressTimer) {
                    clearInterval(visualProgressTimer);
                    visualProgressTimer = null;
                }
            }

            function clearProcessingProgressTimer() {
                if (processingProgressTimer) {
                    clearInterval(processingProgressTimer);
                    processingProgressTimer = null;
                }
            }

            function updateProgress(percentComplete, label) {
                var safePercent = Number.isFinite(percentComplete) ? Math.max(0, Math.min(100, Math.round(percentComplete))) : 0;
                $progressBar
                    .css('width', safePercent + '%')
                    .attr('aria-valuenow', safePercent);
                $progressValue.text(safePercent + '%');
                if (label) {
                    $progressHint.text(label);
                } else if (safePercent >= 100) {
                    $progressHint.text('Upload completato');
                } else if (safePercent > 0) {
                    $progressHint.text('Caricamento file in corso...');
                } else {
                    $progressHint.text('Preparazione upload...');
                }
            }

            function startVisualProgress() {
                clearVisualProgressTimer();
                clearProcessingProgressTimer();
                visualProgress = 2;
                updateProgress(visualProgress);

                // Avanzamento "morbido" fino al 92% durante upload/elaborazione server.
                visualProgressTimer = setInterval(function () {
                    if (visualProgress >= 92) {
                        return;
                    }

                    visualProgress += visualProgress < 70 ? 2 : 1;
                    updateProgress(visualProgress);
                }, 350);
            }

            function setProcessingState() {
                clearVisualProgressTimer();
                clearProcessingProgressTimer();

                var milestones = [60, 75, 80, 86, 90, 93, 95, 97, 98];
                var index = 0;

                visualProgress = Math.max(visualProgress, 55);
                updateProgress(visualProgress, 'Elaborazione dati lato server...');

                processingProgressTimer = setInterval(function () {
                    if (index >= milestones.length) {
                        clearProcessingProgressTimer();
                        return;
                    }

                    var nextValue = milestones[index];
                    index++;

                    if (nextValue > visualProgress && nextValue < 100) {
                        visualProgress = nextValue;
                        updateProgress(visualProgress, 'Elaborazione dati lato server...');
                    }
                }, 700);
            }

            jQuery('#'+id).ajaxForm({
                beforeSend: function() {
                    $form.find('.js-import-feedback').remove();
                    startVisualProgress();
                    $loader.attr('hidden', false);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    if (percentComplete >= 100) {
                        setProcessingState();
                    } else {
                        var boundedProgress = Math.min(94, Math.round(percentComplete));
                        visualProgress = Math.max(visualProgress, boundedProgress);
                        updateProgress(visualProgress);
                    }
                    $loader.attr('hidden', false);
                },
                error: function (response, status, e) {
                    var message = '';

                    if (status === "error" && response.responseJSON && response.responseJSON.message) {
                        if (response.responseJSON.message === "validation.required"  ) {
                            message = 'Campo File obbligatorio';
                        } else {
                            message = response.responseJSON.message;
                        }

                        jQuery('<div/>', {
                            'class': 'alert alert-danger py-2 js-import-feedback',
                            text: message
                        }).prependTo(jQuery('#'+id));
                    }

                    clearVisualProgressTimer();
                    clearProcessingProgressTimer();
                    updateProgress(0);
                    $loader.attr('hidden', true);
                },
                success: function (data) {
                    clearVisualProgressTimer();
                    clearProcessingProgressTimer();
                    if(data.url){
                        updateProgress(100);
                        window.location.href = data.url;
                    }else{
                        updateProgress(100);
                        setTimeout(function () {
                            updateProgress(0);
                            $loader.attr('hidden', true);
                        }, 400);
                        jQuery('#'+id).find('input[type="file"]').val('');
                        jQuery('<div/>', {
                            'class': 'alert alert-success py-2 js-import-feedback',
                            text: data.message || 'File caricato con successo.'
                        }).prependTo(jQuery('#'+id));
                        if (data.queued) {
                            refreshImportRuns();
                        }
                    }

                }
            });
        });

        jQuery('form.js-submit-progress').on('submit', function () {
            var $form = jQuery(this);
            var $loader = $form.find('.form-loader');
            var $progressBar = $form.find('.upload-progress-bar');
            var $progressValue = $form.find('.upload-progress-value');
            var $progressHint = $form.find('.upload-progress-hint');
            var current = 0;

            $loader.attr('hidden', false);
            $form.find('button[type="submit"]').prop('disabled', true);

            function updatePostImportProgress(value, hintText) {
                current = Math.max(current, Math.min(99, Math.round(value)));
                $progressBar.css('width', current + '%').attr('aria-valuenow', current);
                $progressValue.text(current + '%');
                if (hintText) {
                    $progressHint.text(hintText);
                }
            }

            updatePostImportProgress(8, 'Avvio operazioni post-import...');

            var sequence = [20, 35, 50, 65, 75, 82, 88, 93, 96, 98];
            var idx = 0;
            var timer = setInterval(function () {
                if (idx >= sequence.length) {
                    clearInterval(timer);
                    return;
                }

                updatePostImportProgress(sequence[idx], 'Elaborazione operazioni in corso...');
                idx++;
            }, 700);
        });
    </script>
@endsection
