@extends(backpack_view('layouts.plain'))

@php
    $websiteLoginSetting = \App\Models\WebsiteSetting::select('admin_login_background')->first();
    $adminLoginBackground = trim((string) ($websiteLoginSetting->admin_login_background ?? ''));
    $adminLoginBackgroundUrl = $adminLoginBackground !== '' ? url($adminLoginBackground) : null;
@endphp

@section('after_styles')
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
    </style>
@endsection

@section('content')
    <div class="auth-login-wrapper">
        <div class="row justify-content-center no-gutters auth-login-shell">
            <div class="col-lg-6">
                <div class="card bg-transparent border-0 h-100 shadow-none mb-0 auth-brand-wrap">
                    <div class="card-body p-0">
                        <span class="auth-brand-kicker">Pannello Controllo</span>
                        <h3 class="auth-brand-logo mb-3">
                            <?php $website = \App\Models\WebsiteSetting::first(); ?>
                        @if(!$website->logo_login)
                                <img src="{{ url('public/img/commons/admin/logo-cms-formula-5_2.png') }}" title="Logo">
                        @else
                                <img src="{{ url($website->logo_login) }}" title="Logo">
                        @endif
                        </h3>
                        <h4>Gestisci il tuo business in modo rapido e professionale.</h4>
                        <p class="auth-brand-note">Accedi al pannello per monitorare contenuti, ordini e funzionalità operative in un unico ambiente.</p>
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
