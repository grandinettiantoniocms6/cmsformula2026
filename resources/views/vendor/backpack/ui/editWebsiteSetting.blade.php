@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
    $isEnhancedAdminTemplate = $isModernAdminTemplate || $isFutureAdminTemplate;
@endphp

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard')
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="website-setting-header-shell">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        </h3>
    </div>
@endsection

@section('content')
<div class="row">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post" class="mb-5 pb-4"
		  		action="{{ url($crud->route.'/'.$entry->getKey()) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  {!! method_field('PUT') !!}

		  	@if ($crud->model->translationEnabled())
		    <div class="mb-2 text-right">
		    	<!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif

              @if($isEnhancedAdminTemplate)
              <div class="website-setting-top-actions" id="website-setting-top-actions">
                  <div class="website-setting-top-actions__left">
                      <strong>Impostazioni sito</strong>
                      <small id="website-setting-dirty-status" class="is-clean">Nessuna modifica in sospeso</small>
                  </div>
                  <div class="website-setting-top-actions__right">
                      <button type="submit" class="btn btn-success">
                          <span class="la la-save" aria-hidden="true"></span> Salva
                      </button>
                  </div>
              </div>

              <div class="website-setting-live-preview d-none d-lg-flex" id="website-setting-live-preview">
                  <div class="website-setting-live-preview__mock">
                      <div class="website-setting-live-preview__topbar" id="website-preview-topbar">
                          <span>Topbar admin</span>
                          <span class="website-setting-live-preview__dot"></span>
                      </div>
                      <div class="website-setting-live-preview__body">
                          <aside class="website-setting-live-preview__sidebar" id="website-preview-sidebar">
                              <span>Barra sinistra</span>
                          </aside>
                          <div class="website-setting-live-preview__content">
                              Anteprima colori Modern
                          </div>
                      </div>
                  </div>
                  <div class="website-setting-live-preview__meta">
                      <strong>Preview live</strong>
                      <small>Si aggiorna con i campi "Sfondo topbar" e "Sfondo barra di sinistra".</small>
                  </div>
              </div>
              @endif
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @endif

              @if(isset($saveAction['active']) && !is_null($saveAction['active']['value']))
                  <div id="saveActions" class="form-group">

                      <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">
                      @if(!empty($saveAction['options']))
                          <div class="btn-group" role="group">
                              @endif

                              <button type="submit" class="btn btn-success">
                                  <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                  <span data-value="{{ $saveAction['active']['value'] }}">Salva</span>
                              </button>
                              @if(!empty($saveAction['options']))
                          </div>
                      @endif
                  </div>
              @endif

          </form>
	</div>
</div>
@endsection

@php
    $isModernAdminTemplate = $isModernAdminTemplate ?? \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isFutureAdminTemplate = $isFutureAdminTemplate ?? \App\Models\WebsiteSetting::isAdminFutureTemplate();
    $isEnhancedAdminTemplate = $isEnhancedAdminTemplate ?? ($isModernAdminTemplate || $isFutureAdminTemplate);
