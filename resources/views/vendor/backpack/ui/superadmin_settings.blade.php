@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        trans('backpack::crud.admin') => backpack_url('dashboard'),
        'SuperAdmin' => false,
    ];

    $tabs = [
        'sito-web' => 'Sito web',
        'template-admin' => 'Template Admin',
        'prodotti-v2-v3' => 'Prodotti V2/V3/V4',
        'avvisi-errori' => 'Avvisi errori',
    ];

    $browseFieldNames = [
        'logo_admin',
        'logo_login',
        'dashboard_gif',
        'admin_login_background',
        'watermark_url',
    ];

    $browseUrls = [];
    foreach ($browseFieldNames as $browseFieldName) {
        $browseUrls[$browseFieldName] = url(config('elfinder.route.prefix').'/popup/'.$browseFieldName).'?mimes='.urlencode(Crypt::encrypt(''));
    }

    $templateAdminBrowseFields = [
        [
            'name' => 'logo_admin',
            'label' => 'Logo pannello admin',
            'value' => $logoAdmin,
        ],
        [
            'name' => 'logo_login',
            'label' => 'Logo Accesso admin (Dimensioni: 180x90px)',
            'value' => $logoLogin,
        ],
        [
            'name' => 'dashboard_gif',
            'label' => 'GIF Dashboard (se vuoto usa quella di default)',
            'value' => $dashboardGif,
        ],
        [
            'name' => 'admin_login_background',
            'label' => 'Sfondo login pannello admin (responsive)',
            'value' => $adminLoginBackground,
            'hint' => 'Se vuoto resta lo sfondo bianco di default.',
        ],
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span>SuperAdmin settings</span>
        </h2>
    </section>
@endsection

@section('content')
    <div class="superadmin-settings-page">
        <ul class="nav nav-tabs superadmin-settings-tabs" id="superadmin-settings-tabs" role="tablist">
            @foreach($tabs as $key => $label)
                <li class="nav-item">
                    <a
                        class="nav-link @if($loop->first) active @endif"
                        id="tab-{{ $key }}"
                        data-toggle="tab"
                        href="#panel-{{ $key }}"
                        role="tab"
                        aria-controls="panel-{{ $key }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    >
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        @if($errors->any())
            <div class="alert alert-danger pb-0">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                        <li><i class="la la-info-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ backpack_url('superadminsettings') }}" class="superadmin-settings-form">
            @csrf

            <div class="tab-content superadmin-settings-tab-content">
                <div class="tab-pane fade show active" id="panel-sito-web" role="tabpanel" aria-labelledby="tab-sito-web">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="number_max_page">Numero di pagine</label>
                            <input
                                type="number"
                                name="number_max_page"
                                id="number_max_page"
                                class="form-control"
                                value="{{ old('number_max_page', $numberMaxPage) }}"
                                min="0"
                                step="1"
                            >
                            <small class="form-text text-muted">Vuoto o 0 significa pagine illimitate.</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="server_allocated_space">Spazio server allocato</label>
                            <input
                                type="text"
                                name="server_allocated_space"
                                id="server_allocated_space"
                                class="form-control"
                                value="{{ old('server_allocated_space', $serverAllocatedSpace) }}"
                                required
                            >
                            <small class="form-text text-muted">Formati accettati: 500 MB, 1GB, 2.5 GB.</small>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="whatsapp_active">Attiva Widget WhatsApp</label>
                            <div class="d-flex align-items-center superadmin-settings-switch-row">
                                <label class="switch switch-lg switch-label switch-pill switch-success mb-0" for="whatsapp_active">
                                    <input type="hidden" name="whatsapp_active" value="0">
                                    <input
                                        type="checkbox"
                                        name="whatsapp_active"
                                        id="whatsapp_active"
                                        class="switch-input"
                                        value="1"
                                        @if((int) old('whatsapp_active', $whatsappActive) === 1) checked @endif
                                    >
                                    <span class="switch-slider" data-checked="ON" data-unchecked="OFF"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" aria-hidden="true"></span> Salva
                    </button>
                </div>

                <div class="tab-pane fade" id="panel-template-admin" role="tabpanel" aria-labelledby="tab-template-admin">
                    <div class="row">
                        @foreach($templateAdminBrowseFields as $browseField)
                            <div class="form-group col-md-12">
                                <label for="{{ $browseField['name'] }}">{{ $browseField['label'] }}</label>
                                <div class="input-group superadmin-browse-field">
                                    <input
                                        type="text"
                                        name="{{ $browseField['name'] }}"
                                        id="{{ $browseField['name'] }}"
                                        class="form-control"
                                        value="{{ old($browseField['name'], $browseField['value']) }}"
                                        data-elfinder-trigger-url="{{ $browseUrls[$browseField['name']] }}"
                                        readonly
                                    >
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-light btn-sm border popup_selector">
                                            <i class="la la-cloud-upload"></i> {{ trans('backpack::crud.browse_uploads') }}
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm border clear_elfinder_picker">
                                            <i class="la la-eraser"></i> {{ trans('backpack::crud.clear') }}
                                        </button>
                                    </div>
                                </div>
                                @if(!empty($browseField['hint']))
                                    <small class="form-text text-muted">{{ $browseField['hint'] }}</small>
                                @endif
                            </div>
                        @endforeach

                        <div class="form-group col-md-6">
                            <label for="admin_topbar_background">Sfondo topbar</label>
                            <div class="input-group colorpicker-component superadmin-jscolor-field">
                                <input
                                    type="text"
                                    name="admin_topbar_background"
                                    id="admin_topbar_background"
                                    class="form-control"
                                    value="{{ old('admin_topbar_background', $adminTopbarBackground) }}"
                                    data-jscolor="{format: 'hexa'}"
                                >
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="admin_leftbar_background">Sfondo barra di sinistra</label>
                            <div class="input-group colorpicker-component superadmin-jscolor-field">
                                <input
                                    type="text"
                                    name="admin_leftbar_background"
                                    id="admin_leftbar_background"
                                    class="form-control"
                                    value="{{ old('admin_leftbar_background', $adminLeftbarBackground) }}"
                                    data-jscolor="{format: 'hexa'}"
                                >
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="admin_panel_template">Template Pannello Admin</label>
                            <div class="superadmin-select-field">
                                <i class="la la-layer-group" aria-hidden="true"></i>
                                <select name="admin_panel_template" id="admin_panel_template" class="form-control custom-select">
                                    @foreach(['white' => 'White', 'modern_01' => 'Modern 01', 'modern_02' => 'Modern 02', 'future' => 'Future'] as $value => $label)
                                        <option value="{{ $value }}" @if(old('admin_panel_template', $adminPanelTemplate) === $value) selected @endif>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <span class="superadmin-select-arrow la la-angle-down" aria-hidden="true"></span>
                            </div>
                            <small class="form-text text-muted">Seleziona il layout del pannello amministrativo.</small>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="bacheca">Bacheca da far vedere (nome blade)</label>
                            <input type="text" name="bacheca" id="bacheca" class="form-control" value="{{ old('bacheca', $bacheca) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" aria-hidden="true"></span> Salva
                    </button>
                </div>

                <div class="tab-pane fade" id="panel-prodotti-v2-v3" role="tabpanel" aria-labelledby="tab-prodotti-v2-v3">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="is_megamenu">Attiva megamenu sulla pagina PRODOTTI</label>
                            <div class="d-flex align-items-center superadmin-settings-switch-row">
                                <label class="switch switch-lg switch-label switch-pill switch-success mb-0" for="is_megamenu">
                                    <input type="hidden" name="is_megamenu" value="0">
                                    <input
                                        type="checkbox"
                                        name="is_megamenu"
                                        id="is_megamenu"
                                        class="switch-input"
                                        value="1"
                                        @if((int) old('is_megamenu', $isMegamenu) === 1) checked @endif
                                    >
                                    <span class="switch-slider" data-checked="ON" data-unchecked="OFF"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="is_search_one_col">Megamenu (se attivo) monocolonna</label>
                            <div class="d-flex align-items-center superadmin-settings-switch-row">
                                <label class="switch switch-lg switch-label switch-pill switch-success mb-0" for="is_search_one_col">
                                    <input type="hidden" name="is_search_one_col" value="0">
                                    <input
                                        type="checkbox"
                                        name="is_search_one_col"
                                        id="is_search_one_col"
                                        class="switch-input"
                                        value="1"
                                        @if((int) old('is_search_one_col', $isSearchOneCol) === 1) checked @endif
                                    >
                                    <span class="switch-slider" data-checked="ON" data-unchecked="OFF"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-12 superadmin-settings-actions">
                            <a
                                href="{{ route('azzera_ordini') }}"
                                class="btn btn-danger"
                                onclick="return confirm('Sei sicuro di voler azzerare tutti gli ordini?')"
                            >
                                Azzera ordini
                            </a>

                            <a
                                href="{{ route('set_shop_areas') }}"
                                class="btn btn-danger @if($shopAreasPresent) disabled @endif"
                                @if($shopAreasPresent)
                                    onclick="return false;"
                                @else
                                    onclick="return confirm('Sei sicuro di voler caricare shop areas?')"
                                @endif
                            >
                                Carica shop area zone
                            </a>

                            @if($shopAreasPresent)
                                <small class="text-muted d-block mt-1">Shop areas già presenti</small>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <div class="superadmin-settings-section-separator">
                                <h3>Watermark</h3>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="watermark_url">Url</label>
                            <div class="input-group superadmin-browse-field">
                                <input
                                    type="text"
                                    name="watermark_url"
                                    id="watermark_url"
                                    class="form-control"
                                    value="{{ old('watermark_url', $watermarkUrl) }}"
                                    data-elfinder-trigger-url="{{ $browseUrls['watermark_url'] }}"
                                    readonly
                                >
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-light btn-sm border popup_selector">
                                        <i class="la la-cloud-upload"></i> {{ trans('backpack::crud.browse_uploads') }}
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm border clear_elfinder_picker">
                                        <i class="la la-eraser"></i> {{ trans('backpack::crud.clear') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="watermark_position">Posizione</label>
                            <input type="text" name="watermark_position" id="watermark_position" class="form-control" value="{{ old('watermark_position', $watermarkPosition) }}">
                            <small class="form-text text-muted">top-left, top, top-right, left, center, right, bottom-left, bottom, bottom-right</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="watermark_x">Posizione X</label>
                            <input type="text" name="watermark_x" id="watermark_x" class="form-control" value="{{ old('watermark_x', $watermarkX) }}">
                            <small class="form-text text-muted">Offset relativo sull'asse X. Default: 0.</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="watermark_y">Posizione Y</label>
                            <input type="text" name="watermark_y" id="watermark_y" class="form-control" value="{{ old('watermark_y', $watermarkY) }}">
                            <small class="form-text text-muted">Offset relativo sull'asse Y. Default: 0.</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" aria-hidden="true"></span> Salva
                    </button>
                </div>

                <div class="tab-pane fade" id="panel-avvisi-errori" role="tabpanel" aria-labelledby="tab-avvisi-errori">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="error_alert_enabled">Abilita invio avvisi errore via email</label>
                            <div class="d-flex align-items-center superadmin-settings-switch-row">
                                <label class="switch switch-lg switch-label switch-pill switch-success mb-0" for="error_alert_enabled">
                                    <input type="hidden" name="error_alert_enabled" value="0">
                                    <input
                                        type="checkbox"
                                        name="error_alert_enabled"
                                        id="error_alert_enabled"
                                        class="switch-input"
                                        value="1"
                                        @if((int) old('error_alert_enabled', $errorAlertEnabled) === 1) checked @endif
                                    >
                                    <span class="switch-slider" data-checked="ON" data-unchecked="OFF"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="error_alert_email">Email</label>
                            <input
                                type="email"
                                name="error_alert_email"
                                id="error_alert_email"
                                class="form-control"
                                value="{{ old('error_alert_email', $errorAlertEmail) }}"
                                required
                            >
                        </div>

                        <div class="form-group col-md-6">
                            <label for="error_alert_cc">E-mail in copia</label>
                            <input
                                type="text"
                                name="error_alert_cc"
                                id="error_alert_cc"
                                class="form-control"
                                value="{{ old('error_alert_cc', $errorAlertCc) }}"
                                placeholder="email1@dominio.it, email2@dominio.it"
                            >
                        </div>

                        <div class="form-group col-md-4">
                            <label for="error_alert_repeat_hours">Reinvio stesso errore dopo</label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    name="error_alert_repeat_hours"
                                    id="error_alert_repeat_hours"
                                    class="form-control"
                                    value="{{ old('error_alert_repeat_hours', $errorAlertRepeatHours) }}"
                                    min="1"
                                    step="1"
                                    required
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text">ore</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" aria-hidden="true"></span> Salva
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('after_styles')
    @basset('https://cdn.jsdelivr.net/npm/jquery-colorbox@1.6.4/example2/colorbox.css')
    @basset('https://cdn.jsdelivr.net/npm/jquery-colorbox@1.6.4/example2/images/loading.gif', false)
    @basset('https://cdn.jsdelivr.net/npm/jquery-colorbox@1.6.4/example2/images/controls.png', false)

    <style>
        #cboxContent,
        #cboxLoadedContent,
        .cboxIframe {
            background: transparent;
        }

        .superadmin-settings-page {
            width: 100%;
        }

        .superadmin-settings-tabs {
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 0;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .superadmin-settings-tabs .nav-item {
            flex: 0 0 auto;
        }

        .superadmin-settings-tabs .nav-link {
            border: 1px solid #d9e5f9;
            border-radius: 999px;
            padding: .5rem .9rem;
            color: #425f93;
            background: #ffffff;
            font-weight: 600;
            white-space: nowrap;
        }

        .superadmin-settings-tabs .nav-link.active {
            color: #15376a;
            background: #eaf1ff;
            border-color: #c7dafd;
            box-shadow: 0 8px 18px rgba(24, 60, 121, .12);
        }

        .superadmin-settings-tab-content .tab-pane {
            background: #ffffff;
            border: 1px solid #dbe6f9;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 8px 20px rgba(17, 39, 83, .06);
        }

        .superadmin-settings-form label {
            color: #223a67;
            font-weight: 700;
        }

        .superadmin-settings-form .form-control,
        .superadmin-settings-form .custom-select {
            min-height: 42px;
            border-radius: 9px;
            border-color: #d7e1f2;
            box-shadow: inset 0 1px 2px rgba(18, 38, 76, 0.04);
        }

        .superadmin-settings-switch-row {
            min-height: 42px;
        }

        .superadmin-settings-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .superadmin-settings-section-separator {
            border-top: 1px solid #dbe6f9;
            margin: 10px 0 18px;
            padding-top: 16px;
        }

        .superadmin-settings-section-separator h3 {
            color: #1d345f;
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
        }

        .superadmin-settings-form .btn-success {
            border-radius: 10px;
            font-weight: 700;
        }

        .superadmin-browse-field {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
            width: 100%;
        }

        .superadmin-browse-field .form-control {
            flex: 1 1 auto;
            min-width: 0;
            border-radius: 9px !important;
            background: #ffffff;
        }

        .superadmin-browse-field .btn {
            min-height: 42px;
            border-radius: 9px !important;
            font-weight: 600;
            padding: .5rem .9rem;
            white-space: nowrap;
        }

        .superadmin-browse-field .popup_selector {
            background: #f7faff;
            border-color: #cfdcf0 !important;
            color: #24467c;
        }

        .superadmin-browse-field .clear_elfinder_picker {
            background: #fff8f3;
            border-color: #f5d8c8 !important;
            color: #8e3e1d;
        }

        .superadmin-browse-field .input-group-append {
            display: flex;
            gap: 8px;
            margin-left: 0;
            flex: 0 0 auto;
        }

        .superadmin-select-field {
            position: relative;
            display: flex;
            align-items: center;
        }

        .superadmin-select-field > i {
            position: absolute;
            left: 13px;
            z-index: 2;
            color: #45699e;
            font-size: 1rem;
            pointer-events: none;
        }

        .superadmin-select-field .custom-select {
            padding-left: 38px;
            padding-right: 42px;
            appearance: none;
            background-image: none;
            cursor: pointer;
            color: #1f3f70;
            font-weight: 600;
        }

        .superadmin-select-arrow {
            position: absolute;
            right: 13px;
            z-index: 2;
            color: #45699e;
            font-size: 1.05rem;
            pointer-events: none;
        }

        .superadmin-settings-empty {
            min-height: 120px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            color: #274777;
        }

        .superadmin-settings-empty strong {
            display: block;
            color: #1d345f;
            font-size: .95rem;
        }

        .superadmin-settings-empty span {
            color: #5e749f;
        }

        .superadmin-settings-empty .btn {
            border-radius: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        @media (max-width: 575px) {
            .superadmin-settings-empty {
                flex-direction: column;
            }

            .superadmin-browse-field,
            .superadmin-browse-field .input-group-append {
                flex-wrap: wrap;
            }
        }
    </style>
@endpush

@push('after_scripts')
    @basset('https://cdn.jsdelivr.net/npm/jquery-colorbox@1.6.4/jquery.colorbox-min.js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.5.1/jscolor.min.js"></script>

    <script>
        var elfinderTarget = false;

        function processSelectedFile(filePath, requestingField) {
            if (!elfinderTarget) {
                return;
            }

            elfinderTarget.val(filePath.replace(/\\/g, '/'));
            elfinderTarget.trigger('change');
            elfinderTarget = false;
        }

        (function () {
            $('.superadmin-browse-field').each(function () {
                var field = $(this);
                var input = field.find('input[type="text"]').first();

                if (!input.length) {
                    return;
                }

                field.find('.popup_selector').on('click', function (event) {
                    event.preventDefault();

                    elfinderTarget = input;

                    $.colorbox({
                        href: input.data('elfinder-trigger-url'),
                        fastIframe: false,
                        iframe: true,
                        width: '80%',
                        height: '80%'
                    });
                });

                field.find('.clear_elfinder_picker').on('click', function (event) {
                    event.preventDefault();
                    input.val('').trigger('change');
                });
            });
        })();
    </script>
@endpush
