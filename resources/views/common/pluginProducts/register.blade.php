<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$shopSetting = \App\Models\ShopSettings::first();
?>
<main>
    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body p-md-5">
                            <h4 class="text-center mb-1">{{ @$labels['shop-registrati-nuovo'] }}</h4>
                            <h6 class="text-center mb-4">{{ @$labels['shop-registrati-info-1'] }} <a href="{{ url('/login') }}">{{ @$labels['shop-registrati-accedi'] }}</a></h6>

                            @if ($errors->any())
                                <div class="alert alert-danger text-center alert-fixed-bottom-xs">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }} <br>
                                    @endforeach
                                </div>
                            @endif

                            @if(session()->has('message'))
                                <div class="alert alert-info">
                                    <div class="display-4"><i class="fa fa-check"></i></div>
                                    <h5>{!! session()->get('message') !!} </h5>
                                    <p>{!! session()->get('submessage') !!}</p>
                                </div>
                            @else

                                <div class="row">
                                    @if(env('FACEBOOK_ID'))
                                        <div class="ml-auto col-md-auto text-center my-2">
                                            <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook btn-block mb-2"> <i class="fab fa-facebook-f mr-2"></i> {{ @$labels['shop-registrati-fb'] }}</a>
                                        </div>
                                    @endif
                                    @if(env('GOOGLE_ID'))
                                        <div class="mr-auto col-md-auto text-center my-2">
                                            <div id="google-btn" class="mb-4">
                                                <span class="btn btn-google btn-block"><i class="fab fa-google mr-2"></i> {{ @$labels['shop-registrati-google'] }}</span>
                                            </div>
                                            <script>startApp();</script>
                                        </div>
                                    @endif
                                </div>

                                <form action="{{ route('index.registerProcess') }}" method="post" id="form">
                                    @honeypot

                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="name">{{ @$labels['shop-registrati-nome-cognome'] }}</label>
                                                <input required type="text" class="form-control" id="name" name="name" placeholder="{{ @$labels['shop-registrati-inserisci-nome-cognome'] }}" value="{{ old('name') }}" data-cons-subject="full_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                                <label for="email">{{ @$labels['shop-registrati-email'] }}</label>
                                                <input  type="email" class="form-control" id="email" name="email" placeholder="{{ @$labels['shop-registrati-inserisci-email'] }}" value="{{ old('email') }}" data-cons-subject="email" required>
                                                <small class="mt-2 text-muted d-block"><i class="fas fa-lock"></i> {{ @$labels['shop-registrati-info-2'] }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">{{ @$labels['shop-registrati-telefono'] }}</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Inserisci il tuo numero di cellulare" value="{{ old('mobile') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="create_password">{{ @$labels['shop-registrati-psw2'] }}</label>
                                        <!-- <input type="password" class="form-control" id="password1" name="password" required>-->
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text pointer"> <i id="icon_password" class="fas fa-eye-slash" onclick="nascondi_password('#password', '#icon_password')"></i></span>
                                            </div>
                                        </div>

                                        <small class="mt-2 text-muted">{{ @$labels['shop-registrati-info-3'] }}</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">{{ @$labels['shop-registrati-conferma-psw2'] }}</label>

                                        <div class="input-group">
                                            <input required type="password" class="form-control" id="password2" name="password_confirmation" minlength="8" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text pointer"> <i id="icon_password2" class="fas fa-eye-slash" onclick="nascondi_password('#password2', '#icon_password2')"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="small">{{ @$labels['shop-registrati-letto-privacy'] }} *
                                        @if($shopSetting->url_privacy)
                                            <a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a>
                                        @else
                                            @if($website->iubenda_privacy)
                                                {!! $website->iubenda_privacy !!}
                                            @endif
                                        @endif
                                    </p>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_privacy_1" name="check_privacy" value="1" data-cons-preference="privacy" required>
                                            <label class="custom-control-label" for="check_privacy_1">{{ @$labels['shop-registrati-privacy'] }}</label>
                                        </div>
                                    </div>

                                    <p class="small">{{ @$labels['shop-registrati-info-4'] }}</p>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_newsletter" name="check_newsletter" value="1" data-cons-preference="newsletter">
                                            <label class="custom-control-label" for="check_newsletter">{{ @$labels['shop-registrati-newsletter'] }}</label>
                                        </div>
                                    </div>


                                    <div class="form-group my-0">
                                        <button id="submit_button" type="submit" class="btn btn-primary btn-block btn-lg mt-auto" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-registrati-registrati-3'] }}</button>
                                    </div> <!-- form-group// -->
                                </form>


                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
