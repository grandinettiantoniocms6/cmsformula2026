@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@push('after_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>
    @if($isModernAdminTemplate)
    <style>
        .plugin-products-create-header-shell {
            background: linear-gradient(130deg, #ffffff 0%, #f4f8ff 100%);
            border: 1px solid #dbe6fb;
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(24, 43, 81, 0.08);
            margin-bottom: 12px;
        }
        .plugin-products-create-header-shell .page-title {
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
            color: #182f59;
            font-weight: 700;
        }
        .plugin-products-create-header-shell .page-title small { color: #607197; font-weight: 600; }
        .container-fluid .form-group > label { color: #223a67; font-weight: 700; }
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
    </style>
    @endif
@endpush

@section('header')
    <div class="plugin-products-create-header-shell">
    <h3 class="page-title mb-0">
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small>

        @if($crud->hasAccess('list'))
            @if(request()->has('group_id'))
                <?php $group_id = request()->get('group_id'); ?>
                <small><a href="{{ url("/admin/shopProductsVariants?group_id=$group_id") }}" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @else
                <small><a href="#" onclick="history.back()" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script type="text/javascript">
        <?php
        $langs = \App\Models\AdminLanguage::where("is_active", 1)->get();
        ?>
        @if($langs)
            @foreach($langs as $lang)
                 $("#name_{{ $lang->name }}").change(function (){
                        $.ajax({
                            url: '{{ route('sanitize_string') }}',
                            method: 'POST',
                            data: {
                                string: $("#name_{{ $lang->name }}").val(),
                                _token: '{{ csrf_token() }}'
                            }, success: function (response) {
                                $("#slug_{{ $lang->name }}").val(response.string);
                            },error: function (data, textStatus, errorThrown) {
                            },
                        });
                 });
            @endforeach
        @endif
    </script>

    @include(backpack_view('plugins.pluginProducts.js'))
@endpush
