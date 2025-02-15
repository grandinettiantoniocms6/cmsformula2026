<?php
$shopSetting = \App\Models\ShopSettings::first();
$labels1 = \App\Models\Label::get()->pluck("value", "key")->toArray();
$labels2 = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();

$labels = array_merge($labels1, $labels2);
$pluginSetting = \App\Models\PluginProductsSettings::first();
?>

<section class="page-register flex-grow-1">
    <div class="container-fluid container-2xl">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card card-register">
                    <div class="card-body">
                        <h3 class="text-center mb-1">{{ @$labels['register-registrati-nuovo'] }}</h3>
                        <h6 class="text-center mb-4">{{ @$labels['register-registrati-info-1'] }} <a href="{{ url('/login') }}">{{ @$labels['register-registrati-accedi'] }}</a></h6>

                        @if($pluginSetting->type_registration_form == 0)
                            @if ($errors->any())
                                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }} <br>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session()->has('message'))
                                <div class="alert alert-info">
                                    <div class="display-4"><i class="bi bi-check-circle"></i></div>
                                    <h5>{!! session()->get('message') !!} </h5>
                                    <p>{!! session()->get('submessage') !!}</p>
                                </div>
                            @else

                                <div class="row justify-content-center gx-2 mb-4">
                                    @if(env('FACEBOOK_ID'))
                                        <div class="col-md-auto my-1">
                                            <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook w-100"><i class="fab fa-facebook-f me-2"></i> {{ @$labels['register-registrati-fb'] }}</a>
                                        </div>
                                    @endif
                                    @if(env('GOOGLE_ID'))
                                        <div class="col-md-auto my-1">
                                            <div id="google-btn">
                                                <span class="btn btn-google w-100"><i class="fab fa-google me-2"></i> {{ @$labels['register-registrati-google'] }}</span>
                                            </div>
                                            <script>startApp();</script>
                                        </div>
                                    @endif
                                </div>

                                <form id="register-form" method="post" action="{{ route('index.registerProcess') }}" class="form-validate">
                                    @honeypot

                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="name" class="form-label">{{ @$labels['register-registrati-nome-cognome'] }}</label>
                                                <input required type="text" class="form-control" id="name" name="name" placeholder="{{ @$labels['register-registrati-inserisci-nome-cognome'] }}" value="{{ old('name') }}" data-cons-subject="full_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="email" class="form-label">{{ @$labels['register-registrati-email'] }}</label>
                                                <input  type="email" class="form-control" id="email" name="email" placeholder="{{ @$labels['register-registrati-inserisci-email'] }}" value="{{ old('email') }}" data-cons-subject="email" required>
                                                <div class="mt-1 font-xs"><i class="bi bi-lock me-1"></i> {{ @$labels['register-registrati-info-2'] }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile" class="form-label">{{ @$labels['register-registrati-telefono'] }}</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="{{ @$labels['register-registrati-telefono'] }}" value="{{ old('mobile') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="create_password" class="form-label">{{ @$labels['register-registrati-psw2'] }}</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                            <span class="input-group-text pointer bg-transparent"><i id="icon_password" class="fas fa-eye-slash" onclick="nascondi_password('#password', '#icon_password')"></i></span>
                                        </div>
                                        <div class="mt-1 font-xs">{{ @$labels['register-registrati-info-3'] }}</div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" class="form-label">{{ @$labels['register-registrati-conferma-psw2'] }}</label>
                                        <div class="input-group">
                                            <input required type="password" class="form-control" id="password2" name="password_confirmation" minlength="8" required>
                                            <span class="input-group-text pointer bg-transparent"><i id="icon_password2" class="fas fa-eye-slash" onclick="nascondi_password('#password2', '#icon_password2')"></i></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="font-sm">{{ @$labels['register-registrati-letto-privacy'] }} *
                                            @if($shopSetting->url_privacy)
                                                <a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a>
                                            @else
                                                <?php $website = \App\Models\WebsiteSetting::first(); ?>
                                                @if($website->iubenda_privacy)
                                                    {!! $website->iubenda_privacy !!}
                                                @endif
                                            @endif
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_privacy_1" name="check_privacy" value="1" data-cons-preference="privacy" required>
                                            <label class="form-check-label" for="check_privacy_1">{{ @$labels['register-registrati-privacy'] }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="font-sm">{{ @$labels['register-registrati-info-4'] }}</div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="check_newsletter" name="check_newsletter" value="1" data-cons-preference="newsletter">
                                            <label class="form-check-label" for="check_newsletter">{{ @$labels['register-registrati-newsletter'] }}</label>
                                        </div>
                                    </div>

                                    <button id="submit_button" type="submit" class="btn btn-primary btn-lg w-100" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['register-registrati-registrati-3'] }}</button>
                                </form>
                            @endif
                        @endif

                        @if($pluginSetting->type_registration_form > 0)
                            <?php

                            $countries = \App\Models\Country::orderBy("name", "asc")->get();
                            $cities = \App\Models\City::orderBy("sigla_provincia", "asc")->groupBy("sigla_provincia")->get();
                            ?>

                            @if ($errors->any())
                                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }} <br>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session()->has('message'))
                                <div class="alert alert-info">
                                    <div class="display-4"><i class="bi bi-check-circle"></i></div>
                                    <h5>{!! session()->get('message') !!} </h5>
                                    <p>{!! session()->get('submessage') !!}</p>
                                </div>
                            @else

                           <form method="post" action="{{ route('index.registerProcessFull') }}" id="form">
                               @if(\request()->has('plugin_product_id'))
                                   <input type="hidden" name="plugin_product_id" value="{{ \request()->get('plugin_product_id') }}">
                               @endif

                            {{ csrf_field() }}
                            <div class="container">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="style-danger my-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">

                                        @if($pluginSetting->type_registration_form == 1)
                                            <div class="card-step">
                                                <h5>{{ @$labels['shop-checkout-tipo-cliente'] }}</h5>
                                                <div class="form-group">
                                                    <select class="form-select" name="type_client" id="type_client">
                                                        <option value="0">{{ @$labels['shop-checkout-privato'] }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif

                                        @if($pluginSetting->type_registration_form == 2)
                                            <div class="card-step">
                                                <h5>{{ @$labels['shop-checkout-tipo-cliente'] }}</h5>
                                                <div class="form-group">
                                                    <select class="form-select" name="type_client" id="type_client">
                                                        <option value="1">{{ @$labels['shop-checkout-azienda'] }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif

                                        @if($pluginSetting->type_registration_form == 3)
                                            <div class="card-step">
                                                <h5>{{ @$labels['shop-checkout-tipo-cliente'] }}</h5>
                                                <div class="form-group">
                                                    <select class="form-select" name="type_client" id="type_client">
                                                        <option value="0">{{ @$labels['shop-checkout-privato'] }}</option>
                                                        <option value="1">{{ @$labels['shop-checkout-azienda'] }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="card-step">
                                            <h5>{{ @$labels['shop-indirizzo-spedizione'] }}</h5>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-email-nologin'] }}</label>
                                                        <input type="email" class="form-control" name="email_access" id="email_access" data-cons-subject="email" required autocomplete='one-time-code'>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-telefono'] }}</label>
                                                        <input type="text" class="form-control" name="mobile_phone" id="mobile_phone" required autocomplete='one-time-code'>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="create_password" class="form-label">{{ @$labels['register-registrati-psw2'] }}</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password" name="password" minlength="8" required autocomplete='one-time-code'>
                                                    <span class="input-group-text pointer bg-transparent"><i id="icon_password" class="fas fa-eye-slash" onclick="nascondi_password('#password', '#icon_password')"></i></span>
                                                </div>
                                                <div class="mt-1 font-xs">{{ @$labels['register-registrati-info-3'] }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="confirm_password" class="form-label">{{ @$labels['register-registrati-conferma-psw2'] }}</label>
                                                <div class="input-group">
                                                    <input required type="password" class="form-control" id="password2" name="password_confirmation" minlength="8" required autocomplete='one-time-code'>
                                                    <span class="input-group-text pointer bg-transparent"><i id="icon_password2" class="fas fa-eye-slash" onclick="nascondi_password('#password2', '#icon_password2')"></i></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-nome'] }}</label>
                                                        <input type="text" class="form-control" name="first_name" id="first_name" data-cons-subject="first_name" autocomplete='one-time-code' required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-cognome'] }}</label>
                                                        <input type="text" class="form-control" name="last_name" id="last_name" data-cons-subject="last_name" autocomplete='one-time-code' required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-nazione'] }}</label>
                                                        <div class="form-select-container">
                                                            <select class="form-select" name="country_id" id="country_id" onchange="change_country('country_id')" autocomplete="nope" required>
                                                                <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                                                @if($countries)
                                                                    @foreach ($countries as $country)
                                                                        @if($country->id == old('country_id'))
                                                                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                                                        @else
                                                                            <option value="{{ $country->id }}" @if($country->id == 106) selected @endif>{{ $country->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group" id="box_province">
                                                        <label class="form-label">{{ @$labels['shop-provincia'] }}</label>
                                                        <div class="form-select-container">
                                                            <select name="province" id="provinceSel" class="form-select" onchange="change_province('provinceSel')" autocomplete="nope">
                                                                <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                                                @foreach ($cities as $city)
                                                                    @php
                                                                        $selected = '';
                                                                        if(old('province') == $city->sigla_provincia){
                                                                            $selected = 'selected';
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $city->sigla_provincia }}" {{ $selected }}>{{ $city->sigla_provincia }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="box_city_temp"></div>
                                            <div id="box_city"></div>
                                            <div id="box_city_edit"></div>

                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                                        <input type="text" class="form-control" name="address" id="address" required>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-civico'] }}</label>
                                                        <input type="text" class="form-control" name="number_street" id="number_street" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="box_codice_fiscale">
                                                <div class="form-group">
                                                    <label class="form-label">{{ @$labels['shop-checkout-codfis'] }}</label>
                                                    <input type="text" class="form-control" id="fiscal_code" name="fiscal_code" minlength="16" maxlength="16" data-rule-codicefiscale="true" required>
                                                </div>
                                            </div>

                                            @include("$thema.plugins.pluginProducts.v3.partials.checkout.custom_fields_shipping")
                                        </div>

                                        <div class="card-step">
                                            <div id="campi_aggiuntivi_fatturazione_privato"></div>
                                            <div id="fatturazione">
                                                <h5>{{ @$labels['shop-indirizzo-fatturazione-no-login'] }}</h5>

                                                <div class="form-group">
                                                    <label class="form-label">{{ @$labels['shop-checkout-nominativo'] }}</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="" required>
                                                </div>

                                                <div id="box_azienda">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-ragione-sociale'] }}</label>
                                                        <input type="text" class="form-control" name="business_name" id="business_name" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-pec'] }}</label>
                                                        <input type="text" class="form-control" id="pec" name="pec">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">{{ @$labels['shop-checkout-sdi'] }}</label>
                                                        <input type="text" class="form-control" id="sdi" name="sdi">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">{{ @$labels['shop-checkout-piva'] }}</label>
                                                    <input type="text" class="form-control" id="fiscal_code_vat" name="fiscal_code_vat" minlength="11" data-rule-piva="true" required>
                                                </div>

                                                <!-- <div class="form-group">
                                                    <label class="form-label">{{ @$labels['shop-checkout-codfis'] }}</label>
                                                    <input type="text" class="form-control" id="fiscal_code" name="fiscal_code" minlength="16" maxlength="16" data-rule-codicefiscale="true" required>
                                                </div>-->

                                                <div class="form-group">
                                                    <label class="form-label">{{ @$labels['shop-checkout-nazione'] }}</label>
                                                    <div class="form-select-container">
                                                        <select class="form-control select2 required-if-show-address" name="country_id_fatt" id="country_id_fatt" required>
                                                            <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                                            @if($countries)
                                                                @foreach ($countries as $country)
                                                                    @if($country->id == old('country_id_fatt'))
                                                                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                                                    @else
                                                                        <option value="{{ $country->id }}" @if($country->id == 106) selected @endif>{{ $country->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ @$labels['shop-checkout-citta'] }}</label>
                                                            <input type="text" class="form-control" name="city_fatt" id="city_fatt" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ @$labels['shop-checkout-provincia'] }}</label>
                                                            <input type="text" class="form-control" name="province_fatt" id="province_fatt" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ @$labels['shop-checkout-cap'] }}</label>
                                                            <input type="text" class="form-control" name="postal_code_fatt" id="postal_code_fatt">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                                            <input type="text" class="form-control" name="address_fatt" id="address_fatt" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ @$labels['shop-checkout-civico'] }}</label>
                                                            <input type="text" class="form-control" name="number_street_fatt" id="number_street_fatt" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="campi_aggiuntivi"></div>
                                            </div>


                                            <div class="form-group">
                                                <div class="font-sm">{{ @$labels['register-registrati-letto-privacy'] }} *
                                                    @if($shopSetting->url_privacy)
                                                        <a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a>
                                                    @else
                                                        <?php $website = \App\Models\WebsiteSetting::first(); ?>
                                                        @if($website->iubenda_privacy)
                                                            {!! $website->iubenda_privacy !!}
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="check_privacy_1" name="check_privacy" value="1" data-cons-preference="privacy" required>
                                                    <label class="form-check-label" for="check_privacy_1">{{ @$labels['register-registrati-privacy'] }}</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="font-sm">{{ @$labels['register-registrati-info-4'] }}</div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="check_newsletter" name="check_newsletter" value="1" data-cons-preference="newsletter">
                                                    <label class="form-check-label" for="check_newsletter">{{ @$labels['register-registrati-newsletter'] }}</label>
                                                </div>
                                            </div>

                                            <button id="submit_button" type="submit" class="btn btn-primary btn-lg w-100" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-registrati-registrati-3'] }}</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                           @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
    <script src="{{ url("packages/jquery-validation-1.19.5/localization/messages_".\App::getLocale().".min.js") }}"></script>

    <script>
        jQuery.validator.addMethod('emailfull', function(value, element) {
            return this.optional(element) || /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i.test(value);
        }, '{{ @$labels2['shop-register-email-non-corretta'] }}');

        jQuery.validator.addMethod('emailstrict', function(value, element) {
            return this.optional(element) || /^[^@]{2,}@[^@]{2,}\.[^@.]{2,}$/i.test(value);
        }, '{{ @$labels2['shop-register-email-non-corretta'] }}');

        jQuery.validator.addMethod("piva", function(value, element) {
            const PiControl = /^[0-9]{11}$/;
            return this.optional(element) || PiControl.test(value);
        }, "{{ @$labels2['shop-register-partitaiva-non-corretta'] }}");

        jQuery.validator.addMethod("codicefiscale", function(value, element) {
            const CFControl = /^[A-Za-z]{6}[0-9LMNPQRSTUV]{2}[ABCDEHLMPRST]{1}[0-9LMNPQRSTUV]{2}[A-Za-z]{1}[0-9LMNPQRSTUV]{3}[A-Za-z]{1}$/;
            return this.optional(element) || CFControl.test(value.toUpperCase());
        }, "{{ @$labels2['shop-register-codice-fiscale-non-corretto'] }}");

        $.extend( $.validator.messages, {
            nowhitespace: "Spazio bianco non ammesso",
        });

        $('#form').validate({
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "invalid-feedback" );

                switch (element.attr('type')) {
                    case 'checkbox':
                        element.closest('.form-group').append( error );
                        break;
                    case 'password':
                        element.closest('.form-group').append( error );
                        break;
                    case 'file':
                        element.closest('.form-group').append( error );
                        break;
                    default:
                        error.insertAfter( element );
                }
            },
            messages: {
                password: {
                    nowhitespace: "Non sono ammessi spazi"
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
        });

        $('#register-form').validate({
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "invalid-feedback" );

                switch (element.attr('type')) {
                    case 'checkbox':
                        element.closest('.form-group').append( error );
                        break;
                    case 'password':
                        element.closest('.form-group').append( error );
                        break;
                    case 'file':
                        element.closest('.form-group').append( error );
                        break;
                    default:
                        error.insertAfter( element );
                }
            },
            messages: {
                password: {
                    nowhitespace: "Non sono ammessi spazi"
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
        });
    </script>

    @if($pluginSetting->type_registration_form > 0)
    <script type="text/javascript">
        $(document).ready(function(){
            @if($pluginSetting->type_registration_form != 2)
                $("#box_azienda").hide();

                var token = '{{ csrf_token() }}';
                $("#box_province").hide();
                $("#provinceSel").removeAttr("required-if-show");

                $("#box_province_new_address").hide();
                $("#provinceSel2").removeAttr("required-if-show-address");
                $("#box_city_new_address").html("<div class=\"row\"><div class=\"col-8\"><div class=\"form-group\"><input type=\"hidden\" class=\"form-control\" name=\"province_2\" id=\"province_2\" value=\"\"><label for=\"city_id\">Città *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"city_id_2\" id=\"city_id_2\" value=\"\"></div></div><div class=\"col-4\"><div class=\"form-group\"><label for=\"zip_2\">CAP *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"zip_2\" id=\"zip_2\" value=\"\"></div></div></div>");

                $("#country_id").val("106").trigger('change');
                $("#fatturazione").hide();
                $('#name').attr('required', 'false');
                $('#fiscal_code_vat').attr('required', 'false');
               // $('#fiscal_code').attr('required', 'false');
                $('#city_fatt').attr('required', 'false');
                $('#province_fatt').attr('required', 'false');
                $('#address_fatt').attr('required', 'false');
                $('#number_street_fatt').attr('required', 'false');
                $('#business_name').attr('required', 'false');
                $('#country_id_fatt').attr('required', 'false');

                $('#name').attr('disabled', 'true');
                $('#fiscal_code_vat').attr('disabled', 'true');
             //   $('#fiscal_code').attr('disabled', 'false');
                $('#city_fatt').attr('disabled', 'true');
                $('#province_fatt').attr('disabled', 'true');
                $('#address_fatt').attr('disabled', 'true');
                $('#number_street_fatt').attr('disabled', 'true');
                $('#business_name').attr('disabled', 'true');
                $('#country_id_fatt').attr('disabled', 'true');
            @else
                $('#fiscal_code').removeAttr('required');
                $("#box_codice_fiscale").hide();
            @endif

            $('#type_client').change(function(){


                var value = $(this).val();
                if( value == 0 ){
                    $("#box_azienda").hide();
                    $('#business_name').removeAttr('required');
                    $('#fiscal_code_vat').removeAttr('required');
                    $('#fiscal_code').attr('required', 'true');
                    $("#box_codice_fiscale").show();
                } else {
                    $("#box_azienda").show();
                    $('#business_name').attr('required', 'true');
                    $('#fiscal_code_vat').attr('required', 'true');
                    $('#fiscal_code').removeAttr('required');
                    $("#box_codice_fiscale").hide();
                }

                $("#campi_aggiuntivi_fatturazione_privato").html("");
                $("#campi_aggiuntivi").html("");

                var token = '{{ csrf_token() }}';
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.checkout.get_fields_custom_checkout') }}',
                    data: 'value='+value+'&_token=' + token,
                    success: function (data) {
                        if(value == 1){
                            $("#campi_aggiuntivi").html(data);
                        }else{
                            $("#campi_aggiuntivi_fatturazione_privato").html(data);
                        }

                    },
                    error: function() {}
                });
            });

            $('#type_client').change(function(){
                var value = $(this).val();

                if(value == 1){
                    $("#campi_aggiuntivi_fatturazione_privato").hide();
                    $("#fatturazione").show();
                }else{
                    $("#campi_aggiuntivi_fatturazione_privato").show();
                    $("#fatturazione").hide();
                }

                if($('#fatturazione').is(':visible')){
                    $('#type_client').attr('required', 'true');
                    $('#name').attr('required', 'true');
                    $('#fiscal_code_vat').attr('required', 'true');
                    $('#city_fatt').attr('required', 'true');
                    $('#province_fatt').attr('required', 'true');
                    $('#address_fatt').attr('required', 'true');
                    $('#number_street_fatt').attr('required', 'true');

                    $('#name').removeAttr('disabled');
                    $('#fiscal_code_vat').removeAttr('disabled');
                    $('#city_fatt').removeAttr('disabled');
                    $('#province_fatt').removeAttr('disabled');
                    $('#address_fatt').removeAttr('disabled');
                    $('#number_street_fatt').removeAttr('disabled');
                    $('#business_name').removeAttr('disabled');
                    $('#country_id_fatt').removeAttr('disabled');
                }else{
                    $('#campi_aggiuntivi').html("");
                    $('#type_client').attr('required', 'false');
                    $('#name').attr('required', 'false');
                    $('#fiscal_code_vat').attr('required', 'false');
                    $('#city_fatt').attr('required', 'false');
                    $('#province_fatt').attr('required', 'false');
                    $('#address_fatt').attr('required', 'false');
                    $('#number_street_fatt').attr('required', 'false');
                    $('#business_name').attr('required', 'false');
                    $('#country_id_fatt').attr('required', 'false');

                    $('#name').attr('disabled', 'true');
                    $('#fiscal_code_vat').attr('disabled', 'true');
                    $('#city_fatt').attr('disabled', 'true');
                    $('#province_fatt').attr('disabled', 'true');
                    $('#address_fatt').attr('disabled', 'true');
                    $('#number_street_fatt').attr('disabled', 'true');
                    $('#business_name').attr('disabled', 'true');
                    $('#country_id_fatt').attr('disabled', 'true');
                }
            });
        });
    </script>
    @endif
@endsection
