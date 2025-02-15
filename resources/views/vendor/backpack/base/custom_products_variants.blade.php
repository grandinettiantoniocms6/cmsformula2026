@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

  $vCheckSlug = [];
  if($crud->model->getTable() == "plugins_products"){
       $dashboard_class = new \App\Http\Controllers\Admin\DashboardController();
       $vCheckSlug = $dashboard_class->check_duplicate_slug($crud->model->getTable());
  }

$count_figli = \App\Models\PluginProducts::where("group_id", request()->get('group_id'))->where("is_variant", 1)->count();
@endphp

@section('header')
    <?php
    $product = \App\Models\PluginProducts::where("group_id", request()->get('group_id'))->where("is_variant", 0)->first();
    ?>
    @if($product)
    <div class="container-fluid">
        <h3>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!} <span class="label label-info">{{ $product->name }}</span> </span>
            <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
            <small><a href="/admin/pluginProducts" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Torna alla lista prodotti</a></small>

        </h3>
        <hr>
    </div>
    @endif
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
                        ATTENZIONE: Ci sono permalink duplicati!
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

            <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Crea combinazioni di varianti</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ route('pluginProducts.create_combinations') }}">
                                    <input type="hidden" name="padre_id" value="{{ $product->id }}">
                                    {{ csrf_field() }}
                                    <?php

                                    $product_padre = \App\Models\PluginProducts::where("group_id", \request()->get('group_id'))->where("is_variant", 0)->first();
                                    $category_product = \App\Models\PluginProductsCategoriesProducts::where("plugin_product_product_id", $product_padre->id)
                                        ->pluck("plugin_product_category_id", "plugin_product_category_id")->toArray();

                                    $attributes = \App\Models\ShopAttributes::selectRaw("shop_attributes.*")
                                        ->join("shop_attributes_categories", "shop_attributes_categories.shop_attribute_id", "=", "shop_attributes.id")
                                        ->whereIn("shop_category_id", $category_product)
                                        ->groupBy("shop_attributes.id")
                                        ->orderBy("lft", "asc")
                                        ->get();

                                    ?>
                                    @if($attributes)
                                        @foreach($attributes as $attribute)
                                            <?php
                                            $options = \App\Models\ShopAttributesOptions::where("shop_attribute_id", $attribute->id)
                                                ->orderBy("ordine", "asc")
                                                ->get();
                                            ?>
                                            <div class="form-group">
                                                <label>
                                                    {{ $attribute->name }}
                                                </label>
                                                <select class='form-control' name='attributes[{{ $attribute->id }}][]' multiple>
                                                    @if($options)
                                                        @foreach($options as $option)
                                                            <option value="{{ $option->value }}">{{ $option->value }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        @endforeach
                                    @endif


                                    <button type="submit" class="btn btn-primary" name="button">Crea combinazioni</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Associazione multipla sulle varianti</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ route('pluginProducts.associate_combinations') }}">
                                    <input type="hidden" name="group_id" value="{{ $product->group_id }}">

                                    {{ csrf_field() }}
                                    <?php
                                    $attributes = \App\Models\ShopAttributes::selectRaw("shop_attributes.*")
                                        ->join("shop_attributes_categories", "shop_attributes_categories.shop_attribute_id", "=", "shop_attributes.id")
                                        ->whereIn("shop_category_id", $category_product)
                                        ->groupBy("shop_attributes.id")
                                        ->orderBy("lft", "asc")
                                        ->get();
                                    ?>
                                    @if($attributes)
                                        <div class="form-group">
                                            <label>
                                                Alle varianti che contengono questo opzione:
                                            </label>
                                            <select class='form-control' name='option_id' required>
                                                <option value=""></option>
                                                @foreach($attributes as $attribute)
                                                    <?php
                                                    $options = \App\Models\ShopAttributesOptions::where("shop_attribute_id", $attribute->id)
                                                        ->orderBy("ordine", "asc")
                                                        ->get();
                                                    ?>
                                                    @if($options)
                                                        @foreach($options as $option)
                                                            <option value="{{ $option->id }}">{{ $option->value }} {{ $attribute->name }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label>
                                            Campo da associare:
                                        </label>
                                        <select class='form-control' name='field' required>
                                            <option value=""></option>
                                            <option value="price">Prezzo</option>
                                            <option value="qty">Quantità</option>
                                            <option value="foto">Foto</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            Valore (In caso di foto inserire il percorso "uploads/...."):
                                        </label>
                                        <input type="text" class="form-control" name="value" value="">
                                    </div>


                                    <button type="submit" class="btn btn-warning" name="button">Associazione multipla</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>



            <form method="post" action="{{ route('pluginsProducts.actions') }}" id="formSave">
                {{ csrf_field() }}
            <div class="row mb-0">
                <div class="col-sm-6">
                    @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                        <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">
                            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                                <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">
                                    <a href="/admin/pluginProducts/create?group_id={{ request()->get('group_id') }}" class="btn btn-primary" data-style="zoom-in">
                                        <span class="ladda-label"><i class="la la-plus"></i> Aggiungi variante</span>
                                    </a>

                                    <!-- Button trigger modal -->
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Crea Combinazioni dal Prodotto Padre
                                    </a>

                                    @if($count_figli > 0)
                                        <!-- Button trigger modal -->
                                        <br>
                                        <br>
                                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal2">
                                            Associazione multipla sulle varianti
                                        </a>
                                    @endif

                                </div>


                            @endif
                        </div>

                        <div class="row no-gutters my-3">
                            <div class="col-auto mr-1">
                                <div class="dropdown show">
                                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="esporta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Azioni
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="esporta">
                                        <button type="submit" class="dropdown-item" name="button" value="delete_variants" form="formSave">Cancella</button>
                                    </div>
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
    </script>

    <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
    @stack('crud_list_scripts')
@endsection
