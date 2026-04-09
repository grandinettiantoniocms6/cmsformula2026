@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
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
  $isEnhancedCrudCreate = false;
  $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
  $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();
  $routeProbe = (string) ($crud->route ?? '');
  $pathProbe = (string) request()->path();
  $routeController = request()->route() ? request()->route()->getController() : null;
  $controllerName = $routeController ? class_basename(get_class($routeController)) : '';
  $isPluginController = stripos($controllerName, 'Plugin') !== false;
  foreach ($enhancedCrudNeedles as $needle) {
      if (stripos($routeProbe, $needle) !== false || stripos($pathProbe, $needle) !== false) {
          $isEnhancedCrudCreate = true;
          break;
      }
  }
  if (!$isEnhancedCrudCreate && $isPluginController) {
      $isEnhancedCrudCreate = true;
  }
  $isEnhancedCrudCreate = $isEnhancedCrudCreate && $isModernAdminTemplate;

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="{{ $isEnhancedCrudCreate ? 'enhanced-crud-create-header-shell' : '' }}">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small>

            @if ($crud->hasAccess('list'))
                @if(request()->has('group_id'))
                    <?php $group_id = request()->get('group_id'); ?>
                    <small><a href="{{ url("/admin/shopProductsVariants?group_id=$group_id") }}" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
                @else
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
	<div class="{{ $crud->getCreateContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post" class="mb-5 pb-4"
		  		action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
			  {!! csrf_field() !!}
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @endif

	          @include('crud::inc.form_save_buttons')
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
                        $("#title_page_it").val($("#name_it").val());
                        $("#title_it").val($("#title_page").val());
                        $("#meta_title_it").val($("#title_page").val());
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
                        $("#title_it").val($("#title_page").val());
                        $("#title_page_it").val($("#title_page").val());
                        $("#meta_title_it").val($("#title_page").val());
                    },error: function (data, textStatus, errorThrown) {
                    },
                });
            }
        }

        //on keyup, start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });

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
