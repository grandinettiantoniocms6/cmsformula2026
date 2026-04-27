@extends('crud::edit')

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
    $pagePreviewUrl = url('/');
    $currentEntry = $entry ?? null;
    if (!$currentEntry && method_exists($crud, 'getCurrentEntry')) {
        $currentEntry = $crud->getCurrentEntry();
    }

    if ($currentEntry) {
        $previewSlug = $currentEntry->slug;

        if (is_array($previewSlug)) {
            $previewSlug = $previewSlug[app()->getLocale()] ?? reset($previewSlug);
        }

        $previewSlug = trim((string) $previewSlug);
        if ($previewSlug !== '' && $previewSlug !== '/') {
            $pagePreviewUrl = url(ltrim($previewSlug, '/'));
        }
    }
@endphp

@section('header')
    <div class="pages-edit-header-shell {{ $isFutureAdminTemplate ? 'pages-edit-header-shell-future' : '' }}">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>
            @if($isFutureAdminTemplate)
                <span class="pages-edit-future-badge pages-edit-future-badge-clean" id="futureEditDirtyBadge">Salvato</span>
            @endif
            @if(is_numeric(strpos($crud->route, "block")))
                <small><a href="javascript:history.back()" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> <span>Torna al contenuto pagina</span></a></small>
            @else
                @if ($crud->hasAccess('list'))
                    <?php
                    $url_back = $crud->route;
                    $url_back = trim(str_replace(env('APP_URL')."/", "", $url_back));
                    ?>
                    <small><a href="/{{ $url_back }}" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
                @endif
            @endif
        </h3>
        @if($isFutureAdminTemplate)
            <div class="pages-edit-future-toolbar">
                <a class="pages-edit-future-toolbar-btn pages-edit-future-toolbar-btn-neutral" href="{{ $pagePreviewUrl }}" target="_blank" rel="noopener">
                    <i class="las la-eye" aria-hidden="true"></i>
                    <span>Anteprima pagina</span>
                </a>
                <button type="button" class="pages-edit-future-toolbar-btn pages-edit-future-toolbar-btn-primary" id="futureQuickSaveBtn">
                    <i class="la la-save" aria-hidden="true"></i>
                    <span>Salva</span>
                </button>
                <span class="pages-edit-future-shortcut-hint">Ctrl+S</span>
            </div>
        @endif
    </div>
@endsection

@push('after_styles')
    @if($isModernAdminTemplate)
    <style>
        .pages-edit-header-shell {
            background: linear-gradient(125deg, #ffffff 0%, #f3f7ff 100%);
            border: 1px solid #dae5fb;
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(25, 45, 84, 0.08);
            margin-bottom: 12px;
        }

        .pages-edit-header-shell .page-title {
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
            color: #182f59;
            font-weight: 700;
        }

        .pages-edit-header-shell .page-title small {
            color: #627399;
            font-weight: 600;
        }

        .pages-edit-header-shell .page-title small a {
            color: #3e5f9f;
            font-weight: 700;
        }

        .pages-edit-header-shell .page-title small a:hover {
            color: #294a8a;
            text-decoration: none;
        }

        .container-fluid .card,
        .container-fluid .box {
            border-radius: 12px;
            border: 1px solid #dfe7f6;
            box-shadow: 0 8px 22px rgba(19, 37, 72, 0.07);
        }

        .container-fluid .form-group {
            margin-bottom: 1.15rem;
        }

        .container-fluid .form-group > label {
            font-weight: 700;
            color: #20345e;
            margin-bottom: .42rem;
        }

        .container-fluid .form-control,
        .container-fluid .select2-container--bootstrap .select2-selection,
        .container-fluid .bootstrap-switch,
        .container-fluid .note-editor.note-frame {
            border-radius: 9px !important;
        }

        .container-fluid .form-control {
            border-color: #d7e1f3;
            min-height: 40px;
            box-shadow: inset 0 1px 2px rgba(20, 41, 79, 0.04);
        }

        .container-fluid .form-control:focus {
            border-color: #89a5dc;
            box-shadow: 0 0 0 3px rgba(71, 116, 208, 0.13);
        }

        .container-fluid .select2-container--bootstrap .select2-selection {
            border-color: #d7e1f3;
            min-height: 40px;
            box-shadow: inset 0 1px 2px rgba(20, 41, 79, 0.04);
        }

        .container-fluid .bootstrap-switch {
            border-color: #d5dfef !important;
        }

        .container-fluid h5.text.text-primary {
            color: #4a68aa !important;
            font-weight: 700;
            font-size: 1.36rem;
        }

        .container-fluid hr {
            border-top-color: #e3eaf8;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .container-fluid .nav-tabs {
            border-bottom-color: #dce5f6;
        }

        .container-fluid .nav-tabs .nav-link {
            border-radius: 8px 8px 0 0;
            border-color: transparent;
            color: #50648f;
            font-weight: 600;
        }

        .container-fluid .nav-tabs .nav-link.active {
            color: #223a68;
            background: #f5f8ff;
            border-color: #dce5f6 #dce5f6 #f5f8ff;
        }

        .container-fluid .btn-success,
        .container-fluid .btn-primary {
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(17, 40, 82, 0.14);
        }
    </style>
    @endif

    @if($isFutureAdminTemplate)
    <style>
        body.admin-future-template .pages-edit-header-shell-future {
            background: linear-gradient(150deg, #ffffff 0%, #f4f8ff 100%);
            border: 1px solid #d8e4fb;
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 8px 20px rgba(17, 38, 76, 0.08);
            margin-bottom: 12px;
        }

        body.admin-future-template .pages-edit-header-shell-future .page-title {
            display: flex;
            align-items: center;
            gap: .58rem;
            flex-wrap: wrap;
            color: #1d3764;
            font-weight: 700;
        }

        body.admin-future-template .pages-edit-header-shell-future .page-title > small {
            color: #59709a;
            font-weight: 600;
        }

        body.admin-future-template .pages-edit-header-shell-future .page-title > small a {
            color: #2d4f8e;
            font-weight: 700;
        }

        body.admin-future-template .pages-edit-future-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            min-height: 26px;
            padding: .22rem .62rem;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .01em;
            transition: all .15s ease;
        }

        body.admin-future-template .pages-edit-future-badge-clean {
            background: #e9f7ea;
            color: #2f8b54;
            border: 1px solid #cde8d1;
        }

        body.admin-future-template .pages-edit-future-badge-dirty {
            background: #fff4e8;
            color: #a35d1d;
            border: 1px solid #f2d4b3;
        }

        body.admin-future-template .pages-edit-future-badge-saving {
            background: #eaf1ff;
            color: #2e5da9;
            border: 1px solid #cad9f8;
        }

        body.admin-future-template .pages-edit-future-toolbar {
            margin-top: .62rem;
            display: inline-flex;
            align-items: center;
            gap: .48rem;
            position: sticky;
            top: calc(var(--future-header-height) + 8px);
            z-index: 12;
        }

        body.admin-future-template .pages-edit-future-toolbar-btn {
            border: 1px solid transparent;
            border-radius: 10px;
            min-height: 34px;
            padding: .32rem .68rem;
            display: inline-flex;
            align-items: center;
            gap: .38rem;
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none !important;
            transition: all .15s ease;
            line-height: 1;
        }

        body.admin-future-template .pages-edit-future-toolbar-btn i {
            font-size: .92rem;
        }

        body.admin-future-template .pages-edit-future-toolbar-btn-neutral {
            background: #ffffff;
            color: #294b86;
            border-color: #d3def4;
        }

        body.admin-future-template .pages-edit-future-toolbar-btn-neutral:hover {
            background: #f3f7ff;
            color: #1f3f75;
            border-color: #bfd0f2;
        }

        body.admin-future-template .pages-edit-future-toolbar-btn-primary {
            background: #2f9e67;
            color: #ffffff;
            border-color: #2f9e67;
            box-shadow: 0 6px 14px rgba(29, 108, 69, .2);
        }

        body.admin-future-template .pages-edit-future-toolbar-btn-primary:hover {
            background: #278a59;
            border-color: #278a59;
        }

        body.admin-future-template .pages-edit-future-shortcut-hint {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            min-height: 26px;
            padding: .14rem .56rem;
            border: 1px solid #d4def1;
            background: #ffffff;
            color: #5a709b;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .02em;
        }

        body.admin-future-template #saveActions {
            background: rgba(255, 255, 255, .94);
            border-top: 1px solid #d6e2f6;
            box-shadow: 0 -8px 20px rgba(15, 35, 72, .08);
            backdrop-filter: saturate(120%) blur(2px);
            padding-top: .62rem;
            padding-bottom: .62rem;
            gap: .45rem;
        }

        body.admin-future-template #saveActions .btn {
            border-radius: 10px;
            font-weight: 700;
        }

        body.admin-future-template #saveActions .dropdown-toggle {
            min-width: 42px;
        }
    </style>
    @endif
