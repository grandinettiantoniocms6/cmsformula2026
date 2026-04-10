@extends(backpack_view('layouts.plain'))

@php
    $websiteLoginSetting = \App\Models\WebsiteSetting::select('admin_login_background', 'admin_panel_template')->first();
    $adminLoginBackground = trim((string) ($websiteLoginSetting->admin_login_background ?? ''));
    $adminLoginBackgroundUrl = $adminLoginBackground !== '' ? url($adminLoginBackground) : null;
    $templateMode = (string) ($websiteLoginSetting->admin_panel_template ?? 'white');
    $isModernAdminTemplate = in_array($templateMode, ['modern_01', 'modern_02'], true);
    $isModernAdminTemplate02 = ($templateMode === 'modern_02');
@endphp

@section('after_styles')
    @if($isModernAdminTemplate)
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap');

        body.app.flex-row {
            min-height: 100vh;
            font-family: 'Sora', sans-serif;
            @if($adminLoginBackgroundUrl)
                background:
                    radial-gradient(1000px 420px at 8% 6%, rgba(50, 94, 185, .24), transparent 62%),
                    radial-gradient(760px 360px at 94% 14%, rgba(21, 191, 140, .18), transparent 60%),
                    linear-gradient(145deg, rgba(12, 25, 56, .58), rgba(25, 50, 101, .4)),
                    url('{{ $adminLoginBackgroundUrl }}') center center / cover no-repeat fixed;
            @else
                background:
                    radial-gradient(980px 460px at 8% 6%, rgba(44, 93, 191, .15), transparent 60%),
                    radial-gradient(740px 360px at 94% 14%, rgba(17, 170, 126, .12), transparent 62%),
                    linear-gradient(140deg, #eef4ff 0%, #f7faff 44%, #ffffff 100%);
            @endif
        }

        .auth-login-wrapper {
            width: 100%;
            max-width: 980px;
            margin: 2.4rem auto;
            padding: 0 1rem;
        }

        .auth-page-meta {
            margin-top: .95rem;
            text-align: center;
            font-size: .84rem;
            font-weight: 600;
            color: #48689f;
        }

        .auth-page-meta a {
            color: #2d67d1;
            font-weight: 700;
        }

        .auth-login-shell {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 75px rgba(7, 18, 45, .3);
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(8px);
        }

        .auth-login-shell::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, rgba(18, 38, 83, .95) 0%, rgba(25, 55, 116, .86) 38%, rgba(255, 255, 255, 0) 76%);
            pointer-events: none;
        }

        .auth-brand-wrap {
            min-height: 100%;
            padding: 3rem 2.5rem;
            color: #f0f5ff;
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-brand-kicker {
            margin-bottom: .9rem;
            display: inline-flex;
            width: fit-content;
            border-radius: 999px;
            padding: .28rem .64rem;
            font-size: .74rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #d9e8ff;
            background: rgba(255, 255, 255, .13);
        }

        .auth-brand-wrap h4 {
            font-size: 1.58rem;
            line-height: 1.3;
            letter-spacing: -.02em;
            margin-bottom: .9rem;
        }

        .auth-brand-note {
            max-width: 360px;
            color: rgba(233, 242, 255, .88);
            font-size: .92rem;
            line-height: 1.55;
        }

        .auth-form-col {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, .92);
        }

        .auth-form-wrap {
            padding: 2.45rem 2.25rem;
            height: 100%;
        }

        .auth-form-wrap h3 {
            font-size: 1.76rem;
            font-weight: 800;
            color: #132f66;
            letter-spacing: -.02em;
            margin-bottom: .25rem;
            text-align: left;
        }

        .auth-form-subtitle {
            color: #48689f;
            font-size: .9rem;
            margin-bottom: 1.35rem;
        }

        .auth-form-wrap .form-control {
            border-radius: 14px;
            border: 1px solid #cfdbf0;
            background: #f8fbff;
            min-height: 46px;
            font-weight: 500;
        }

        .auth-form-wrap .form-control:focus {
            border-color: #2c66d4;
            box-shadow: 0 0 0 .2rem rgba(44, 102, 212, .14);
            background: #fff;
        }

        .auth-form-wrap .control-label {
            color: #17376f;
            font-size: .85rem;
            font-weight: 700;
            margin-bottom: .34rem;
        }

        .auth-form-wrap .btn-dark {
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #1f50b7, #2d75ea);
            font-weight: 700;
            min-height: 48px;
            box-shadow: 0 12px 28px rgba(31, 80, 183, .28);
        }

        .auth-form-wrap .btn-dark:hover {
            transform: translateY(-1px) scale(1.01);
        }

        .auth-form-wrap a {
            color: #275fc9;
            font-weight: 700;
            font-size: .84rem;
        }

        .auth-form-wrap .toggle-link i {
            color: #2b63ce;
        }

        .auth-form-wrap .custom-control-label {
            font-size: .84rem;
            color: #334e7f;
            font-weight: 600;
        }

        .auth-brand-logo img {
            max-width: 200px;
            width: 100%;
            height: auto;
        }

        @media (max-width: 991.98px) {
            .auth-login-wrapper {
                margin: 1.3rem auto;
                padding: 0 .85rem;
            }

            .auth-login-shell {
                border-radius: 22px;
            }

            .auth-login-shell::before {
                background: linear-gradient(180deg, rgba(18, 38, 83, .9) 0%, rgba(25, 55, 116, .78) 55%, rgba(255, 255, 255, 0) 100%);
            }

            .auth-brand-wrap {
                padding: 2rem 1.45rem 1.2rem;
                align-items: center;
                text-align: center;
            }

            .auth-brand-wrap h4 {
                font-size: 1.2rem;
                margin-bottom: .6rem;
            }

            .auth-brand-note {
                max-width: 100%;
            }

            .auth-form-wrap {
                padding: 1.45rem 1.2rem 1.65rem;
            }

            .auth-form-wrap h3 {
                font-size: 1.48rem;
                text-align: center;
            }

            .auth-form-subtitle {
                text-align: center;
            }

            .auth-page-meta {
                margin-top: .7rem;
                font-size: .8rem;
            }
        }

        @if($isModernAdminTemplate02)
        body.app.flex-row {
            @if($adminLoginBackgroundUrl)
                background:
                    radial-gradient(1100px 420px at 8% 6%, rgba(76, 148, 255, .24), transparent 62%),
                    radial-gradient(860px 340px at 96% 10%, rgba(85, 198, 255, .18), transparent 66%),
                    linear-gradient(145deg, rgba(20, 47, 99, .46), rgba(34, 73, 143, .34)),
                    url('{{ $adminLoginBackgroundUrl }}') center center / cover no-repeat fixed;
            @else
                background:
                    radial-gradient(1080px 470px at 8% 6%, rgba(64, 143, 255, .18), transparent 62%),
                    radial-gradient(840px 370px at 96% 12%, rgba(84, 198, 255, .14), transparent 66%),
                    linear-gradient(150deg, #eef4ff 0%, #f7faff 45%, #ffffff 100%);
            @endif
        }

        .auth-login-shell {
            box-shadow: 0 30px 65px rgba(19, 58, 129, .2);
            border: 1px solid #d5e5ff;
        }

        .auth-login-shell::before {
            background: linear-gradient(112deg, rgba(21, 49, 104, .86) 0%, rgba(37, 88, 173, .78) 40%, rgba(255, 255, 255, 0) 78%);
        }

        .auth-brand-kicker {
            background: rgba(234, 243, 255, .95);
            color: #2a4d84;
            border: 1px solid #c9ddff;
        }

        .auth-form-wrap .btn-dark {
            background: linear-gradient(132deg, #3a6fd6, #59b8ff);
            box-shadow: 0 14px 30px rgba(26, 82, 170, .28);
        }
        @endif
    </style>
    @else
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap');

        body.app.flex-row {
            min-height: 100vh;
            font-family: 'Sora', sans-serif;
            background: #f4f5f7;
        }

        .auth-login-white-wrapper {
            width: 100%;
            max-width: 1080px;
            margin: 0 auto;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1.5rem 1.2rem;
        }

        .auth-login-white-row {
            align-items: center;
        }

        .auth-white-brand {
            color: #122b57;
            padding-right: 2.5rem;
        }

        .auth-white-logo img {
            max-width: 170px;
            width: 100%;
            height: auto;
        }

        .auth-white-brand h2 {
            margin-top: 1rem;
            font-size: 2.7rem;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .auth-white-form-card {
            background: #ffffff;
            border: 1px solid #e3e8f2;
            border-radius: 4px;
            box-shadow: 0 8px 22px rgba(16, 36, 78, .12);
            padding: 1.55rem 1.5rem 1.2rem;
        }

        .auth-white-form-card h3 {
            text-align: center;
            color: #162f5d;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: .85rem;
        }

        .auth-white-form-card .control-label {
            color: #1f3763;
            font-size: .98rem;
            font-weight: 700;
        }

        .auth-white-form-card .form-control {
            border-radius: 3px;
            border: 1px solid #d7deea;
            min-height: 42px;
            background: #fff;
            font-weight: 500;
        }

        .auth-white-form-card .form-control:focus {
            border-color: #89a3d3;
            box-shadow: 0 0 0 .15rem rgba(42, 91, 182, .12);
        }

        .auth-white-form-card .custom-control-label {
            color: #42587f;
            font-weight: 500;
        }

        .auth-white-form-card .btn-dark {
            border: 0;
            border-radius: 4px;
            background: #131c3e;
            min-height: 44px;
            font-weight: 700;
            font-size: 1.02rem;
        }

        .auth-white-form-card .toggle-link i {
            color: #7a8eaf;
        }

        .auth-white-form-card .auth-white-reset-link {
            margin-top: .7rem;
        }

        .auth-white-form-card .auth-white-reset-link a {
            color: #42587f;
            font-weight: 500;
            font-size: .95rem;
        }

        .auth-page-meta-white {
            margin-top: 1.45rem;
            text-align: center;
            color: #42587f;
            font-size: .9rem;
            font-weight: 500;
        }

        .auth-page-meta-white a {
            color: #2c67d1;
            font-weight: 700;
        }

        @media (max-width: 991.98px) {
            .auth-white-brand {
                text-align: center;
                padding-right: 0;
                margin-bottom: 1.1rem;
            }

            .auth-white-brand h2 {
                font-size: 1.9rem;
            }

            .auth-white-form-card h3 {
                font-size: 2.2rem;
            }
        }
    </style>
    @endif
@endsection

@section('content')
    @if($isModernAdminTemplate)
    <div class="auth-login-wrapper">
        <div class="row justify-content-center no-gutters auth-login-shell">
            <div class="col-lg-6">
                <div class="card bg-transparent border-0 h-100 shadow-none mb-0 auth-brand-wrap">
                    <div class="card-body p-0">
                        <h3 class="auth-brand-logo mb-3">
                            <?php $website = \App\Models\WebsiteSetting::first(); ?>
                        @if(!$website->logo_login)
                                <img src="{{ url('img/commons/admin/logo-dashboard.png') }}" title="Logo">
                        @else
                                <img src="{{ url($website->logo_login) }}" title="Logo">
                        @endif
                        </h3>
                        <h4>Gestisci il tuo business in modo rapido e professionale.</h4>
                        <p class="auth-brand-note">Accedi al pannello per gestire contenuti, ordini e funzionalità operative in un unico ambiente.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 auth-form-col">
                <div class="card mb-0 shadow-none border-0">
                    <div class="card-body auth-form-wrap">
                        <h3>Accedi</h3>
                        <div class="auth-form-subtitle">Inserisci le tue credenziali per continuare.</div>
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
        <div class="auth-page-meta">
            Realizzato da <a target="_blank" rel="noopener" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a> - Ver. 6.0.1.
        </div>
    </div>
    @else
    <div class="auth-login-white-wrapper">
        <div class="row justify-content-center auth-login-white-row">
            <div class="col-lg-6">
                <div class="auth-white-brand">
                    <div class="auth-white-logo">
                        <?php $website = \App\Models\WebsiteSetting::first(); ?>
                        @if(!$website->logo_login)
                            <img src="{{ url('img/commons/admin/logo-dashboard.png') }}" title="Logo">
                        @else
                            <img src="{{ url($website->logo_login) }}" title="Logo">
                        @endif
                    </div>
                    <h2>Sei pronto anche oggi a far crescere il tuo business?</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="auth-white-form-card">
                    <h3>Accedi</h3>
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

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-block btn-dark">
                                {{ trans('backpack::base.login') }}
                            </button>
                        </div>

                        @if (backpack_users_have_email() && backpack_email_column() == 'email' && config('backpack.base.setup_password_recovery_routes', true))
                            <div class="text-center auth-white-reset-link"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
                        @endif
                        @if (config('backpack.base.registration_open'))
                            <div class="text-center"><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="auth-page-meta-white">
            Realizzato da <a target="_blank" rel="noopener" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a> - Ver. 6.0.1.
        </div>
    </div>
    @endif
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
