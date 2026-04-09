@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>

    @if($isModernAdminTemplate)
        <style>
            .my-account-modern-header {
                background: linear-gradient(125deg, #ffffff 0%, #f2f6ff 100%);
                border: 1px solid #dae5fb;
                border-radius: 14px;
                padding: 14px 16px;
                margin-bottom: 14px;
                box-shadow: 0 8px 22px rgba(23, 43, 81, 0.08);
            }

            .my-account-modern-header h1 {
                margin: 0;
                color: #182f59;
                font-weight: 700;
                font-size: 1.55rem;
            }

            .my-account-modern-shell .alert {
                border-radius: 10px;
                border-width: 1px;
            }

            .my-account-modern-shell .card {
                border: 1px solid #dfe7f6;
                border-radius: 12px;
                box-shadow: 0 10px 22px rgba(19, 38, 75, 0.08);
                overflow: hidden;
            }

            .my-account-modern-shell .card-header {
                background: #f5f8ff;
                color: #233e6f;
                font-weight: 700;
                border-bottom: 1px solid #e0e8f7;
            }

            .my-account-modern-shell .card-body label {
                color: #223a67;
                font-weight: 700;
            }

            .my-account-modern-shell .form-control {
                min-height: 42px;
                border-radius: 9px;
                border-color: #d7e1f2;
                box-shadow: inset 0 1px 2px rgba(18, 38, 76, 0.04);
            }

            .my-account-modern-shell .form-control:focus {
                border-color: #89a6dc;
                box-shadow: 0 0 0 3px rgba(62, 111, 206, 0.13);
            }

            .my-account-modern-shell .card-footer {
                background: #fbfcff;
                border-top: 1px solid #e6ecf8;
            }

            .my-account-modern-shell .btn {
                border-radius: 9px;
                font-weight: 700;
            }

            .my-account-modern-shell .btn-success {
                box-shadow: 0 8px 18px rgba(14, 36, 79, 0.14);
            }
        </style>
    @endif
@endsection

@php
  $breadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      trans('backpack::base.my_account') => false,
  ];
@endphp

@section('header')
    <section class="content-header">
        <div class="container-fluid mb-3 {{ $isModernAdminTemplate ? 'my-account-modern-header' : '' }}">
            <h1>{{ trans('backpack::base.my_account') }}</h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="row {{ $isModernAdminTemplate ? 'my-account-modern-shell' : '' }}">

        @if (session('success'))
        <div class="col-lg-8">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if ($errors->count())
        <div class="col-lg-8">
            <div class="alert alert-danger">
                <ul class="mb-1">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- UPDATE INFO FORM --}}
        <div class="col-lg-8">
            <form class="form" action="{{ route('backpack.account.info.store') }}" method="post">

                {!! csrf_field() !!}

                <div class="card padding-10">

                    <div class="card-header">
                        {{ trans('backpack::base.update_account_info') }}
                    </div>

                    <div class="card-body backpack-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                @php
                                    $label = trans('backpack::base.name');
                                    $field = 'name';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input required class="form-control" type="text" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                            </div>

                            <div class="col-md-6 form-group">
                                @php
                                    $label = config('backpack.base.authentication_column_name');
                                    $field = backpack_authentication_column();
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input required class="form-control" type="{{ backpack_authentication_column()==backpack_email_column()?'email':'text' }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="la la-save"></i> {{ trans('backpack::base.save') }}</button>
                        <a href="{{ backpack_url() }}" class="btn">{{ trans('backpack::base.cancel') }}</a>
                    </div>
                </div>

            </form>
        </div>

        {{-- CHANGE PASSWORD FORM --}}
        <div class="col-lg-8">
            <form class="form" action="{{ route('backpack.account.password') }}" method="post">

                {!! csrf_field() !!}

                <div class="card padding-10">

                    <div class="card-header">
                        {{ trans('backpack::base.change_password') }}
                    </div>

                    <div class="card-body backpack-profile-form bold-labels">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('backpack::base.old_password');
                                    $field = 'old_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('backpack::base.new_password');
                                    $field = 'new_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>

                            <div class="col-md-4 form-group">
                                @php
                                    $label = trans('backpack::base.confirm_password');
                                    $field = 'confirm_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="la la-save"></i> {{ trans('backpack::base.change_password') }}</button>
                            <a href="{{ backpack_url() }}" class="btn">{{ trans('backpack::base.cancel') }}</a>
                    </div>

                </div>

            </form>
        </div>

    </div>
@endsection
