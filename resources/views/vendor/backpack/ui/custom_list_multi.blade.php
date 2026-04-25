@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
    $isBlockList = request()->has('block');
@endphp

@php
$showDropzone = 0;
$itemBlock = null;
if(request()->has('block')){
    $adminBlock = \App\Models\AdminBlock::where("name", request()->get('block'))->first();
    $itemBlock = \DB::table($adminBlock->name_table)->where("id", request()->get('block_id'))->first();

    if($adminBlock->name_table == "blocks_gallerys"){
        $showDropzone = 1;
    }
}
@endphp

@section('header')
    <div class="blocks-list-header-shell">
        <h3 class="page-title mb-0">
         <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}
             @if($itemBlock) <span class="badge badge-secondary block-name-badge">{{ $itemBlock->name }}</span> @endif
         </span>
         <small id="datatable_info_stack"></small>
        </h3>
    </div>
@endsection

@section('content')
  <!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }}">
        <div class="modal fade" id="cartellaModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Cartella di destinazione</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <label class="mb-1 font-weight-bold">Percorso upload</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">uploads /</span>
                            </div>

                            <input type="text"
                                   id="cartellaName"
                                   class="form-control"
                                   placeholder="es. nomecartella (opzionale)">
                        </div>

                        <small class="form-text text-muted mt-2">
                            Se lasci vuoto, i file verranno caricati direttamente nella cartella <strong>uploads/</strong>.
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annulla
                        </button>
                        <button type="button" class="btn btn-primary" id="continuaCartella">
                            Continua
                        </button>
                    </div>

                </div>
            </div>
        </div>


        <form method="post" action="{{ route('actions') }}" id="formSave">
            {{ csrf_field() }}
            <input type="hidden" name="type" value="{{ request()->get('block') }}">

         <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())

              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }} blocks-list-toolbar">
                <a href="/admin/{{ request()->get('block') }}/create?block_id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}" class="btn btn-sm btn-dark" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> Aggiungi nuovo</span></a>
                @if($showDropzone)
                      <a href="/admin/dropzone?table={{ $adminBlock->name_table }}&id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}"
                         class="btn btn-sm btn-warning open-cartella-modal"
                         data-href="/admin/dropzone?table={{ $adminBlock->name_table }}&id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}"
                         id="btnAddMulti">
                          <i class="la la-plus"></i> Aggiungi multi
                      </a>

                  @endif
                <a href="/admin/{{ request()->get('block') }}/reorder?block_id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}" class="btn btn-sm btn-outline-dark" data-style="zoom-in"><span class="ladda-label"><i class="la la-arrows"></i> Riordina</span></a>

                  <div class="dropdown show d-inline-block">
                      <a class="btn btn-sm btn-success dropdown-toggle" href="#" role="button" id="esporta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Azioni</a>
                      <div class="dropdown-menu" aria-labelledby="esporta">
                          <button type="submit" class="dropdown-item" name="button" value="delete" form="formSave">Cancella</button>
                      </div>
                  </div>


                  <?php $page = \App\Models\Page::where("id", request()->get('page_id'))->first(); ?>
                  @if($page->slug == "/")
                      <a href="/" target="_blank" class="btn btn-sm btn-info">
                          <span><i class="la la-eye"></i></span>
                          <span class="d-none d-md-inline">Anteprima</span>
                      </a>
                  @else
                      <a href="/{{ $page->slug }}" target="_blank" class="btn btn-sm btn-info">
                          <span><i class="la la-eye"></i></span>
                          <span class="d-none d-md-inline">Anteprima</span>
                      </a>
                  @endif
                <a href="/admin/pages_blocks/{{ request()->get('page_id') }}" class="btn btn-sm btn-outline-dark" data-style="zoom-in"><span class="ladda-label"> < Torna alla pagina</span></a>
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
        </form>
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

  @if($isModernAdminTemplate)
  <style>
    .blocks-list-header-shell {
      background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
      border: 1px solid #dae5fb;
      border-radius: 14px;
      padding: 14px 16px;
      margin-bottom: 14px;
      box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
    }

    .blocks-list-header-shell .page-title {
      color: #182f59;
      font-weight: 700;
      display: flex;
      align-items: baseline;
      gap: 10px;
      flex-wrap: wrap;
    }

    .blocks-list-header-shell #datatable_info_stack {
      color: #5e7097;
      font-weight: 600;
      font-size: .9rem;
    }

    .blocks-list-header-shell .block-name-badge {
      border-radius: 999px;
      padding: 6px 11px;
      font-size: .78rem;
      font-weight: 700;
      background: #e8f0ff;
      color: #294f93;
      border: 1px solid #d0ddfa;
    }

    .blocks-list-toolbar {
      background: #f8faff;
      border: 1px solid #e2e9f7;
      border-radius: 12px;
      padding: 10px;
      box-shadow: 0 8px 18px rgba(21, 39, 75, 0.06);
    }

    .blocks-list-toolbar .btn,
    .blocks-list-toolbar .dropdown .btn {
      border-radius: 9px;
      font-weight: 700;
      box-shadow: none;
    }

    .blocks-list-toolbar .btn:hover {
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

    @media (max-width: 767px) {
      .blocks-list-toolbar {
        padding: 8px;
      }

      #datatable_search_stack .dataTables_filter {
        justify-content: flex-start;
        margin-top: 10px;
      }
    }

  </style>
  @endif

  @if($isFutureAdminTemplate && $isBlockList)
  <style>
    body.admin-future-template .main .table,
    body.admin-future-template .main #crudTable,
    body.admin-future-template .main #crudTable tbody,
    body.admin-future-template .main #crudTable tbody tr,
    body.admin-future-template .main #crudTable tbody td,
    body.admin-future-template .main .table-responsive,
    body.admin-future-template .main .dataTables_wrapper,
    body.admin-future-template .main .dataTables_wrapper .row,
    body.admin-future-template .main .dataTables_wrapper .col-sm-12 {
      overflow: visible !important;
    }

    body.admin-future-template .main #crudTable .dropdown-menu,
    body.admin-future-template .main .dataTables_wrapper .dropdown-menu {
      z-index: 1200 !important;
    }

    body.admin-future-template .main #crudTable .dropdown .btn.btn-dark.dropdown-toggle.btn-sm {
      min-height: 35px !important;
      padding: 0 8px !important;
      line-height: 1 !important;
      border-radius: 6px !important;
      background: #132048 !important;
      border-color: #132048 !important;
      color: #ffffff !important;
      box-shadow: none !important;
    }

    body.admin-future-template .main #crudTable .dropdown .btn.btn-dark.dropdown-toggle.btn-sm:hover,
    body.admin-future-template .main #crudTable .dropdown .btn.btn-dark.dropdown-toggle.btn-sm:focus,
    body.admin-future-template .main #crudTable .dropdown .btn.btn-dark.dropdown-toggle.btn-sm:active,
    body.admin-future-template .main #crudTable .dropdown.show .btn.btn-dark.dropdown-toggle.btn-sm {
      background: #132048 !important;
      border-color: #132048 !important;
      color: #ffffff !important;
      box-shadow: none !important;
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
  </script>

  <script>
      document.addEventListener('click', function (e) {

          const trigger = e.target.closest('.open-cartella-modal');
          if (!trigger) return;

          e.preventDefault();
          e.stopPropagation();

          const baseHref = trigger.dataset.href;
          const btnContinue = document.getElementById('continuaCartella');
          const inputCartella = document.getElementById('cartellaName');

          // reset input ogni apertura
          inputCartella.value = '';

          btnContinue.onclick = function () {
              const cartella = inputCartella.value.trim();
              let url = baseHref;

              // se l'input NON Ã¨ vuoto aggiungo il parametro
              if (cartella !== '') {
                  url += '&cartella=' + encodeURIComponent(cartella);
              }

              window.location.href = url;
          };

          $('#cartellaModal').modal('show');
      });
  </script>


@endsection
