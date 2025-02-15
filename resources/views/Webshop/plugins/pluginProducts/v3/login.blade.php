<?php
$shopSetting = \App\Models\ShopSettings::first();
$labels = \App\Models\Label::get()->pluck("value", "key")->toArray();
?>

<section class="page-login flex-grow-1">
    <div class="container-fluid container-2xl">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card card-login">
                    <div class="card-body">
                        <h3 class="text-center mb-1">{{ @$labels['login-title-login'] }}</h3>
                        <h6 class="text-center mb-4">{{ @$labels['login-sottotitolo-login'] }}</h6>

                        @if ($errors->any())
                            <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session()->has('message'))
                            <div class="alert alert-success text-center">
                                <div class="display-4"><i class="bi bi-check"></i></div>
                                <h5>{{ session()->get('message') }}</h5>
                            </div>
                        @endif

                        @if(session()->has('noUser'))
                            <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                {{ session()->get('noUser') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($shopSetting->is_registration_open == 1)
                            <div class="row justify-content-center gx-2 mb-4">
                                @if(env('FACEBOOK_ID'))
                                    <div class="col-md-auto my-1">
                                        <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook w-100"><i class="fab fa-facebook-f me-2"></i> {{ @$labels['login-registrati-fb'] }}</a>
                                    </div>
                                @endif
                                @if(env('GOOGLE_ID'))
                                    <div class="col-md-auto my-1">
                                        <div id="google-btn">
                                            <span class="btn btn-google w-100"><i class="fab fa-google me-2"></i> {{ @$labels['login-registrati-google'] }}</span>
                                        </div>
                                        <script>startApp();</script>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <form id="login-form" method="post" action="{{ route('index.loginProcess') }}" class="form-validate">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email" class="form-label">{{ @$labels['login-email-login'] }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ @$labels['login-email-login'] }}" data-rule-nowhitespace="true" data-rule-emailstrict="true" data-rule-emailfull="true" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">{{ @$labels['login-password-login'] }}</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ @$labels['login-password-login'] }}" minlength="8" data-rule-nowhitespace="true" required>
                                    <span class="input-group-text pointer bg-transparent"><i id="icon_password" class="fas fa-eye-slash" onclick="nascondi_password('#password', '#icon_password')"></i></span>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">{{ @$labels['login-ricorda-login'] }}</label>
                                </div>
                                <a href="{{ route('recovery_password') }}">{{ @$labels['login-password-dimenticata'] }}</a>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-lg w-100">{{ @$labels['login-login'] }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if($shopSetting->is_registration_open == 1)
                <div class="col-lg-4 my-4 my-lg-0">
                    <div class="card card-register">
                        <div class="card-body">
                            <h3 class="text-center mb-1 mt-auto">{{ @$labels['login-new-customer'] }}</h3>
                            <h6 class="text-center mb-5">{{ @$labels['login-registra-account'] }}</h6>
                            <p>{{ @$labels['login-descrizione-registrati'] }}</p>
                            <a href="{{ url("/".env('SLUG_REGISTER')) }}" class="btn btn-primary btn-lg w-100 mt-auto">{{ @$labels['login-registrati'] }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_it.min.js"></script>

    <script>
        jQuery.validator.addMethod('emailfull', function(value, element) {
            return this.optional(element) || /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i.test(value);
        }, 'Inserisci un indirizzo email valido');

        jQuery.validator.addMethod('emailstrict', function(value, element) {
            return this.optional(element) || /^[^@]{2,}@[^@]{2,}\.[^@.]{2,}$/i.test(value);
        }, 'Inserisci un indirizzo email valido');

        $.extend( $.validator.messages, {
            nowhitespace: "Spazio bianco non ammesso",
        });

        $('#login-form').validate({
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
@endsection
