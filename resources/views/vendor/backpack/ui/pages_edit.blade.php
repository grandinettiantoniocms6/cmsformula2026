@extends('crud::edit')

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@section('header')
    <div class="pages-edit-header-shell">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>
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
@endpush