@endpush

@push('after_scripts')
    @if($isFutureAdminTemplate)
    <script>
      (function () {
        if (!document.body.classList.contains('admin-future-template')) return;
        var badge = document.getElementById('futureEditDirtyBadge');
        if (!badge) return;

        var form = document.querySelector('form[action*="/admin/page/"]');
        if (!form) return;
        var quickSaveBtn = document.getElementById('futureQuickSaveBtn');
        var isDirty = false;
        var isSubmitting = false;

        var setBadgeState = function (state) {
          badge.classList.remove('pages-edit-future-badge-clean', 'pages-edit-future-badge-dirty', 'pages-edit-future-badge-saving');
          if (state === 'dirty') {
            badge.classList.add('pages-edit-future-badge-dirty');
            badge.textContent = 'Modifiche non salvate';
            return;
          }
          if (state === 'saving') {
            badge.classList.add('pages-edit-future-badge-saving');
            badge.textContent = 'Salvataggio...';
            return;
          }
          badge.classList.add('pages-edit-future-badge-clean');
          badge.textContent = 'Salvato';
        };

        var markDirty = function (event) {
          var target = event && event.target ? event.target : null;
          if (!target) return;
          if (target.type === 'hidden') return;
          isDirty = true;
          setBadgeState('dirty');
        };

        form.addEventListener('input', markDirty, true);
        form.addEventListener('change', markDirty, true);
        form.addEventListener('submit', function () {
          isSubmitting = true;
          isDirty = false;
          setBadgeState('saving');
        });

        var triggerSave = function () {
          if (!form || isSubmitting) return;
          var saveButton = document.querySelector('#saveActions button[type="submit"], #saveActions input[type="submit"], form button[type="submit"], form input[type="submit"]');
          if (saveButton) {
            saveButton.click();
            return;
          }
          if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
            return;
          }
          form.submit();
        };

        if (quickSaveBtn) {
          quickSaveBtn.addEventListener('click', function () {
            triggerSave();
          });
        }

        document.addEventListener('keydown', function (event) {
          var key = (event.key || '').toLowerCase();
          if (!(event.ctrlKey || event.metaKey) || key !== 's') return;
          event.preventDefault();
          triggerSave();
        });

        window.addEventListener('beforeunload', function (event) {
          if (!isDirty || isSubmitting) return;
          event.preventDefault();
          event.returnValue = '';
        });
      })();
    </script>
    @endif
@endpush
