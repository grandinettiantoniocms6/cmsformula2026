@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
  ];
  $isEnhancedCrudCreate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="{{ $isEnhancedCrudCreate ? 'enhanced-crud-create-header-shell' : '' }}">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small></small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}?block_id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}" class="d-print-none font-sm">
                        <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h3>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="{{ $crud->getCreateContentClass() }}">
        @include('crud::inc.grouped_errors')

        <form method="post" class="mb-5 pb-4"
              action="{{ url($crud->route) }}"
              @if ($crud->hasUploadFields('create'))
              enctype="multipart/form-data"
              @endif
        >
            {!! csrf_field() !!}
            @if(view()->exists('vendor.backpack.crud.form_content'))
                @include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
            @else
                @include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
            @endif

            @if(isset($saveAction['active']) && !is_null($saveAction['active']['value']))
                <div id="saveActions" class="form-group">
                    <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">
                    @if(!empty($saveAction['options']))
                        <div class="btn-group" role="group">
                    @endif

                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span data-value="{{ $saveAction['active']['value'] }}">{{ $saveAction['active']['label'] }}</span>
                    </button>

                    <div class="btn-group" role="group">
                        @if(!empty($saveAction['options']))
                            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">&#x25BC;</span></button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                @foreach( $saveAction['options'] as $value => $label)
                                    <a class="dropdown-item" href="javascript:void(0);" data-value="{{ $value }}">{{ $label }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if(!empty($saveAction['options']))
                        </div>
                    @endif
                    @if(!$crud->hasOperationSetting('showCancelButton') || $crud->getOperationSetting('showCancelButton') == true)
                        <a href="{{ $crud->hasAccess('list') ? url($crud->route) : url()->previous() }}?block_id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}" class="btn btn-default"><span class="la la-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
                    @endif
                </div>
            @endif
        </form>
    </div>
</div>
@endsection

@push('after_scripts')
    <script type="text/javascript">
        $('#title_page').on('input', function() {
            $.ajax({
                url: '{{ route('sanitize_string') }}',
                method: 'POST',
                data: {
                    string: $("#title_page").val(),
                    _token: '{{ csrf_token() }}'
                }, success: function (response) {
                    $("#slug_it").val(response.string);
                },error: function (data, textStatus, errorThrown) {
                },
            });
        });

        $('#title_it').on('input', function() {
            $.ajax({
                url: '{{ route('sanitize_string') }}',
                method: 'POST',
                data: {
                    string: $("#title_it").val(),
                    _token: '{{ csrf_token() }}'
                }, success: function (response) {
                    $("#slug_it").val(response.string);
                },error: function (data, textStatus, errorThrown) {
                },
            });
        });
    </script>
@endpush

@if($isEnhancedCrudCreate)
    @push('after_styles')
        <style>
            .enhanced-crud-create-header-shell {
                background: linear-gradient(130deg, #ffffff 0%, #f4f8ff 100%);
                border: 1px solid #dbe6fb;
                border-radius: 14px;
                padding: 14px 16px;
                box-shadow: 0 8px 22px rgba(24, 43, 81, 0.08);
                margin-bottom: 12px;
            }

            .enhanced-crud-create-header-shell .page-title {
                display: flex;
                align-items: baseline;
                gap: 10px;
                flex-wrap: wrap;
                color: #182f59;
                font-weight: 700;
            }

            .enhanced-crud-create-header-shell .page-title small {
                color: #607197;
                font-weight: 600;
            }

            .enhanced-crud-create-header-shell .page-title small a {
                color: #3b5d9f;
                font-weight: 700;
            }

            .enhanced-crud-create-header-shell .page-title small a:hover {
                color: #2b4d8d;
                text-decoration: none;
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

            .container-fluid .input-group .btn {
                border-radius: 9px;
                font-weight: 700;
            }

            .container-fluid .btn-success,
            .container-fluid .btn-primary {
                border-radius: 10px;
                font-weight: 700;
                box-shadow: 0 8px 18px rgba(14, 36, 79, 0.14);
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

            @if($isModernAdminTemplate02)
            .enhanced-crud-create-header-shell {
                background:
                    radial-gradient(520px 160px at 8% -40%, rgba(57, 140, 255, .18), transparent 70%),
                    linear-gradient(160deg, #ffffff 0%, #f4f8ff 100%);
                border: 1px solid #d7e5fb;
                box-shadow: 0 12px 28px rgba(25, 67, 141, .12);
            }

            .enhanced-crud-create-header-shell .page-title,
            .enhanced-crud-create-header-shell .page-title small,
            .enhanced-crud-create-header-shell .page-title small a {
                color: #284673;
            }

            .container-fluid .form-control,
            .container-fluid .select2-container--bootstrap .select2-selection {
                border-color: #ccddf9;
            }

            .container-fluid .btn-success,
            .container-fluid .btn-primary {
                box-shadow: 0 10px 22px rgba(31, 77, 158, .18);
            }
            @endif
        </style>
    @endpush
@endif
