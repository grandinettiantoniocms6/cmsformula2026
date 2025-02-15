<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<main>
    <section class="py-4">
        <div class="container">

            <div class="row">
                @if($shopSetting->is_registration_open == 1)
                   <div class="col-lg-8">
                @else
                   <div class="col-lg-12">
                @endif
                    <div class="card">
                        <div class="card-body p-md-5">
                            <h4 class="text-center mb-1">{{ @$labels['shop-title-login'] }}</h4>
                            <h6 class="text-center mb-4">{{ @$labels['shop-sottotitolo-login'] }}</h6>

                            @if ($errors->any())
                                <div class="alert alert-danger text-center alert-fixed-bottom-xs">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span></button>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif

                            @if(session()->has('message'))
                                <div class="alert alert-success text-center">
                                    <div class="display-4"><i class="fa fa-check"></i></div>
                                    <h5>{{ session()->get('message') }}</h5>
                                </div>
                            @endif

                            @if(session()->has('noUser'))
                                <div class="alert alert-danger text-center alert-fixed-bottom-xs">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span></button>
                                    {{ session()->get('noUser') }}
                                </div>
                            @endif

                            @if($shopSetting->is_registration_open == 1)
                                <div class="row">
                                    @if(env('FACEBOOK_ID'))
                                        <div class="ml-auto col-md-auto text-center my-2">
                                            <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook btn-block mb-2"> <i class="fab fa-facebook-f mr-2"></i> {{ @$labels['shop-accedi-fb'] }} </a>
                                        </div>
                                    @endif
                                    @if(env('GOOGLE_ID'))
                                        <div class="mr-auto col-md-auto text-center my-2">
                                            <div id="google-btn" class="mb-4">
                                                <span class="btn btn-google btn-block"><i class="fab fa-google mr-2"></i> {{ @$labels['shop-accedi-google'] }}</span>
                                            </div>
                                            <script>startApp();</script>
                                        </div>
                                    @endif

                                </div>
                            @endif

                            <form id="login-form" method="post" action="{{ route('index.loginProcess') }}" class="form-validate">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="email">{{ @$labels['shop-email-login'] }}</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div> <!-- form-group// -->
                                <div class="form-group">
                                    <label for="password">{{ @$labels['shop-password-login'] }}</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text pointer"> <i id="icon_password" class="fas fa-eye-slash" onclick="nascondi_password('#password', '#icon_password')"></i></span>
                                        </div>
                                    </div>
                                </div> <!-- form-group// -->

                                <div class="form-group d-flex justify-content-between">
                                    <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked=""><div class="custom-control-label">{{ @$labels['shop-ricorda-login'] }}</div></label>
                                    <a href="{{ route('recovery_password') }}" class="float-right">{{ @$labels['shop-password-dimenticata'] }}</a>
                                </div> <!-- form-group form-check .// -->
                                <div class="form-group my-0">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-login'] }}</button>
                                </div> <!-- form-group// -->
                            </form>
                        </div> <!-- card-body.// -->
                    </div>
                </div>

                @if($shopSetting->is_registration_open == 1)
                    <div class="col-lg-4 my-4 my-lg-0">
                        <div class="card card-body py-5 h-100">
                            <h4 class="text-center mb-1">{{ @$labels['shop-new-customer'] }}</h4>
                            <h6 class="text-center mb-5">{{ @$labels['shop-registra-account'] }}</h6>
                            <p>{{ @$labels['shop-descrizione-registrati'] }}</p>
                            <a href="{{ url("/".env('SLUG_REGISTER')) }}" class="btn btn-primary btn-block btn-lg mt-auto" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-registrati'] }}</a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>

</main>
