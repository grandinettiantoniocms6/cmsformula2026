<?php
   // $labels = \App\Models\PluginParkingLabel::get()->pluck("value", "key")->toArray();
?>

@if(env('RECAPTCHA_SITE_KEY') != "")
    @include('common.google_public_key_credential_fallback')
    <!-- v3 -->
    <script class="_iub_cs_activate" type="text/plain" src="https://www.google.com/recaptcha/api.js?render={{config('app.recaptcha_key')}}"></script>
@endif

<script>
    (function () {
        var recaptchaEnabled = @json(env('RECAPTCHA_SITE_KEY') != "");
        var submitting = false;

        window.onSubmit = function (token, event) {
            if (event && typeof event.preventDefault === 'function') {
                event.preventDefault();
            }

            var error = 0;
            $('form#form').find('input').each(function() {
                if ($(this).prop('required')) {
                    var sType = $(this).attr('type');
                    var sName = $(this).attr('name');

                    if(sType == "checkbox"){
                        var id = $(this).attr("id");
                        if(!$('#' + id).is(":checked")){
                            error++;
                            console.log('checkbox required');
                        }
                    }else{
                        if($(this).val() == ""){

                            console.log(sName+' required');

                            error++;
                        }
                    }
                }
            });

            $('form#form').find('textarea').each(function() {
                if ($(this).prop('required')) {
                    if($(this).val() == ""){
                        error++;
                        console.log('textarea required');
                    }
                }
            });

            if(error == 0){
               // $("#submit_button").attr("disabled", true);

                @if($website->consent_solution_iubenda)
                    _iub.cons_instructions.push(["submit",
                        {
                            form: {
                                selector: document.getElementById("form"),
                            },
                            consent: {
                                legal_notices: [
                                    {
                                        identifier: 'privacy_policy',
                                    },
                                    {
                                        identifier: 'cookie_policy',
                                    },
                                    {
                                        identifier: 'term',
                                    }
                                ]}
                        },
                        {
                            success: function(response) {
                                console.log("ok", response);
                                submitting = true;
                                document.getElementById("form").submit();
                            },
                            error: function(response) {
                                if (event && typeof event.preventDefault === 'function') {
                                    event.preventDefault();
                                }
                            }
                        }
                    ]);
                @else
                    submitting = true;
                    document.getElementById("form").submit();
                @endif
            }else{
                Swal.fire({
                    title: "Controllo / Check",
                    text: "Tutti i campi sono obbligatori / All fields are mandatory",
                    icon: "error"
                });
            }
        };

        if (!recaptchaEnabled) {
            $(document).on('submit', 'form#form', function (event) {
                if (submitting) {
                    return true;
                }

                window.onSubmit(null, event);
                return false;
            });

            $(document).on('click', '#submit_button', function (event) {
                if ($(this).attr('type') === 'button') {
                    window.onSubmit(null, event);
                }
            });
        }
    })();
</script>
