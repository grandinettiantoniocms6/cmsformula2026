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

                                grecaptcha.ready(function () {
                                    grecaptcha.execute('{{ config('app.recaptcha_key') }}', {action: 'submit'}).then(function (token) {
                                        const $f = $('#form');
                                        const $existing = $f.find('input[name="g-recaptcha-response"]');
                                        if ($existing.length) $existing.val(token);
                                        else $f.append('<input type="hidden" name="g-recaptcha-response" value="'+ token +'">');

                                        // poi chiama l'AJAX (il blocco sopra)
                                    });
                                });

                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route('pluginBooking.checkout.it') }}',
                                    data: $('#form').serialize(),
                                    headers: {
                                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    dataType: 'json',
                                    success: function (data, textStatus, jqXHR) {
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
                                        const finalURL = jqXHR && jqXHR.responseURL;
                                        if (finalURL) {
                                            window.location.assign(finalURL);
                                            return;
                                        }
                                        document.getElementById('form').submit();
                                    },
                                    error: function (jqXHR) {
                                        console.log('Status', jqXHR.status);
                                        console.log('Response', jqXHR.responseText);
                                        let html = 'Invio non riuscito (' + jqXHR.status + ')';
                                        if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                                            const list = Object.values(jqXHR.responseJSON.errors)
                                                .flat().map(e => `<li>${e}</li>`).join('');
                                            html = `<ul style="text-align:left">${list}</ul>`;
                                        }
                                        Swal.fire({ title: "Errori di validazione", html, icon: "error" });
                                    }
                                });

                            },
                            error: function(response) {
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
