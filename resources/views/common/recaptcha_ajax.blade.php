@if(env('RECAPTCHA_SITE_KEY') != "")
    <?php
       // $labels = \App\Models\PluginParkingLabel::get()->pluck("value", "key")->toArray();
    ?>

    <!-- v3 -->
    <script class="_iub_cs_activate" src="https://www.google.com/recaptcha/api.js?render={{config('app.recaptcha_key')}}"></script>
    <script>
        function onSubmit(token) {
            var error = 0;
            $('form#form').find('input').each(function() {
                if ($(this).prop('required')) {
                    var sType = $(this).attr('type');

                    if(sType == "checkbox"){
                        var id = $(this).attr("id");
                        if(!$('#' + id).is(":checked")){
                            error++;
                        }
                    }else{
                        if($(this).val() == ""){
                            error++;
                        }
                    }
                }
            });

            $('form#form').find('textarea').each(function() {
                if ($(this).prop('required')) {
                    if($(this).val() == ""){
                        error++;
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

                                /*$.ajax({
                                    type: 'POST',
                                    url: '{{ route('pluginBooking.checkout.it') }}',
                                    data: $("#"+id).serialize(),
                                    success: function (data) {
                                        if(data.error == 1){
                                            Swal.fire({
                                                title: "Attenzione",
                                                html: data.message,
                                                icon: "error",
                                                timer: 4000,
                                            });
                                        }else{
                                            window.location.href = data.url;
                                        }
                                    },
                                    error: function() {}
                                });*/


                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route('pluginBooking.checkout.it') }}',
                                    data: $('#form').serialize(),         // <-- usa #form
                                    headers: {
                                        'X-CSRF-TOKEN': $('input[name="_token"]').val() // per sicurezza
                                    },
                                    dataType: 'json',                      // <-- ci aspettiamo JSON
                                    success: function (data, textStatus, jqXHR) {
                                        // 1) Caso JSON esplicito
                                        if (data && typeof data === 'object') {
                                            if (data.error == 1) {
                                                Swal.fire({ title: "Attenzione", html: data.message, icon: "error", timer: 4000 });
                                                return;
                                            }
                                            if (data.url) {
                                                window.location.assign(data.url);
                                                return;
                                            }
                                        }

                                        // 2) Caso il server ha fatto redirect 302: jQuery segue e ti dà l’HTML finale.
                                        //    In quel caso usiamo l’URL finale della XHR.
                                        const finalURL = jqXHR && jqXHR.responseURL;
                                        if (finalURL) {
                                            window.location.assign(finalURL);
                                            return;
                                        }

                                        // 3) Fallback: se non abbiamo nulla, fai submit normale del form
                                        document.getElementById('form').submit();
                                    },
                                    error: function (jqXHR) {
                                        // utile per capire se è 419/422 ecc.
                                        Swal.fire({
                                            title: "Errore",
                                            text: "Invio non riuscito (" + jqXHR.status + ")",
                                            icon: "error"
                                        });
                                    }
                                });

                            },
                            error: function(response) {
                                e.preventDefault();
                            }
                        }
                    ]);
                @else
                    $("#form").submit();
                @endif
            }else{
                Swal.fire({
                    title: "Controllo / Check",
                    text: "Tutti i campi sono obbligatori / All fields are mandatory",
                    icon: "error"
                });
            }
        }
    </script>
@endif