@endphp
@push('after_styles')
    @if($isEnhancedAdminTemplate)
    <style>
        .website-setting-header-shell {
            background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
            border: 1px solid #dae5fb;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;
            box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
        }

        .website-setting-header-shell .page-title {
            color: #182f59;
            font-weight: 700;
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
        }

        .container-fluid .form-group > label {
            color: #223a67;
            font-weight: 700;
        }

        .container-fluid .form-control,
        .container-fluid .select2-container--bootstrap .select2-selection {
            min-height: 42px;
            border-radius: 9px !important;
            border-color: #d7e1f2;
            box-shadow: inset 0 1px 2px rgba(18, 38, 76, 0.04);
        }

        .container-fluid .form-control:focus {
            border-color: #89a6dc;
            box-shadow: 0 0 0 3px rgba(62, 111, 206, 0.13);
        }

        .container-fluid .btn-success,
        .container-fluid .btn-primary {
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(14, 36, 79, 0.14);
        }

        .website-setting-top-actions {
            position: sticky;
            top: 66px;
            z-index: 1021;
            background: linear-gradient(125deg, #ffffff 0%, #f6f9ff 100%);
            border: 1px solid #d9e6fb;
            border-radius: 12px;
            padding: 10px 12px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            box-shadow: 0 10px 24px rgba(16, 37, 77, 0.08);
        }

        .website-setting-top-actions__left {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .website-setting-top-actions__left strong {
            color: #1d345f;
            font-size: .92rem;
        }

        .website-setting-top-actions__left small {
            font-size: .76rem;
            color: #5a6f98;
        }

        .website-setting-top-actions__left small.is-dirty {
            color: #be5a00;
            font-weight: 700;
        }

        .website-setting-live-preview {
            border: 1px solid #d9e6fb;
            border-radius: 12px;
            background: #f8fbff;
            padding: 12px;
            margin-bottom: 14px;
            gap: 12px;
            align-items: center;
        }

        .website-setting-live-preview__mock {
            width: 320px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #d5e2f7;
            background: #ffffff;
        }

        .website-setting-live-preview__topbar {
            min-height: 30px;
            padding: 0 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #eef4ff;
            font-size: .72rem;
            font-weight: 700;
            background: #1b2a4e;
        }

        .website-setting-live-preview__dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            opacity: .8;
        }

        .website-setting-live-preview__body {
            display: grid;
            grid-template-columns: 90px 1fr;
            min-height: 74px;
        }

        .website-setting-live-preview__sidebar {
            background: #1b2a4e;
            color: #eef4ff;
            font-size: .68rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 8px;
        }

        .website-setting-live-preview__content {
            background: #ffffff;
            color: #5e7198;
            font-size: .7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .website-setting-live-preview__meta {
            display: flex;
            flex-direction: column;
            gap: 2px;
            color: #274777;
        }

        .website-setting-live-preview__meta strong {
            font-size: .82rem;
        }

        .website-setting-live-preview__meta small {
            font-size: .74rem;
            color: #5e749f;
        }

        #form_tabs .nav.nav-tabs {
            gap: 8px;
            padding-bottom: 8px;
            border-bottom: 0;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        #form_tabs .nav.nav-tabs .nav-item {
            flex: 0 0 auto;
        }

        #form_tabs .nav.nav-tabs .nav-link {
            border: 1px solid #d9e5f9;
            border-radius: 999px;
            padding: .5rem .9rem;
            color: #425f93;
            background: #ffffff;
            font-weight: 600;
            white-space: nowrap;
        }

        #form_tabs .nav.nav-tabs .nav-link.active {
            color: #15376a;
            background: #eaf1ff;
            border-color: #c7dafd;
            box-shadow: 0 8px 18px rgba(24, 60, 121, .12);
        }

        #form_tabs .tab-content .tab-pane {
            background: #ffffff;
            border: 1px solid #dbe6f9;
            border-radius: 12px;
            padding: 14px 14px 4px;
            box-shadow: 0 8px 20px rgba(17, 39, 83, .06);
        }

        #form_tabs .tab-content .tab-pane .input-group > .btn {
            border-radius: 9px !important;
            margin-left: 6px;
            font-weight: 600;
        }

        #form_tabs .tab-content .tab-pane .input-group > .btn.popup_selector {
            background: #edf3ff;
            border-color: #cfe0fd;
            color: #24467c;
        }

        #form_tabs .tab-content .tab-pane .input-group > .btn.clear_elfinder_picker {
            background: #fff5f0;
            border-color: #ffd8c8;
            color: #8e3e1d;
        }

        @media (max-width: 991px) {
            .website-setting-top-actions {
                top: 58px;
            }
        }
    </style>
    @endif
@endpush

@push('after_scripts')
    @if($isEnhancedAdminTemplate)
    <script>
      (function () {
        var form = document.querySelector('form[action*="/websiteSetting/"]');
        if (!form) return;

        var status = document.getElementById('website-setting-dirty-status');
        var preview = document.getElementById('website-setting-live-preview');
        var previewTopbar = document.getElementById('website-preview-topbar');
        var previewSidebar = document.getElementById('website-preview-sidebar');

        var topbarInput = form.querySelector('input[name="admin_topbar_background"]');
        var leftbarInput = form.querySelector('input[name="admin_leftbar_background"]');
        var templateInput = form.querySelector('[name="admin_panel_template"]');

        var normalizeHex = function (value, fallback) {
          var raw = String(value || '').trim();
          if (!raw) return fallback;
          if (raw.charAt(0) !== '#') raw = '#' + raw;
          var valid = /^#[0-9a-fA-F]{6}([0-9a-fA-F]{2})?$/.test(raw);
          if (!valid) return fallback;
          return raw.slice(0, 7);
        };

        var syncPreviewVisibility = function () {
          if (!preview) return;
          if (!templateInput) return;
          var templateValue = String(templateInput.value || '');
          var visible = templateValue === 'modern_01' || templateValue === 'modern_02' || templateValue === 'future';
          preview.classList.toggle('d-none', !visible);
          preview.classList.toggle('d-lg-flex', visible);
        };

        var syncPreviewColors = function () {
          if (!previewTopbar || !previewSidebar) return;
          var topbarColor = normalizeHex(topbarInput ? topbarInput.value : '', '#1b2a4e');
          var leftbarColor = normalizeHex(leftbarInput ? leftbarInput.value : '', '#1b2a4e');
          previewTopbar.style.background = topbarColor;
          previewSidebar.style.background = leftbarColor;
        };

        var markDirty = function () {
          if (!status) return;
          status.textContent = 'Modifiche non salvate';
          status.classList.add('is-dirty');
          status.classList.remove('is-clean');
        };

        form.addEventListener('input', function () {
          markDirty();
          syncPreviewColors();
        });

        form.addEventListener('change', function () {
          markDirty();
          syncPreviewColors();
          syncPreviewVisibility();
        });

        form.addEventListener('submit', function () {
          if (!status) return;
          status.textContent = 'Salvataggio in corso...';
          status.classList.remove('is-dirty');
          status.classList.add('is-clean');
        });

        syncPreviewColors();
        syncPreviewVisibility();
      })();
    </script>
    @endif
@endpush

