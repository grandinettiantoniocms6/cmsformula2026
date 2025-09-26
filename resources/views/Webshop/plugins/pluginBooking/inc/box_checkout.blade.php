<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
$shopSetting = \App\Models\ShopSettings::first();
?>

<?php
$start_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start);

$diff_day = 1;

if($session->end){
    $end_carbon = \Carbon\Carbon::createFromFormat("Y-m-d", $session->end);
    $diff_day = $start_carbon->diffInDays($end_carbon);
    if($diff_day == 0){
        $diff_day = 1;
    }
}

$type = \App\Models\PluginBookingType::find($session->type);

if($type->id == env('ID_TIPOLOGIA_MIN_MAX_GIORNI')){
    $diff_day = 1;
}

//$tot = $session->total * $diff_day;
$tot = $session->total;
?>

@include('Webshop.plugins.pluginBooking.inc.box_riassume')

@if(!\Session::has('user_id'))
    <div id="accordion-login" class="my-4">
        <div class="collapse show" id="collapse-login" data-bs-parent="#accordion-login">
            <form id="login-form" method="post" action="{{ route('pluginBooking.checkout.it') }}" class="card validation">
                {{ csrf_field() }}
                <div class="p-4 p-md-5">
                    <h4 class="text-center">{{ @$labels['booking-login-title'] }}</h4>
                    <p class="text-center">{{ @$labels['booking-login-non-hai-account'] }} <a id="register-link" class="text-underline" href="#collapse-register" data-bs-toggle="collapse" data-bs-target="#collapse-register">{{ @$labels['booking-login-registrati'] }}</a></p>

                    <?php /**
                    <div class="row">
                        <div class="col text-center">
                            <a href="#" class="btn btn-facebook"><i class="fab fa-facebook-f me-2"></i><span class="d-none d-lg-inline">Login con </span>Facebook</a>
                            <a href="#" class="btn btn-google"><i class="fab fa-google me-2"></i><span class="d-none d-lg-inline">Login con </span>Google</a>
                        </div>
                    </div>

                    <div class="row gx-1 my-4 align-items-center">
                        <div class="col"><hr></div>
                        <div class="col-auto font-xs font-sm-md px-sm-2"><em>Oppure accedi con le tue credenziali</em></div>
                        <div class="col"><hr></div>
                    </div>
                     **/ ?>

                    <div class="row">
                        <div class="col-xl-5">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" data-rule-nowhitespace="true" data-rule-emailfull="true" data-rule-emailstrict="true" required>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <div class="input-group">
                                        <input type="password" placeholder="Password" class="form-control form-control-lg" id="password" name="password" minlength="8" autocomplete="current-password" required>
                                        <span class="input-group-text pointer"> <i id="icon_password" class="fas fa-eye-slash" onclick="nascondi_password('#password', '#icon_password')"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-end mb-4">
                                <a class="text-body-color" href="#recovery_password" data-bs-target="#recovery_password" data-bs-toggle="modal">{{ @$labels['booking-login-psw-dimenticata'] }}</a>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <button type="button" onclick="validate_form('login-form')" class="btn btn-lg btn-primary w-100" name="button">{{ @$labels['booking-login-accedi'] }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="collapse" id="collapse-register" data-bs-parent="#accordion-login">
            @if ($errors->any())
                <div class="alert alert-danger text-center shadow-sm mb-4 alert-dismissible fade show" role="alert">
                    <div class="font-3xl"><i class="far fa-exclamation-triangle"></i></div>
                    @foreach ($errors->all() as $error)
                        <div>{!! $error !!}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session()->has('noUser'))
                <div class="alert alert-danger text-center shadow-sm mb-4  alert-dismissible fade show" role="alert">
                    <div class="font-3xl"><i class="far fa-exclamation-triangle"></i></div>
                    <strong>{{ session()->get('noUser') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-success text-center">
                    <div class="font-3xl"><i class="bi bi-check"></i></div>
                    <h5>{{ session()->get('message') }}</h5>
                    <a class="btn btn-primary px-md-4 mt-4 mb-2" href="{{ url('/') }}">{{ @$labels['booking-inizia-acquisti'] }}</a>
                </div>
            @else

                <form id="form" method="post" action="{{ route('pluginBooking.checkout.it') }}" class="card">
                    {{ csrf_field() }}
                    <div class="p-4 p-md-5">
                        <h4 class="text-center">{{ @$labels['booking-register-title'] }}</h4>
                        <p class="text-center">{{ @$labels['booking-register-subtitle'] }} <a id="login-link" data-bs-target="#collapse-login" data-bs-toggle="collapse" href="#collapse-login" class="text-underline">{{ @$labels['booking-login-accedi'] }}</a></p>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['booking-register-first-name'] }}*</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="{{ old('first_name') }}" data-cons-subject="first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['booking-register-last-name'] }}*</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="{{ old('last_name') }}" data-cons-subject="last_name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['booking-register-mobile'] }}*</label>
                                    <input type="hidden" id="prefix_mobile" name="prefix_mobile" value="">
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="" data-rule-number="false" data-rule-nowhitespace="true" value="{{ old('mobile') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Email *</label>
                                    <input  type="email" class="form-control" id="email" name="email" placeholder="" value="{{ old('email') }}" data-rule-nowhitespace="true" data-rule-emailstrict="true" data-rule-emailfull="true" autocomplete="email" data-cons-subject="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['booking-register-create-psw'] }}*</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_x" name="password" autocomplete="new-password" minlength="8" data-rule-nowhitespace="true" required>
                                        <span class="input-group-text pointer"> <i id="icon_password_x" class="fas fa-eye-slash" onclick="nascondi_password('#password_x', '#icon_password_x')"></i></span>
                                    </div>
                                    <div class="small line-height-sm py-2">{{ @$labels['booking-register-psw-info'] }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['booking-register-confirm-psw'] }}*</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" data-rule-equalto="#password_x" minlength="8" data-rule-nowhitespace="true" autocomplete="new-password" required>
                                        <span class="input-group-text pointer"> <i id="icon_password_confirmation" class="fas fa-eye-slash" onclick="nascondi_password('#password_confirmation', '#icon_password_confirmation')"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="font-sm">{{ @$labels['booking-registrati-letto-privacy'] }} *
                                @if($shopSetting->url_privacy)
                                    <a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a>
                                @else
                                    <?php $website = \App\Models\WebsiteSetting::first(); ?>

                                    @if(env('IUBENDA') == 1)
                                        @if($website->consent_solution_iubenda)
                                            {!! $website->consent_solution_iubenda !!}
                                        @endif
                                    @endif

                                    @if($website->iubenda_privacy)
                                        <span id="iubenda-badge"></span>
                                    @endif
                                @endif
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check_privacy_1" name="check_privacy" value="1" data-cons-preference="privacy" required>
                                <label class="form-check-label" for="check_privacy_1">{{ @$labels['booking-registrati-privacy'] }}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="font-sm">{{ @$labels['booking-registrati-info-4'] }}</div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="check_newsletter" name="check_newsletter" value="1" data-cons-preference="newsletter">
                                <label class="form-check-label" for="check_newsletter">{{ @$labels['booking-registrati-newsletter'] }}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
                            $key = config('app.recaptcha_key');
                            echo "<button class='button btn btn-lg btn-primary w-100 g-recaptcha' data-sitekey='$key' data-callback='onSubmit' data-action='submit' style='background-color: {$website->btn_background}; border-color: {$website->btn_colorborder};' type='submit' id='submit_button' > <span style='color: {$website->btn_txt_color}'> {$labels['booking-login-registrati']} </span></button>";
                            ?>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="modal" id="recovery_password" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ @$labels['booking-login-recupera-pwd'] }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="font-xl text-center line-height-sm">{{ @$labels['booking-login-recupera-pwd-info'] }}</p>

                    <form id="recovery-form" class="form-validate" role="form" method="POST" action="">

                        <div class="form-group">
                            <label for="email" class="form-label">{{ @$labels['booking-login-recupera-pwd-email'] }}</label>
                            <input type="email" class="form-control" id="email_recovery" name="email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-primary w-100 btn-lg" href="javascript:recovery_psw()">{{ @$labels['booking-login-recupera-pwd-button'] }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    @include('Webshop.plugins.pluginBooking.inc.box_payments')
@endif
