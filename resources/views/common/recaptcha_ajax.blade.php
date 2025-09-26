@if(env('RECAPTCHA_SITE_KEY') != "")
    <?php
       // $labels = \App\Models\PluginParkingLabel::get()->pluck("value", "key")->toArray();
    ?>

    <!-- v3 -->
    <script class="_iub_cs_activate" type="text/plain" src="https://www.google.com/recaptcha/api.js?render={{config('app.recaptcha_key')}}"></script>
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

            alert(error);

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
                                alert("test");

                                console.log("ok", response);

                                $.ajax({
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
