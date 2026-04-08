@extends(backpack_view('layouts.plain'))

@section('after_styles')
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

        .auth-reset-shell .nav-tabs .nav-link.disabled {
            opacity: .8;
        }

        .auth-reset-shell .form-control {
            border-radius: 12px;
            border: 1px solid #d8e2f1;
            background: #f7faff;
            min-height: 44px;
            font-weight: 600;
        }

        .auth-reset-shell .form-control:focus {
            border-color: #2f64d5;
            box-shadow: 0 0 0 .18rem rgba(47, 100, 213, .15);
            background: #fff;
        }

        .auth-reset-shell .btn-dark {
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, #1f4fb4, #2f74e6);
            font-weight: 700;
            min-height: 46px;
            box-shadow: 0 12px 25px rgba(30, 85, 184, .24);
        }

        .auth-reset-shell a {
            color: #2b63ce;
            font-weight: 600;
        }

        @media (max-width: 767.98px) {
            .auth-reset-shell {
                border-radius: 18px;
                padding: 1.3rem 1.15rem 1.2rem;
            }

            .auth-reset-title {
                font-size: 1.45rem;
            }

            .auth-reset-shell .nav-tabs .nav-link {
                font-size: .8rem;
            }
        }
    </style>
@endsection

{{-- Main Content --}}
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-lg-6">
            <div class="auth-reset-shell">
                <h3 class="text-center auth-reset-title">Recupero Password</h3>
                <h3 class="text-center mb-4">
                    <?php $website = \App\Models\WebsiteSetting::first(); ?>
                    @if(!$website->logo_login)
                        <img src="{{ url('public/img/commons/admin/logo-cms-formula-5_2.png') }}" title="Logo">
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
                        <div class="alert alert-success mt-3">
                            {{ session('status') }}
                        </div>
                    @else
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.password.email') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="email">{{ trans('backpack::base.email_address') }}</label>

                            <div>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-block btn-dark">
                                {{ trans('backpack::base.send_reset_link') }}
                            </button>
                        </div>
                    </form>
                    @endif
                    <div class="clearfix"></div>
                      </div>
                      {{-- /.tab-pane --}}
                    </div>
                    {{-- /.tab-content --}}
                </div>

                  <div class="text-center mt-4">
                    <a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>

                    @if (config('backpack.base.registration_open'))
                    / <a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
                    @endif
                  </div>
            </div>
        </div>
    </div>
@endsection
