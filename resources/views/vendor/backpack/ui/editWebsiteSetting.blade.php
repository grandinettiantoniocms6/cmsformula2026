@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard')
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="website-setting-header-shell">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
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

              @if(isset($saveAction['active']) && !is_null($saveAction['active']['value']))
                  <div id="saveActions" class="form-group">

                      <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">
                      @if(!empty($saveAction['options']))
                          <div class="btn-group" role="group">
                              @endif

                              <button type="submit" class="btn btn-success">
                                  <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                  <span data-value="{{ $saveAction['active']['value'] }}">Salva</span>
                              </button>
                              @if(!empty($saveAction['options']))
                          </div>
                      @endif
                  </div>
              @endif

          </form>
	</div>
</div>
@endsection

@php
    $isModernAdminTemplate = $isModernAdminTemplate ?? \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp
@push('after_styles')
    @if($isModernAdminTemplate)
    <style>
        .website-setting-header-shell {
            background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
            border: 1px solid #dae5fb;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;
            box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
        }

        .website-setting-header-shell .page-title {
            color: #182f59;
            font-weight: 700;
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
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

        .container-fluid .btn-success,
        .container-fluid .btn-primary {
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(14, 36, 79, 0.14);
        }
    </style>
    @endif
@endpush

