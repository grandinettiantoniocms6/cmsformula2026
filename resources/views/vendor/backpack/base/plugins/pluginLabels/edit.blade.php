@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    "lista" => "/admin/"
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

@endphp

@section('header')
	<section class="container-fluid">
	  <h3>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>
        @if(is_numeric(strpos($crud->route, "block")))
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
      <hr>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
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
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

              <div class="row">
                  <div class="col-6">
                      <!-- load the view from the application if it exists, otherwise load the one in the package -->
                      @if(view()->exists('vendor.backpack.crud.form_content'))
                          @include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                      @else
                          @include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                      @endif
                  </div>

                  <div class="col-6">
                      <iframe src="{{ route('preview.pluginLabel', $entry->getKey()) }}" class="border-0" border="0" width="100%" height="100%" scrolling="auto"></iframe>
                  </div>
              </div>

              <div id="saveActions" class="form-group">
                  <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">
                  <div class="btn-group" role="group">
                      <button type="submit" class="btn btn-success" id="buttonSubmit">
                          <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                          <span data-value="{{ $saveAction['active']['value'] }}">Salva</span>
                      </button>
                  </div>
              </div>

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

@endpush

