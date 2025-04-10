@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>

        </small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}?block_id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
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

                  @if(isset($saveAction['active']) && !is_null($saveAction['active']['value']))
                      <div id="saveActions" class="form-group">

                          <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">
                          @if(!empty($saveAction['options']))
                              <div class="btn-group" role="group">
                                  @endif

                                  <button type="submit" class="btn btn-success">
                                      <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                      <span data-value="{{ $saveAction['active']['value'] }}">{{ $saveAction['active']['label'] }}</span>
                                  </button>

                                  <div class="btn-group" role="group">
                                      @if(!empty($saveAction['options']))
                                          <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">&#x25BC;</span></button>
                                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                              @foreach( $saveAction['options'] as $value => $label)
                                                  <a class="dropdown-item" href="javascript:void(0);" data-value="{{ $value }}">{{ $label }}</a>
                                              @endforeach
                                          </div>

                                      @endif
                                  </div>
                                  @if(!empty($saveAction['options']))
                              </div>
                          @endif
                          @if(!$crud->hasOperationSetting('showCancelButton') || $crud->getOperationSetting('showCancelButton') == true)
                              <a href="{{ $crud->hasAccess('list') ? url($crud->route) : url()->previous() }}?block_id={{ request()->get('block_id') }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}" class="btn btn-default"><span class="la la-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
                          @endif

                      </div>
                  @endif
		  </form>
	</div>
</div>

@endsection

@push('after_scripts')

    <script type="text/javascript">
        $('#title_page').on('input', function() {
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
        });

        $('#title_it').on('input', function() {
            $.ajax({
                url: '{{ route('sanitize_string') }}',
                method: 'POST',
                data: {
                    string: $("#title_it").val(),
                    _token: '{{ csrf_token() }}'
                }, success: function (response) {
                    $("#slug_it").val(response.string);
                },error: function (data, textStatus, errorThrown) {
                },
            });
        });
    </script>

@endpush
