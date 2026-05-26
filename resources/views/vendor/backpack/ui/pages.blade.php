@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
@endphp

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

  $dashboard_class = new \App\Http\Controllers\Admin\DashboardController();
  $vCheckSlug = $dashboard_class->check_duplicate_slug("pages");

  $pages_count = \App\Models\Page::count();
  $website = \App\Models\WebsiteSetting::first();
  $hasPageLimit = $website && (int) $website->number_max_page > 0;
  $number = $hasPageLimit ? (int) $website->number_max_page - $pages_count : null;
@endphp

@section('header')
    @if($isFutureAdminTemplate)
        <div class="future-pages-commandbar">
            <div class="future-pages-commandbar__left">
                <h3 class="page-title mb-0">
                    <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
                </h3>
                <small id="datatable_info_stack" class="future-pages-commandbar__meta">{!! $crud->getSubheading() ?? '' !!}</small>
            </div>
            @if(backpack_user()->roles[0]->id <= 3)
                @if($hasPageLimit)
                    <span class="pages-limit-chip {{ $number <= 0 ? 'pages-limit-chip-warning' : 'pages-limit-chip-ok' }}">
                        {{ $number > 0 ? "Puoi inserire ancora {$number} pagine" : 'Limite pagine raggiunto' }}
                    </span>
                @else
                    <span class="pages-limit-chip pages-limit-chip-unlimited">Pagine illimitate</span>
                @endif
            @endif
        </div>
    @else
        <div class="pages-header-shell">
            <h3 class="page-title mb-1">
                <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
                <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
            </h3>

            @if(backpack_user()->roles[0]->id <= 3)
                @if($hasPageLimit)
                    <span class="pages-limit-chip {{ $number <= 0 ? 'pages-limit-chip-warning' : 'pages-limit-chip-ok' }}">
                        {{ $number > 0 ? "Puoi inserire ancora {$number} pagine" : 'Limite pagine raggiunto' }}
                    </span>
                @else
                    <span class="pages-limit-chip pages-limit-chip-unlimited">Pagine illimitate</span>
                @endif
            @endif
        </div>
    @endif
@endsection

