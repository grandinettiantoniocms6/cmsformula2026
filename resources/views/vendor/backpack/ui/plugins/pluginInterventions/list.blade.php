@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

  $vCheckSlug = [];
@endphp

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h3>
@endsection

@section('content')
  <div id="modal" class="modal fade modal-fullscreen"></div>
  <!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }}">
        <form method="post" action="{{ route('pluginInterventions.actions') }}" id="formSave">
            {{ csrf_field() }}

        <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

                  <div class="dropdown show d-inline-block">
                      <a class="btn btn-sm btn-light dropdown-toggle" href="#" role="button" id="esporta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Azioni</a>
                      <div class="dropdown-menu" aria-labelledby="esporta">
                          <button type="submit" class="dropdown-item" name="button" value="download_pdf" form="formSave">Scarica PDF</button>
                          <button type="submit" class="dropdown-item" name="button" value="send_email" form="formSave">Invia Email</button>
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

      $(document).ready(function() {
          $(window).keydown(function(event){
              if(event.keyCode == 13) {
                  event.preventDefault();
                  return false;
              }
          });
      });

      function change_delivery(id, type){
          $.ajax({
              url: '{{ route('pluginInterventions.change_delivery') }}',
              method: 'POST',
              data: {
                  id: id,
                  type: type,
                  _token: '{{ csrf_token() }}'
              }, success: function (response) {
                   if(type == 1){
                       $("#delivery_"+id).html("<a href='javascript:change_delivery("+id+", 0)' class='text text-success'><i class=\"las la-list la-2x\"></i></a>");
                   }else{
                       $("#delivery_"+id).html("<a href='javascript:change_delivery("+id+", 1)' class='text text-dark'><i class=\"las la-list la-2x\"></i></a>");
                   }

              },error: function (data, textStatus, errorThrown) {
              },
          });
      }

      // Add change_priority by Antonio G.
      function change_annullato(id, type){
          $.ajax({
              url: '{{ route('pluginInterventions.change_annullato') }}',
              method: 'POST',
              data: {
                  id: id,
                  type: type,
                  _token: '{{ csrf_token() }}'
              }, success: function (response) {
                  if(type == 1){
                      $("#res-status-"+id).html(response.html);
                      $("#priority_"+id).html("<span class='text text-success'><i class=\"las la-trash la-2x\"></i></span>");
                  }else{
                      $("#res-status-"+id).html(response.html);
                      $("#priority_"+id).html("<a href='javascript:change_annullato("+id+", 1)' class='text text-dark'><i class=\"las la-trash la-2x\"></i></a>");
                  }

              },error: function (data, textStatus, errorThrown) {
              },
          });
      }
      // Fine change_priority by Antonio G.


  </script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection
