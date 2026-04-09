@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    "lista" => "/admin/"
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

@endphp
@push('after_styles')
    @if($isModernAdminTemplate)
    <style>
        .plugin-products-edit-header-shell{background:linear-gradient(130deg,#fff 0%,#f4f8ff 100%);border:1px solid #dbe6fb;border-radius:14px;padding:14px 16px;box-shadow:0 8px 22px rgba(24,43,81,.08);margin-bottom:12px}
        .plugin-products-edit-header-shell .page-title{display:flex;align-items:baseline;gap:10px;flex-wrap:wrap;color:#182f59;font-weight:700}
        .plugin-products-edit-header-shell .page-title small{color:#607197;font-weight:600}
        .container-fluid .form-group>label{color:#223a67;font-weight:700}
        .container-fluid .form-control,.container-fluid .select2-container--bootstrap .select2-selection{min-height:42px;border-radius:9px!important;border-color:#d7e1f2;box-shadow:inset 0 1px 2px rgba(18,38,76,.04)}
    </style>
    @endif
@endpush

@section('header')
    <div class="plugin-products-edit-header-shell"><h3 class="page-title mb-0">
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>

        @if(is_numeric(strpos($crud->route, "block")))
            <small><a href="javascript:history.back()" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> <span>Torna al contenuto pagina</span></a></small>
        @else
            @if($crud->hasAccess('list'))
                <small><a href="#" onclick="history.back()" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        @endif
    </h3></div>
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

@endpush

