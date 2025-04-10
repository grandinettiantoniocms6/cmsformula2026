@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

  $vCheckSlug = [];
  if($crud->model->getTable() == "plugins_products"){
       $dashboard_class = new \App\Http\Controllers\Admin\DashboardController();
       $vCheckSlug = $dashboard_class->check_duplicate_slug($crud->model->getTable());
  }
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
        <form method="post" action="{{ route('pluginCaccia.actions') }}" id="formSave">
            {{ csrf_field() }}

            <div id="set-points" class="modal">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content validation">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title">Aggiungi/Elimina Punti</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="fa fa-close"></i>
                            </button>
                        </div>
                        <div class="modal-body bold-labels p-4">

                            <div class="form-group d-block">
                                <div class="form-group form-groups-resources">
                                    <div class="row align-items-center mb-2">
                                        <div class="col font-600">Punti</div>
                                        <div class="col-auto">
                                        </div>
                                    </div>

                                    <input type="text" class="form-control" name="point">
                                </div>
                            </div>

                            <div class="form-group d-block">
                                <div class="form-group form-groups-resources">
                                    <div class="row align-items-center mb-2">
                                        <div class="col font-600">Nota</div>
                                        <div class="col-auto">
                                        </div>
                                    </div>

                                    <input type="text" class="form-control" name="note">
                                </div>
                            </div>

                            <?php
                            $chiefs = \App\Models\PluginCacciaChiefs::get();
                            ?>

                            @if($chiefs)
                                <div class="form-group d-block">
                                    <div class="form-group form-groups-resources">
                                        <div class="row align-items-center mb-2">
                                            <div class="col font-600">Capo</div>
                                            <div class="col-auto">
                                            </div>
                                        </div>

                                        <select class="form-control select2" name="chief_id">
                                            <option value=""></option>
                                            @foreach ($chiefs as $item)
                                                <option value="{{ $item->id }}">{{ $item->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group form-groups-resources">
                                <div class="row align-items-center mb-2">
                                    <div class="col font-600">Operazione</div>
                                    <div class="col-auto">
                                    </div>
                                </div>
                                <select class="form-control" name="type">
                                    <option value="1">Aggiungi</option>
                                    <option value="0">Elimina</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer px-4">
                            <button type="submit" class="btn btn-lg btn-success" form="formSave" name="button" value="points">Conferma</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="set-chiefs" class="modal">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content validation">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title">Aggiungi/Elimina Capi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="fa fa-close"></i>
                            </button>
                        </div>
                        <div class="modal-body bold-labels p-4">

                            <?php
                            $chiefs = \App\Models\PluginCacciaChiefs::get();
                            ?>

                            @if($chiefs)
                                <div class="form-group d-block">
                                    <div class="form-group form-groups-resources">
                                        <div class="row align-items-center mb-2">
                                            <div class="col font-600">Capo</div>
                                            <div class="col-auto">
                                            </div>
                                        </div>

                                        <select class="form-control select2" name="chief_id">
                                            @foreach ($chiefs as $item)
                                                <option value="{{ $item->id }}">{{ $item->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group form-groups-resources">
                                <div class="row align-items-center mb-2">
                                    <div class="col font-600">Data operazione</div>
                                    <div class="col-auto">
                                    </div>
                                </div>
                                <input class="form-control" name="date" type="date" value="{{ \Carbon\Carbon::now()->toDateString() }}" />
                            </div>

                            <div class="form-group form-groups-resources">
                                <div class="row align-items-center mb-2">
                                    <div class="col font-600">Stato</div>
                                    <div class="col-auto">
                                    </div>
                                </div>
                                <select class="form-control" name="status">
                                    <option value="0">In valutazione</option>
                                    <option value="1">Accettato</option>
                                    <option value="2">Rifiutato</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer px-4">
                            <button type="submit" class="btn btn-lg btn-success" form="formSave" name="button" value="chiefs">Conferma</button>
                        </div>
                    </div>
                </div>
            </div>

        <div class="row mb-0">
          <div class="col-sm-6">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

                  <div class="row no-gutters my-3">

                      <div class="col-auto mr-1">
                          <div class="dropdown show">
                              <a class="btn btn-sm btn-light dropdown-toggle" href="#" role="button" id="esporta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Azioni</a>
                              <div class="dropdown-menu" aria-labelledby="esporta">
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#set-points">Punti</a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#set-chiefs">Capi</a>
                                  <button type="submit" class="dropdown-item" name="button" value="delete" form="formSave">Cancella</button>
                              </div>
                          </div>
                      </div>


                      @if(old('ok'))
                          <?php
                          $ok = old('ok');
                          ?>

                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalWarning">
                              {{ count($ok) }} OK
                          </button>

                          <div class="modal fade" id="exampleModalWarning" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Capi assegnati correttamente</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          @if($ok)
                                              <table width="100%">
                                                  <thead>
                                                  <th>Cacciatore</th>
                                                  </thead>
                                                  @foreach($ok as $id)
                                                      <?php
                                                      $hunter = \App\Models\PluginCacciaHunters::find($id);
                                                      ?>
                                                      <tr>
                                                          <td>{{ $hunter->first_name }} {{ $hunter->last_name }}</td>
                                                      </tr>
                                                  @endforeach
                                              </table>
                                          @endif
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endif

                      @if(old('ko'))
                          <?php
                          $ko = old('ko');
                          ?>

                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalWarning">
                              {{ count($ko) }} ERRORE
                          </button>

                          <div class="modal fade" id="exampleModalWarning" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Cacciatori senza punteggio minimo</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          @if($ko)
                                              <table width="100%">
                                                  <thead>
                                                  <th>Cacciatore</th>
                                                  </thead>
                                                  @foreach($ko as $id)
                                                      <?php
                                                      $hunter = \App\Models\PluginCacciaHunters::find($id);
                                                      ?>
                                                      <tr>
                                                          <td>{{ $hunter->first_name }} {{ $hunter->last_name }}</td>
                                                      </tr>
                                                  @endforeach
                                              </table>
                                          @endif
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endif
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
  </script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection
