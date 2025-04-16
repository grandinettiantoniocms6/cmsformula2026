@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center no-gutters">
        <div class="col-lg-6">
            <div class="card bg-transparent border-0 h-100 shadow-none mb-0">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h3 class="text-center text-md-left mb-3">
                        <?php $website = \App\Models\WebsiteSetting::first(); ?>
                        @if(!$website->logo_login)
                            <img src="/img/commons/admin/logo-cms-formula-5_2.png" title="CMS-Formula 5.0">
                        @else
                            <img src="{{ url($website->logo_login) }}" width="180" title="Logo">
                        @endif
                    </h3>
                    <h4 class="mb-4 font-weight-bold text-center text-md-left px-2">Sei pronto anche oggi a far crescere il tuo business?</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-0 shadow">
                <div class="card-body px-4 px-lg-5">
                    <h3 class="text-center font-weight-semi-bold">Accedi</h3>
                    <form role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label font-weight-semi-bold" for="{{ $username }}">{{ trans(config('backpack.base.authentication_column_name')) }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}">

                                @if ($errors->has($username))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first($username) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label class="control-label font-weight-semi-bold" for="password">{{ trans('backpack::base.password') }}</label>
                                <a class="float-right toggle-link" href="#password" data-toggle="tooltip" title="Mostra/Nascondi Password"><i class="la la-eye-slash" aria-hidden="true"></i></a>
                            </div>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember" name="remember"> <label class="custom-control-label" for="remember">{{ trans('backpack::base.remember_me') }}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-dark">
                                    {{ trans('backpack::base.login') }}
                                </button>
                            </div>
                        </div>

                        @if (backpack_users_have_email() && backpack_email_column() == 'email' && config('backpack.base.setup_password_recovery_routes', true))
                            <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
                        @endif
                        @if (config('backpack.base.registration_open'))
                            <div class="text-center"><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="text-center mx-auto">
        Realizzato da <a target="_blank" rel="noopener" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>.
    </div>
@endsection

@section('after_scripts')
    <script>
        /** Show/Hide Password */
        $('.toggle-link').click(function() {
            $(this).children('i').toggleClass('la-eye la-eye-slash');
            var el = $($(this).attr("href"));
            if (el.attr('type') == 'password') {
                el.attr('type', 'text');
            } else {
                el.attr('type', 'password');
            }
        });
    </script>
@endsection


