@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    "lista" => "/admin/"
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
  $isBlockCrud = is_numeric(strpos($crud->route, "block"));
  $isEnhancedCrudEdit = $isBlockCrud;
  $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
  $routeProbe = (string) ($crud->route ?? '');
  $pathProbe = (string) request()->path();
  $routeController = request()->route() ? request()->route()->getController() : null;
  $controllerName = $routeController ? class_basename(get_class($routeController)) : '';
  $isPluginController = stripos($controllerName, 'Plugin') !== false;
  if (!$isEnhancedCrudEdit) {
      foreach ($enhancedCrudNeedles as $needle) {
          if (stripos($routeProbe, $needle) !== false || stripos($pathProbe, $needle) !== false) {
              $isEnhancedCrudEdit = true;
              break;
          }
      }
  }
  if (!$isEnhancedCrudEdit && $isPluginController) {
      $isEnhancedCrudEdit = true;
  }
  $isEnhancedCrudEdit = $isEnhancedCrudEdit && $isModernAdminTemplate;

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

@endphp

@section('header')
    <div class="{{ $isEnhancedCrudEdit ? 'enhanced-crud-edit-header-shell' : '' }}">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>
            @if($isBlockCrud)
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

@section('content')
<div class="row">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post" class="mb-5 pb-4"
		  		action="{{ url($crud->route.'/'.$entry->getKey()) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  {!! method_field('PUT') !!}

		  	@if ($crud->model->translationEnabled())
		    <div class="mb-2 text-right">
		    	<!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
		      @endif

              @if(is_numeric(strpos($crud->route, "block")))
                  <div class="btn-group" role="group">
                      <button type="submit" class="btn btn-success">
                          <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                          <span data-value="save_and_back">Salva e torna indietro</span>
                      </button>
                  </div>
              @else
                  @include('crud::inc.form_save_buttons')
              @endif

		  </form>
	</div>
</div>
@endsection

@push('after_scripts')

    <script type="text/javascript">
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 second for example

        if($("#name_it").length > 0) {
            var $input = $('#name_it');
            //user is "finished typing," do something
            function doneTyping () {
                $.ajax({
                    url: '{{ route('sanitize_string') }}',
                    method: 'POST',
                    data: {
                        string: $("#name_it").val(),
                        _token: '{{ csrf_token() }}'
                    }, success: function (response) {
                        $("#slug_it").val(response.string);
                    },error: function (data, textStatus, errorThrown) {
                    },
                });
            }
        }

        if($("#title_page").length > 0) {
            var $input = $('#title_page');
            //user is "finished typing," do something
            function doneTyping () {
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
            }


        }

        if($("#title_page").length > 0 || $("#name_it").length > 0) {
            //on keyup, start the countdown
            $input.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });

            //on keydown, clear the countdown
            $input.on('keydown', function () {
                clearTimeout(typingTimer);
            });
        }


    </script>

    <script>
        function add_range(id){
            var code = Math.floor(Math.random() * 100001);
            $("#zona-"+id).append("<tr id='new-"+code+"'><td>Da <input type='text' class='form-control' name='min["+id+"][]' size='10'></td><td>A <input type='text' class='form-control' name='max["+id+"][]' size='10'></td><td>&euro; <input type='text' class='form-control' name='price["+id+"][]' size='10'></td><td><a href='javascript:delete_range(\"new\", "+code+")'><i class='fa fa-trash'></i></a></td></tr>");
        }

        function delete_range(type, id){
            $("#"+type+"-"+id).html("");
        }
    </script>

@endpush

@if($isEnhancedCrudEdit)
    @push('after_styles')
        <style>
            .enhanced-crud-edit-header-shell {
                background: linear-gradient(130deg, #ffffff 0%, #f4f8ff 100%);
                border: 1px solid #dbe6fb;
                border-radius: 14px;
                padding: 14px 16px;
                box-shadow: 0 8px 22px rgba(24, 43, 81, 0.08);
                margin-bottom: 12px;
            }

            .enhanced-crud-edit-header-shell .page-title {
                display: flex;
                align-items: baseline;
                gap: 10px;
                flex-wrap: wrap;
                color: #182f59;
                font-weight: 700;
            }

            .enhanced-crud-edit-header-shell .page-title small {
                color: #607197;
                font-weight: 600;
            }

            .enhanced-crud-edit-header-shell .page-title small a {
                color: #3b5d9f;
                font-weight: 700;
            }

            .enhanced-crud-edit-header-shell .page-title small a:hover {
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
            .enhanced-crud-edit-header-shell {
                background:
                    radial-gradient(520px 160px at 8% -40%, rgba(57, 140, 255, .18), transparent 70%),
                    linear-gradient(160deg, #ffffff 0%, #f4f8ff 100%);
                border: 1px solid #d7e5fb;
                box-shadow: 0 12px 28px rgba(25, 67, 141, .12);
            }

            .enhanced-crud-edit-header-shell .page-title,
            .enhanced-crud-edit-header-shell .page-title small,
            .enhanced-crud-edit-header-shell .page-title small a {
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
