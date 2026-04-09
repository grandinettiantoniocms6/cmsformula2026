@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
  ];
  $enhancedCrudNeedles = [
    'websiteSetting',
    'adminBlock',
    'adminPlugin',
    'adminTemplate',
    'admin-thumb',
    'adminLanguage',
    'userNavigation',
    'label',
    'block-page',
    'pluginProductsBrands',
    'pluginProductsCategories',
    'pluginProductsAttributes',
    'pluginProductsContacts',
    'pluginProductsRequests',
    'plugin-product-import',
    'pluginProductsSettings',
    'shopSettings',
    'pluginTutorial',
    'shopOrders',
    'shopOrdersRequests',
    'pluginProductsClients',
    'shopPayments',
    'shopShippings',
    'shopOrdersStatus',
    'shopCountries',
    'shopAreas',
    'shopTaxes',
    'shopCartRules',
    'shopPromotions',
    'shopAttributes',
    'shopAttributesOptions',
    'shop-extra',
  ];
  $isEnhancedCrudList = false;
  $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
  $routeProbe = (string) ($crud->route ?? '');
  $pathProbe = (string) request()->path();
  $routeController = request()->route() ? request()->route()->getController() : null;
  $controllerName = $routeController ? class_basename(get_class($routeController)) : '';
  $isPluginController = stripos($controllerName, 'Plugin') !== false;
  foreach ($enhancedCrudNeedles as $needle) {
      if (stripos($routeProbe, $needle) !== false || stripos($pathProbe, $needle) !== false) {
          $isEnhancedCrudList = true;
          break;
      }
  }
  if (!$isEnhancedCrudList && $isPluginController) {
      $isEnhancedCrudList = true;
  }
  $isEnhancedCrudList = $isEnhancedCrudList && $isModernAdminTemplate;

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

  $vCheckSlug = [];
  if($crud->model->getTable() == "plugins_products_categories"){
       $dashboard_class = new \App\Http\Controllers\Admin\DashboardController();
       $vCheckSlug = $dashboard_class->check_duplicate_slug($crud->model->getTable());
  }

@endphp

@section('header')
  <div class="{{ $isEnhancedCrudList ? 'enhanced-crud-list-header-shell' : '' }}">
    <h3 class="page-title mb-0">
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h3>
  </div>
@endsection

@section('content')
  <div id="modal" class="modal fade modal-fullscreen"></div>
  <!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }}">
        @if(count($vCheckSlug) > 0)
            <p>
                <a class="btn btn-danger" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    ATTENZIONE: Ci sono permalik duplicati!
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    @foreach($vCheckSlug as $html)
                        {!! $html !!}
                    @endforeach
                </div>
            </div>
        @endif

        <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }} {{ $isEnhancedCrudList ? 'enhanced-crud-list-toolbar' : '' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

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

        <table id="crudTable" class="bg-white table table-sm table-striped table-hover nowrap rounded border-xs mt-2" cellspacing="0">
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

  @if($isEnhancedCrudList)
    <style>
      .enhanced-crud-list-header-shell {
        background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
        border: 1px solid #dae5fb;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 14px;
        box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
      }

      .enhanced-crud-list-header-shell .page-title {
        color: #182f59;
        font-weight: 700;
        display: flex;
        align-items: baseline;
        gap: 10px;
        flex-wrap: wrap;
      }

      .enhanced-crud-list-header-shell #datatable_info_stack {
        color: #5e7097;
        font-weight: 600;
        font-size: .9rem;
      }

      .enhanced-crud-list-toolbar {
        background: #f8faff;
        border: 1px solid #e2e9f7;
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 8px 18px rgba(21, 39, 75, 0.06);
      }

      .enhanced-crud-list-toolbar .btn,
      .enhanced-crud-list-toolbar .dropdown .btn {
        border-radius: 9px;
        font-weight: 700;
        box-shadow: none;
      }

      #datatable_search_stack .dataTables_filter {
        display: flex;
        justify-content: flex-end;
      }

      #datatable_search_stack .dataTables_filter label {
        margin: 0;
        width: 100%;
        max-width: 320px;
      }

      #datatable_search_stack .dataTables_filter input {
        width: 100% !important;
        min-height: 40px;
        border-radius: 999px;
        border: 1px solid #d6dfef;
        padding: 0 14px;
        box-shadow: inset 0 1px 2px rgba(19, 39, 76, 0.04);
      }

      #datatable_search_stack .dataTables_filter input:focus {
        border-color: #8ea8dc;
        box-shadow: 0 0 0 3px rgba(66, 116, 214, 0.12);
        outline: none;
      }

      #crudTable {
        border: 1px solid #e1e8f5 !important;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 12px 26px rgba(18, 34, 71, 0.08);
        margin-top: 14px !important;
      }

      #crudTable thead th {
        background: #f5f8ff;
        color: #23345f;
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .03em;
        border-bottom: 1px solid #dfe7f6;
      }

      #crudTable tbody tr:nth-child(odd) {
        background: #fcfdff;
      }

      #crudTable tbody tr:nth-child(even) {
        background: #f6f8fc;
      }

      #crudTable tbody tr:hover {
        background: #eaf0ff !important;
      }

      #crudTable tbody td {
        border-top: 1px solid #e7ecf7;
        color: #2f3d62;
        vertical-align: middle;
      }

      #crudTable .btn,
      #crudTable .dropdown .btn {
        border-radius: 8px;
        font-weight: 600;
        box-shadow: none;
      }

      @if($isModernAdminTemplate02)
      .enhanced-crud-list-header-shell {
        background:
          radial-gradient(520px 170px at 8% -40%, rgba(57, 140, 255, .18), transparent 70%),
          linear-gradient(160deg, #ffffff 0%, #f4f8ff 100%);
        border: 1px solid #d7e5fb;
        box-shadow: 0 12px 28px rgba(25, 67, 141, .12);
      }

      .enhanced-crud-list-header-shell .page-title,
      .enhanced-crud-list-header-shell #datatable_info_stack {
        color: #284673;
      }

      .enhanced-crud-list-toolbar {
        background: #f6f9ff;
        border: 1px solid #d8e5fb;
        box-shadow: 0 10px 22px rgba(25, 67, 141, .08);
      }

      .enhanced-crud-list-toolbar .btn,
      .enhanced-crud-list-toolbar .dropdown .btn {
        border-color: #cddfff;
      }

      #crudTable {
        border-color: #d7e5fb !important;
        box-shadow: 0 14px 30px rgba(25, 67, 141, .1);
      }

      #crudTable thead th {
        background: linear-gradient(120deg, #f8fbff 0%, #edf4ff 100%);
      }
      @endif
    </style>
  @endif
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

  <script type="text/javascript">
      //select all checkboxes
      $("#select_all").change(function(){  //"select all" change
          var status = this.checked; // "select all" checked status
          $('.checkbox').each(function(){ //iterate all listed checkbox items
              this.checked = status; //change ".checkbox" checked status
          });
      });

      $('.checkbox').change(function(){ //".checkbox" change
          //uncheck "select all", if one of the listed checkbox item is unchecked
          if(this.checked == false){ //if this item is unchecked
              $("#select_all")[0].checked = false; //change "select all" checked status to false
          }

          //check "select all" if all checkbox items are checked
          if ($('.checkbox:checked').length == $('.checkbox').length ){
              $("#select_all")[0].checked = true; //change "select all" checked status to true
          }
      });

      $('.select2').select2({
          width: '100%'
      });
  </script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection
