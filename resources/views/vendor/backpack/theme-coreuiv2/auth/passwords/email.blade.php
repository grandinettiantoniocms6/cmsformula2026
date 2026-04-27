@extends(backpack_view('layouts.plain'))

@php
    $websiteLoginSetting = \App\Models\WebsiteSetting::select('admin_login_background', 'admin_panel_template')->first();
    $adminLoginBackground = trim((string) ($websiteLoginSetting->admin_login_background ?? ''));
    $adminLoginBackgroundUrl = $adminLoginBackground !== '' ? url($adminLoginBackground) : null;
    $templateMode = (string) ($websiteLoginSetting->admin_panel_template ?? 'white');
    $isFutureAdminTemplate = ($templateMode === 'future');
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@section('header')
    @if($isFutureAdminTemplate)
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

            body.app.flex-row {
                min-height: 100vh;
                font-family: 'Manrope', sans-serif;
                @if($adminLoginBackgroundUrl)
                    background:
                        radial-gradient(900px 420px at 8% 12%, rgba(74, 133, 244, .22), transparent 62%),
                        radial-gradient(740px 320px at 92% 10%, rgba(49, 189, 153, .18), transparent 64%),
                        linear-gradient(145deg, rgba(13, 30, 65, .52), rgba(20, 44, 94, .45)),
                        url('{{ $adminLoginBackgroundUrl }}') center center / cover no-repeat fixed;
                @else
                    background:
                        radial-gradient(900px 420px at 8% 12%, rgba(74, 133, 244, .16), transparent 62%),
                        radial-gradient(740px 320px at 92% 10%, rgba(49, 189, 153, .14), transparent 64%),
                        linear-gradient(145deg, #ecf3ff 0%, #f7faff 52%, #ffffff 100%);
                @endif
            }

            .future-login-wrapper { width: 100%; max-width: 1080px; margin: 2rem auto; padding: 0 1rem; }
            .future-login-shell { border-radius: 12px; overflow: hidden; box-shadow: 0 30px 65px rgba(8, 25, 62, .24); border: 1px solid #d8e5fb; background: #ffffff; }
            .future-login-side { position: relative; padding: 2.2rem 2rem; color: #ecf3ff; background: linear-gradient(160deg, #132f66 0%, #1a468f 58%, #2259ad 100%); min-height: 100%; }
            .future-login-side::after { content: ''; position: absolute; right: -70px; bottom: -70px; width: 220px; height: 220px; border: 24px solid rgba(255, 255, 255, .12); border-radius: 12px; transform: rotate(18deg); pointer-events: none; }
            .future-login-badge { display: inline-flex; align-items: center; gap: .35rem; border-radius: 8px; padding: .34rem .58rem; font-size: .74rem; font-weight: 700; letter-spacing: .03em; color: #d9e8ff; background: rgba(255, 255, 255, .14); margin-bottom: 1rem; }
            .future-login-logo img { max-width: 190px; width: 100%; height: auto; }
            .future-login-title { font-size: 1.5rem; font-weight: 800; line-height: 1.28; margin-top: 1rem; margin-bottom: .85rem; }
            .future-login-text { color: rgba(230, 239, 255, .88); font-size: .92rem; line-height: 1.58; margin-bottom: 1.1rem; max-width: 360px; }
            .future-login-points { display: grid; gap: .45rem; padding: 0; margin: 0; list-style: none; }
            .future-login-points li { display: flex; align-items: center; gap: .45rem; color: #e6f0ff; font-size: .85rem; font-weight: 600; }
            .future-login-points li i { color: #72f3ca; font-size: .9rem; }
            .future-login-form-col { background: #ffffff; }
            .future-login-form-wrap { padding: 2rem 1.9rem 1.6rem; }
            .future-login-form-wrap h3 { color: #14356f; font-size: 1.66rem; font-weight: 800; letter-spacing: -.02em; margin-bottom: .25rem; }
            .future-login-subtitle { color: #5c749f; font-size: .9rem; margin-bottom: 1.2rem; }
            .future-login-form-wrap .control-label { color: #17396f; font-size: .83rem; font-weight: 700; margin-bottom: .3rem; }
            .future-login-form-wrap .form-control { border-radius: 8px; border: 1px solid #cfddf3; background: #f9fbff; min-height: 44px; font-weight: 600; }
            .future-login-form-wrap .form-control:focus { border-color: #2f68d6; box-shadow: 0 0 0 .17rem rgba(47, 104, 214, .14); background: #fff; }
            .future-login-form-wrap .btn-dark { border: 0; border-radius: 8px; min-height: 46px; font-weight: 700; background: linear-gradient(132deg, #2056c1, #3a7af2); box-shadow: 0 12px 24px rgba(32, 86, 193, .24); }
            .future-login-form-wrap .btn-dark:hover { transform: translateY(-1px); }
            .future-login-form-wrap a { color: #2d64cf; font-weight: 700; font-size: .84rem; }
            .future-login-meta { margin-top: .85rem; text-align: center; color: #526a94; font-size: .83rem; font-weight: 600; }
            .future-login-meta a { color: #2c66d2; font-weight: 800; }
        </style>
    @elseif($isModernAdminTemplate)
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&display=swap');

            body.app.flex-row {
                min-height: 100vh;
                font-family: 'Manrope', sans-serif;
                background:
                    radial-gradient(900px 500px at 15% 10%, rgba(47, 116, 230, .22), transparent 60%),
                    radial-gradient(700px 420px at 86% 20%, rgba(16, 185, 129, .18), transparent 62%),
                    linear-gradient(140deg, #0f1f46 0%, #16326e 55%, #1f4c99 100%);
            }

            .auth-reset-shell {
                background: #fff;
                border-radius: 22px;
                box-shadow: 0 25px 60px rgba(7, 18, 45, .35);
                overflow: hidden;
                padding: 2.1rem 2.1rem 1.6rem;
            }

            .auth-reset-title {
                color: #17356e;
                font-weight: 800;
                letter-spacing: -.02em;
                margin-bottom: 1rem;
            }

            .auth-reset-shell .nav-tabs {
                border: 0;
                background: #f1f5ff;
                border-radius: 12px;
                padding: .25rem;
                gap: .35rem;
            }

            .auth-reset-shell .nav-tabs .nav-link {
                border: 0;
                border-radius: 10px;
                color: #385a93;
                font-weight: 700;
                font-size: .86rem;
                background: transparent;
            }

            .auth-reset-shell .nav-tabs .nav-link.active {
                background: #fff;
                color: #15386f;
                box-shadow: 0 6px 15px rgba(23, 54, 111, .12);
            }

            .auth-reset-shell .form-control {
                border-radius: 12px;
                border: 1px solid #d8e2f1;
                background: #f7faff;
                min-height: 44px;
                font-weight: 600;
            }

            .auth-reset-shell .btn-dark {
                border: 0;
                border-radius: 12px;
                background: linear-gradient(135deg, #1f4fb4, #2f74e6);
                font-weight: 700;
                min-height: 46px;
                box-shadow: 0 12px 25px rgba(30, 85, 184, .24);
            }

            .auth-page-meta {
                margin-top: .95rem;
                text-align: center;
                font-size: .84rem;
                font-weight: 600;
                color: #d5e3ff;
            }

            .auth-page-meta a {
                color: #ffffff;
                font-weight: 700;
            }
        </style>
    @endif
    @unless($isFutureAdminTemplate)
        <style>
            .auth-reset-shell,
            .auth-reset-shell .nav-tabs,
            .auth-reset-shell .nav-tabs .nav-link,
            .form-control,
            .btn,
            .input-group-text {
                border-radius: 2px !important;
            }
        </style>
    @endunless
@endsection

@section('content')
    @if($isFutureAdminTemplate)
        <div class="future-login-wrapper">
            <div class="row no-gutters future-login-shell">
                <div class="col-lg-6">
                    <div class="future-login-side">
                        <span class="future-login-badge"><i class="la la-shield"></i> Recupero Password</span>
                        <h3 class="future-login-logo mb-0">
                            <?php $website = \App\Models\WebsiteSetting::first(); ?>
                            @if(!$website->logo_login)
                                <img src="{{ url('img/commons/admin/logo-dashboard.png') }}" title="Logo">
                            @else
                                <img src="{{ url($website->logo_login) }}" title="Logo">
                            @endif
                        </h3>
                        <div class="future-login-title">Reimposta l'accesso in modo rapido e sicuro.</div>
                        <p class="future-login-text">Inserisci la tua email amministratore: riceverai il link per impostare una nuova password.</p>
                        <ul class="future-login-points">
                            <li><i class="la la-check-circle"></i> Procedura guidata in 2 passaggi</li>
                            <li><i class="la la-check-circle"></i> Link di ripristino personale</li>
                            <li><i class="la la-check-circle"></i> Accesso protetto al pannello</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 future-login-form-col">
                    <div class="future-login-form-wrap">
                        <h3>Recupero Password</h3>
                        <div class="future-login-subtitle">Passo 1: conferma la tua email.</div>
                        @if (session('status'))
                            <div class="alert alert-success mt-2">{{ session('status') }}</div>
                        @else
                            <form role="form" method="POST" action="{{ route('backpack.auth.password.email') }}">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="control-label" for="email">{{ trans('backpack::base.email_address') }}</label>
                                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-block btn-dark">{{ trans('backpack::base.send_reset_link') }}</button>
                                </div>
                            </form>
                        @endif
                        <div class="text-center mt-3">
                            <a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
                            @if (config('backpack.base.registration_open'))
                                / <a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="future-login-meta">
                Realizzato da <a target="_blank" rel="noopener" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="auth-reset-shell">
                    <h3 class="text-center auth-reset-title">Recupero Password</h3>
                    <h3 class="text-center mb-4">
                        <?php $website = \App\Models\WebsiteSetting::first(); ?>
                        @if(!$website->logo_login)
                            <img src="{{ url('img/commons/admin/logo-dashboard.png') }}" title="Logo">
                        @else
                            <img src="{{ url($website->logo_login) }}" width="180" title="Logo">
                        @endif
                    </h3>
                    <div class="nav-steps-wrapper">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active"><a class="nav-link active" href="#tab_1" data-toggle="tab"><strong>{{ trans('backpack::base.step') }} 1.</strong> {{ trans('backpack::base.confirm_email') }}</a></li>
                            <li class="nav-item"><a class="nav-link disabled text-muted"><strong>{{ trans('backpack::base.step') }} 2.</strong> {{ trans('backpack::base.choose_new_password') }}</a></li>
                        </ul>
                    </div>
                    <div class="nav-tabs-custom mt-3">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                @if (session('status'))
                                    <div class="alert alert-success mt-3">{{ session('status') }}</div>
                                @else
                                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.password.email') }}">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <label class="control-label" for="email">{{ trans('backpack::base.email_address') }}</label>
                                            <div>
                                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <button type="submit" class="btn btn-block btn-dark">{{ trans('backpack::base.send_reset_link') }}</button>
                                        </div>
                                    </form>
                                @endif
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
                        @if (config('backpack.base.registration_open'))
                            / <a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
                        @endif
                    </div>
                </div>
                <div class="auth-page-meta">
                    Realizzato da <a target="_blank" rel="noopener" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>
                </div>
            </div>
        </div>
    @endif
@endsection
