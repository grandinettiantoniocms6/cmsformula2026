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
        .swal-wide{
            width:850px !important;
        }
    </style>
@endpush

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit').' '.$crud->entity_name !!}.</small>

        @if(is_numeric(strpos($crud->route, "block")))
            <small><a href="javascript:history.back()" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> <span>Torna al contenuto pagina</span></a></small>
        @else
            @if($crud->hasAccess('list'))
                <small><a href="#" onclick="history.back()" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        @endif
    </h3>
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
                id="formSave"
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script type="text/javascript">
        $( "#formSave" ).submit(function(event) {
            $("#buttonSubmit").removeAttr("disabled");

            event.preventDefault();

            /* 'client_id.required' => 'Cliente obbligatorio',
            'date_intervention.required' => 'Data intervento obbligatoria',
            'vehicle_id.required' => 'Mezzo obbligatorio',
            'driver_id.required' => 'Autista obbligatorio',
            'first_name.required' => 'Nome cliente obbligatorio',
            'last_name.required' => 'Cognome cliente obbligatorio',
            'mobile.required' => 'Cellulare cliente obbligatorio',
            'address.required' => 'Indirizzo obbligatorio',
            'civico.required' => 'Civico obbligatorio',
            'comune.required' => 'Comune obbligatorio',
            'provincia.required' => 'Provincia obbligatoria',*/

            /*var client_id = $.trim($("#client_id").val());
            if(client_id.length === 0){
                Swal.fire({
                    title: "Cliente",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }*/


            var first_name = $.trim($("#first_name").val());
            if(first_name.length === 0){
                Swal.fire({
                    title: "Nome Cliente",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            var last_name = $.trim($("#last_name").val());
            if(last_name.length === 0){
                Swal.fire({
                    title: "Cognome Cliente",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            var address = $.trim($("#address").val());
            if(address.length === 0){
                Swal.fire({
                    title: "Indirizzo Cliente",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            var civico = $.trim($("#civico").val());
            if(civico.length === 0){
                Swal.fire({
                    title: "Civico Cliente",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            var comune = $.trim($("#comune").val());
            if(comune.length === 0){
                Swal.fire({
                    title: "Comune Cliente",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });

                return;
            }

            var provincia = $.trim($("#provincia").val());
            if(provincia.length === 0){
                Swal.fire({
                    title: "Provincia Cliente",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            var date_intervention = $.trim($("#date_intervention").val());
            if(date_intervention.length === 0){
                Swal.fire({
                    title: "Data intervento",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            var vehicle_id = $.trim($("#vehicle_id").val());
            if(vehicle_id.length === 0){
                Swal.fire({
                    title: "Mezzo",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            var driver_id = $.trim($("#driver_id").val());
            if(driver_id.length === 0){
                Swal.fire({
                    title: "Autista",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }


            var laborer_id = $.trim($("#laborer_id").val());
            if(laborer_id.length === 0){
                Swal.fire({
                    title: "Manovale",
                    text: "Campo obbligatorio",
                    icon: "error",
                    confirmButtonText: "Ok",
                    allowOutsideClick: false,
                    timer: 4000,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#buttonSubmit").removeAttr("disabled");
                    }
                });
                return;
            }

            $.ajax({
                url: "{{ route('check.pluginInterventions') }}",
                type: 'POST',
                data: $(this).serialize(),
            }).done(function(resp) {
                if(resp.error == 1){
                    Swal.fire({
                        title: "Controllo",
                        html: resp.message,
                        icon: "error",
                        customClass: 'swal-wide'
                    });
                    $("#buttonSubmit").removeAttr("disabled");
                }else{
                    $("#formSave").unbind().submit();
                }
            });
        });

        $("#client_id").change(function (){
            var id = $(this).val();
            $.ajax({
                url: '{{ route('pluginInterventions.get_client') }}',
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                }, success: function (response) {
                    if(response.client){
                        $("#first_name").val(response.client.first_name);
                        $("#last_name").val(response.client.last_name);
                        $("#company_name").val(response.client.company_name);
                        $("#mobile").val(response.client.mobile);
                        $("#address").val(response.client.address);
                        $("#civico").val(response.client.civico);
                        $("#interno").val(response.client.interno);
                        $("#cap").val(response.client.cap);
                        $("#frazione").val(response.client.frazione);
                        $("#comune").val(response.client.comune);
                        $("#provincia").val(response.client.provincia);
                    }else{
                        $("#first_name").val("");
                        $("#company_name").val("");
                        $("#last_name").val("");
                        $("#mobile").val("");
                        $("#address").val("");
                        $("#civico").val("");
                        $("#interno").val("");
                        $("#cap").val("");
                        $("#frazione").val("");
                        $("#comune").val("");
                        $("#provincia").val("");
                    }

                },error: function (data, textStatus, errorThrown) {
                },
            });
        });

    </script>

@endpush

