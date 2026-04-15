@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
@endphp

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

  $vCheckSlug = [];
  if($crud->model->getTable() == "plugins_products_categories"){
       $dashboard_class = new \App\Http\Controllers\Admin\DashboardController();
       $vCheckSlug = $dashboard_class->check_duplicate_slug($crud->model->getTable());
  }

@endphp

@section('header')
    <div class="users-list-header-shell">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small id="datatable_info_stack" class="users-list-subheading">{!! $crud->getSubheading() ?? '' !!}</small>
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
            <div class="alert alert-danger mb-1">Ci sono permalink duplicati! <a class="text-white text-decoration-underline" data-toggle="modal" href="#modal-alert" role="button" aria-expanded="false">Scopri</a></div>
            <div class="modal fade" id="modal-alert" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="uil uil-exclamation-triangle mr-2"></i> Permalink Duplicati</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="uil uil-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach($vCheckSlug as $html)
                                {!! $html !!}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }} users-list-toolbar">

                @include('crud::inc.button_stack', ['stack' => 'top'])

                  <div class="dropdown d-inline-block show">
                      <a class="btn btn-success btn-sm dropdown-toggle" href="#" role="button" id="esporta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Azioni
                      </a>

                      <div class="dropdown-menu" aria-labelledby="esporta">
                          <button type="submit" class="dropdown-item" name="button" value="delete" form="formSave">Cancella</button>
                      </div>
                  </div>

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

            <div class="users-list-panel">
            <form method="post" action="{{ route('users.actions') }}" id="formSave">
                {{ csrf_field() }}

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

            </form>
            </div>

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

  @if($isModernAdminTemplate)
  <style>
    .users-list-header-shell {
      background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
      border: 1px solid #dae5fb;
      border-radius: 14px;
      padding: 14px 16px;
      margin-bottom: 14px;
      box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
    }

    .users-list-header-shell .page-title {
      color: #182f59;
      font-weight: 700;
      display: flex;
      align-items: baseline;
      gap: 10px;
      flex-wrap: wrap;
    }

    .users-list-header-shell #datatable_info_stack {
      color: #5e7097;
      font-weight: 600;
      font-size: .9rem;
    }

    .users-list-panel {
      margin-top: 10px;
      border: 1px solid #dfe7f6;
      border-radius: 14px;
      background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%);
      padding: 10px 10px 6px;
      box-shadow: 0 10px 24px rgba(15, 34, 70, 0.08);
    }

    .users-list-toolbar {
      background: #f8faff;
      border: 1px solid #e2e9f7;
      border-radius: 12px;
      padding: 10px;
      box-shadow: 0 8px 18px rgba(21, 39, 75, 0.06);
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }

    .users-list-toolbar .btn,
    .users-list-toolbar .dropdown .btn {
      border-radius: 9px;
      font-weight: 700;
      box-shadow: none;
    }

    .users-list-toolbar .btn:hover {
      transform: translateY(-1px);
      transition: transform .12s ease;
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

    /* Pulsanti azione riga (Modifica/Elimina/...) in stile moderno */
    #crudTable td .btn.btn-sm,
    #crudTable td a.btn.btn-sm {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      min-height: 30px;
      padding: .26rem .62rem;
      border-radius: 999px;
      border: 1px solid #d7e2f3;
      background: #f6f9ff;
      color: #1f3d70;
      font-weight: 700;
      font-size: .75rem;
      line-height: 1;
      text-decoration: none;
      transition: all .16s ease;
    }

    #crudTable td .btn.btn-sm:hover,
    #crudTable td a.btn.btn-sm:hover {
      background: #eaf1ff;
      border-color: #bed0ef;
      color: #16335e;
      transform: translateY(-1px);
      text-decoration: none;
    }

    #crudTable td .btn.btn-sm:focus,
    #crudTable td a.btn.btn-sm:focus {
      box-shadow: 0 0 0 3px rgba(73, 118, 203, .16);
      outline: none;
    }

    #crudTable td .btn.btn-sm i,
    #crudTable td a.btn.btn-sm i {
      font-size: .92rem;
    }

    #crudTable td .btn.btn-sm.text-danger,
    #crudTable td a.btn.btn-sm.text-danger {
      background: #fff6f6;
      border-color: #f2caca;
      color: #b43a3a;
    }

    #crudTable td .btn.btn-sm.text-danger:hover,
    #crudTable td a.btn.btn-sm.text-danger:hover {
      background: #ffecec;
      border-color: #e7b2b2;
      color: #962f2f;
    }

    .users-list-toolbar .btn-success {
      border: 1px solid #2f9864;
      background: linear-gradient(180deg, #35b173 0%, #2f9f68 100%);
      color: #fff;
    }

    .users-list-toolbar .btn-success:hover {
      background: linear-gradient(180deg, #2ea567 0%, #298f5a 100%);
      border-color: #298f5a;
      color: #fff;
    }

    #crudTable .dropdown-menu {
      border-radius: 12px;
      border: 1px solid #dde6f6;
      box-shadow: 0 14px 24px rgba(18, 34, 71, 0.12);
    }

    @if($isModernAdminTemplate02)
    .users-list-header-shell {
      background:
        radial-gradient(460px 160px at 6% -35%, rgba(86, 137, 242, .14), transparent 70%),
        linear-gradient(180deg, #ffffff 0%, #f3f7ff 100%);
      border-color: #d5e3fb;
      box-shadow: 0 10px 24px rgba(31, 74, 153, 0.10);
    }

    .users-list-panel {
      border-color: #d5e3fb;
      background: linear-gradient(180deg, #ffffff 0%, #f4f8ff 100%);
      box-shadow: 0 12px 24px rgba(31, 74, 153, 0.10);
    }

    .users-list-toolbar {
      background: #f4f8ff;
      border-color: #d7e5fc;
      box-shadow: 0 8px 20px rgba(31, 74, 153, 0.09);
    }

    #crudTable td .btn.btn-sm,
    #crudTable td a.btn.btn-sm {
      border-color: #cfe0fb;
      background: #f1f6ff;
      color: #21467d;
    }

    #crudTable td .btn.btn-sm:hover,
    #crudTable td a.btn.btn-sm:hover {
      background: #e3eeff;
      border-color: #b8d0f5;
      color: #173a6d;
    }
    @endif

    @media (max-width: 767px) {
      .users-list-toolbar {
        padding: 8px;
      }

      #datatable_search_stack .dataTables_filter {
        justify-content: flex-start;
        margin-top: 10px;
      }

      .users-list-panel {
        padding: 8px 8px 4px;
      }
    }
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