@section('content')

  @if($hasPageLimit && $number <= 0)
     <div class="alert alert-warning-light pages-limit-alert">Hai raggiunto il limite di pagine acquistato. Per sbloccare il limite contatta Webisland.</div>
  @endif

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



  <!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }} {{ $isFutureAdminTemplate ? 'future-pages-shell' : '' }}">
        <div class="row mb-0 {{ $isFutureAdminTemplate ? 'future-pages-toolbar' : '' }}">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }} {{ $isFutureAdminTemplate ? 'future-pages-toolbar__buttons' : '' }}">
                @if(backpack_user()->roles[0]->id <= 3)
                   @include('crud::inc.button_stack', ['stack' => 'top'])
                @endif
              </div>
            @endif
          </div>
          <div class="col-sm-6">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none {{ $isFutureAdminTemplate ? 'future-pages-toolbar__search' : '' }}"></div>
          </div>
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif

        <table id="crudTable" class="bg-white table {{ $isFutureAdminTemplate ? 'table-borderless future-pages-table' : 'table-striped table-hover' }} nowrap rounded shadow-xs border-xs mt-2" cellspacing="0">
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

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')

  <style>
    .page-inline-actions {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      margin-left: 8px;
      vertical-align: middle;
    }

    .page-tree-name {
      display: inline-flex;
      align-items: center;
      min-height: 26px;
      position: relative;
      vertical-align: middle;
    }

    .page-tree-name--child {
      margin-left: 28px;
      padding-left: 24px;
    }

    .page-tree-name--child::before,
    .page-tree-name--child::after {
      content: "";
      position: absolute;
      left: 0;
      background: #b8c8e8;
    }

    .page-tree-name--child::before {
      top: -18px;
      bottom: -18px;
      width: 1px;
    }

    .page-tree-name--child-first::before {
      top: -39px;
    }

    .page-tree-name--child-last::before {
      bottom: 50%;
    }

    .page-tree-name--child::after {
      top: 50%;
      width: 18px;
      height: 1px;
      transform: translateY(-50%);
    }

    .page-tree-name__label {
      display: inline-block;
    }

    #crudTable tbody td {
      padding-top: .4rem;
      padding-bottom: .4rem;
    }

    .page-inline-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 22px;
      height: 22px;
      border: 1px solid #d9dee7;
      border-radius: 4px;
      color: #4c5a6f;
      background: #fff;
      line-height: 1;
      text-decoration: none;
      transition: color .12s ease, border-color .12s ease, background-color .12s ease;
    }

    .page-inline-action:hover {
      color: #1f3f79;
      border-color: #b8c8e8;
      background: #f4f8ff;
      text-decoration: none;
    }

    .page-inline-action i {
      font-size: 14px;
      line-height: 1;
    }
  </style>

  @if($isModernAdminTemplate)
  <style>
    .pages-header-shell {
      background: linear-gradient(120deg, #ffffff 0%, #f2f6ff 100%);
      border: 1px solid #d9e4ff;
      border-radius: 14px;
      padding: 16px 18px;
      margin-bottom: 18px;
      box-shadow: 0 8px 24px rgba(22, 44, 87, 0.08);
    }

    .pages-header-shell .page-title {
      font-weight: 700;
      color: #162c57;
      display: flex;
      align-items: baseline;
      gap: 10px;
      flex-wrap: wrap;
    }

    .pages-header-shell #datatable_info_stack {
      color: #526186;
      font-size: .9rem;
      margin: 0;
      font-weight: 500;
    }

    .pages-limit-chip {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      padding: 6px 12px;
      background: #eaf1ff;
      color: #1f3f79;
      font-size: .85rem;
      font-weight: 600;
      border: 1px solid #cfddff;
    }

    .d-print-none.with-border .btn,
    .d-print-none.with-border .btn-group .btn {
      border-radius: 10px;
      font-weight: 600;
      box-shadow: 0 8px 16px rgba(16, 36, 78, 0.12);
      transition: transform .12s ease, box-shadow .12s ease;
    }

    .d-print-none.with-border .btn:hover,
    .d-print-none.with-border .btn-group .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 18px rgba(16, 36, 78, 0.16);
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
      border: 1px solid #d7deee;
      border-radius: 999px;
      min-height: 40px;
      padding: 0 14px;
      box-shadow: inset 0 1px 2px rgba(19, 38, 75, 0.05);
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

    @media (max-width: 767px) {
      .pages-header-shell {
        padding: 14px;
      }

      #datatable_search_stack .dataTables_filter {
        justify-content: flex-start;
        margin-top: 10px;
      }
    }
  </style>
  @endif
  @if($isFutureAdminTemplate)
  <style>
    .future-pages-commandbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
      border: 1px solid #dce7fb;
      border-radius: 14px;
      background: #ffffff;
      padding: 12px 14px;
      margin-bottom: 12px;
      box-shadow: 0 8px 18px rgba(13, 34, 74, .07);
    }

    .future-pages-commandbar .page-title {
      color: #1e3762;
      font-weight: 800;
      display: flex;
      align-items: baseline;
      gap: 8px;
      flex-wrap: wrap;
    }

    .future-pages-commandbar__meta {
      color: #5d7299;
      font-size: .85rem;
      font-weight: 600;
      display: block;
      margin-top: 2px;
    }

    .future-pages-commandbar .pages-limit-chip {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      padding: .28rem .68rem;
      background: #edf4ff;
      border: 1px solid #d0def7;
      color: #31558e;
      font-size: .78rem;
      font-weight: 700;
      white-space: nowrap;
    }

    .future-pages-commandbar .pages-limit-chip-ok {
      background: #ecfbf3;
      border-color: #bfe8d1;
      color: #207d50;
    }

    .future-pages-commandbar .pages-limit-chip-warning {
      background: #fff4e8;
      border-color: #f0d1ad;
      color: #9b5a18;
    }

    .future-pages-commandbar .pages-limit-chip-unlimited {
      background: #edf4ff;
      border-color: #d0def7;
      color: #31558e;
    }

    body.admin-future-template .pages-limit-alert {
      border: 1px solid #f0d1ad;
      border-radius: 10px;
      background: #fff7ed;
      color: #8d5018;
      font-weight: 700;
      box-shadow: 0 6px 14px rgba(133, 79, 25, .08);
    }

    .future-pages-shell .future-pages-toolbar {
      border: 1px solid #dce7fb;
      border-radius: 12px;
      background: #ffffff;
      padding: 10px 12px;
      margin: 0 0 10px;
      box-shadow: 0 6px 14px rgba(13, 34, 74, .05);
      align-items: center;
    }

    .future-pages-shell .future-pages-toolbar__buttons .btn,
    .future-pages-shell .future-pages-toolbar__buttons .btn-group .btn {
      border-radius: 8px !important;
      font-weight: 300;
      min-height: 34px;
      padding: .34rem .82rem;
      box-shadow: none;
    }

    .future-pages-shell .future-pages-toolbar__search .dataTables_filter {
      display: flex;
      justify-content: flex-end;
      margin: 0;
    }

    .future-pages-shell .future-pages-toolbar__search .dataTables_filter label {
      margin: 0;
      width: 100%;
      max-width: 280px;
    }

    .future-pages-shell .future-pages-toolbar__search .dataTables_filter input {
      width: 100% !important;
      border: 1px solid #d5e2f8;
      border-radius: 10px;
      min-height: 36px;
      padding: 0 .72rem;
      background: #fdfefe;
      color: #2b4779;
      font-weight: 600;
      box-shadow: none;
    }

    .future-pages-shell .future-pages-toolbar__search .dataTables_filter input:focus {
      outline: none;
      border-color: #9fb8e4;
      box-shadow: 0 0 0 3px rgba(66, 114, 199, .12);
    }

    .future-pages-shell #crudTable.future-pages-table {
      border: 1px solid #dce7fb !important;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 12px 24px rgba(13, 34, 74, .06);
      margin-top: 10px !important;
    }

    .future-pages-shell #crudTable.future-pages-table thead th {
      background: #f4f8ff;
      color: #233f70;
      font-size: .77rem;
      font-weight: 700;
      letter-spacing: .02em;
      text-transform: uppercase;
      border-bottom: 1px solid #dce7fb;
    }

    .future-pages-shell #crudTable.future-pages-table tbody tr:nth-child(odd) {
      background: #ffffff;
    }

    .future-pages-shell #crudTable.future-pages-table tbody tr:nth-child(even) {
      background: #f8fbff;
    }

    .future-pages-shell #crudTable.future-pages-table tbody tr:hover {
      background: #edf4ff !important;
    }

    .future-pages-shell #crudTable.future-pages-table tbody td {
      color: #2b4779;
      border-top: 1px solid #e6eefb;
      vertical-align: middle;
    }

    .future-pages-shell #crudTable.future-pages-table .dropdown .btn,
    .future-pages-shell #crudTable.future-pages-table .btn {
      border-radius: 8px !important;
      font-weight: 300 !important;
      font-size: .88rem !important;
      box-shadow: none;
    }

    body.admin-future-template .future-pages-shell .future-pages-toolbar .d-print-none.with-border .btn,
    body.admin-future-template .future-pages-shell .future-pages-toolbar__buttons .btn,
    body.admin-future-template .future-pages-shell .future-pages-toolbar__buttons .btn-group .btn,
    body.admin-future-template .future-pages-shell #crudTable.future-pages-table .dropdown-toggle.btn,
    body.admin-future-template .future-pages-shell #crudTable.future-pages-table .dropdown .btn,
    body.admin-future-template .future-pages-shell #crudTable.future-pages-table .btn {
      border-radius: 8px !important;
      font-weight: 300 !important;
      font-size: .88rem !important;
    }

    @media (max-width: 991.98px) {
      .future-pages-shell .future-pages-toolbar__search .dataTables_filter {
        justify-content: flex-start;
        margin-top: 8px;
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

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection
