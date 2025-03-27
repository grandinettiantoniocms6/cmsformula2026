@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    "lista" => "/admin/"
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

@endphp

@push('after_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>
    <style>
        .swal-wide {
            width: 850px !important;
        }
        .app-body {
            overflow-x: visible !important;
        }
        #preview_card {
            zoom: 0.5;
            background-color: #fff;
            background-clip: border-box;
            border: 10px solid #fff;
            border-radius: 3px;
        }
    </style>
@endpush

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

		  <form method="post" id="form_label"
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
                  <div class="col-7">
                      <!-- load the view from the application if it exists, otherwise load the one in the package -->
                      @if(view()->exists('vendor.backpack.crud.form_content'))
                          @include('vendor.backpack.crud.form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                      @else
                          @include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                      @endif
                  </div>

                  <div class="col-5 text text-center">
                      <p><a class="btn btn-sm btn-block btn-info" href="{{ route('pdf.pluginLabel', $entry->getKey()) }}" target="_blank">Scarica PDF</a></p>
                      <p class="text-center mb-1">Anteprima in scala 1:2</p>
                      <iframe src="{{ route('preview.pluginLabel', $entry->getKey()) }}" id="preview_card" width="100%" height="auto" onload="resizeIframe(this)" scrolling="none"></iframe>
                      <button type="submit" class="btn btn-success" id="buttonSubmit2">
                          <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                          <span data-value="{{ $saveAction['active']['value'] }}">Salva</span>
                      </button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script type="text/javascript">

        $('.summernote').summernote({
            callbacks: {
                /*onBlur: function() {
                    $("#form_label").submit();
                }*/
            },
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'paragraph','table']],
                ['misc', ['codeview', 'undo', 'redo']]
            ]
        });

        /*$("#form_label").change(function(){
            $.ajax({
                url: "{{ url($crud->route.'/'.$entry->getKey()) }}",
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    Swal.fire({
                        title: 'Attendi',
                        showConfirmButton: false,
                        loaderHtml: '<div class="sk-chase"><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div></div>',
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                        },
                    });
                }
            }).done(function(resp) {
                Swal.close();
                document.getElementById("preview_card").contentDocument.location.reload(true);
            });
        });*/

        function resizeIframe(obj) {
            obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 30 + 'px';
        }
    </script>
@endpush

