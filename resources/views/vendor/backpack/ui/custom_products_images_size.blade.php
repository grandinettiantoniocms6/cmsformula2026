@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;


@endphp

@section('header')
    <?php $product = \App\Models\PluginProducts::where("id", request()->get('id'))->first(); ?>
    <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!} <span class="label label-info">
                    @if($product)
                        {{ $product->name }}
                    @else
                        Tutti i prodotti
                    @endif
                </span> </span>
        <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>

        @if($product->is_variant == 0)
            <small><a href="/admin/pluginProducts" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Torna alla lista prodotti</a></small>
        @else
            <small><a href="/admin/shopProductsVariants?group_id={{ $product->group_id }}" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Torna alla lista varianti</a></small>
        @endif

    </h3>
@endsection

@section('content')
    <div id="modal" class="modal fade modal-fullscreen"></div>
    <!-- Default box -->
    <div class="row">

        <!-- THE ACTUAL CONTENT -->
        <div class="{{ $crud->getListContentClass() }}">

            <div class="row mb-0">
                <div class="col-sm-6">
                    @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                        <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">
                            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                                <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">
                                    <a href="/admin/pluginProductsImagesSize/create?id={{ request()->get('id') }}" class="btn btn-primary btn-sm" data-style="zoom-in">
                                        <span class="ladda-label"><i class="la la-plus"></i> Aggiungi foto</span>
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none"></div>
                </div>
            </div>

            {{-- Backpack List Filters --}}
            @if ($crud->filtersEnabled())
                @include('crud::inc.filters_navbar')
            @endif

            <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2" cellspacing="0">
                <thead>
                <tr>
                    {{-- Table columns --}}
                    @foreach ($crud->columns() as $column)
                        <th
                            data-orderable="{{ var_export($column['orderable'], true) }}"
                            data-priority="{{ $column['priority'] }}"
                            {{--

                               data-visible-in-table => if developer forced field in table with 'visibleInTable => true'
                               data-visible => regular visibility of the field
                               data-can-be-visible-in-table => prevents the column to be loaded into the table (export-only)
                               data-visible-in-modal => if column apears on responsive modal
                               data-visible-in-export => if this field is exportable
                               data-force-export => force export even if field are hidden

                           --}}

                            {{-- If it is an export field only, we are done. --}}
                            @if(isset($column['exportOnlyField']) && $column['exportOnlyField'] === true)
                            data-visible="false"
                            data-visible-in-table="false"
                            data-can-be-visible-in-table="false"
                            data-visible-in-modal="false"
                            data-visible-in-export="true"
                            data-force-export="true"
                            @else
                            data-visible-in-table="{{var_export($column['visibleInTable'] ?? false)}}"
                            data-visible="{{var_export($column['visibleInTable'] ?? true)}}"
                            data-can-be-visible-in-table="true"
                            data-visible-in-modal="{{var_export($column['visibleInModal'] ?? true)}}"
                            @if(isset($column['visibleInExport']))
                            @if($column['visibleInExport'] === false)
                            data-visible-in-export="false"
                            data-force-export="false"
                            @else
                            data-visible-in-export="true"
                            data-force-export="true"
                            @endif
                            @else
                            data-visible-in-export="true"
                            data-force-export="false"
                            @endif
                            @endif
                        >
                            {!! $column['label'] !!}
                        </th>
                    @endforeach

                    @if ( $crud->buttons()->where('stack', 'line')->count() )
                        <th data-orderable="false"
                            data-priority="{{ $crud->getActionsColumnPriority() }}"
                            data-visible-in-export="false"
                        >{{ trans('backpack::crud.actions') }}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    {{-- Table columns --}}
                    @foreach ($crud->columns() as $column)
                        <th>{!! $column['label'] !!}</th>
                    @endforeach

                    @if ( $crud->buttons()->where('stack', 'line')->count() )
                        <th>{{ trans('backpack::crud.actions') }}</th>
                    @endif
                </tr>
                </tfoot>
            </table>

            @if ( $crud->buttons()->where('stack', 'bottom')->count() )
                <div id="bottom_buttons" class="d-print-none text-center text-sm-left">
                    @include('crud::inc.button_stack', ['stack' => 'bottom'])

                    <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
                </div>
            @endif

        </div>

    </div>

@endsection

@section('after_styles')
    <!-- DATA TABLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/list.css') }}">

    <link href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('packages/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.css') }}">
    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    @include('crud::inc.datatables_logic')
    <script src="{{ asset('packages/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/list.js') }}"></script>

    <script src="{{ asset('packages/select2/dist/js/select2.full.js') }}"></script>

    <script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('packages/bootstrap-datepicker/dist/locales/bootstrap-datepicker.it.min.js') }}"></script>

    <script src="{{ asset('packages/summernote/dist/summernote-bs4.min.js') }}"></script>

    <script type="text/javascript">
        function edit_prenotazione(id) {
            $.post('/admin/pluginOrders/planning/open_reservation', {id: id}).done(function (data) {
                $('#modal').html(data.modal);
                $('#modal').modal('show');
            }).fail(function () {
                swal('Prenotazione', 'Errore generico', 'danger')
            });
        }
    </script>

    <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
    @stack('crud_list_scripts')
@endsection
