<?php
$parking = \App\Models\BlockPluginParking::find($item->id);
$labels = \App\Models\PluginParkingLabel::get()->pluck("value", "key")->toArray();
$tariffe = \App\Models\PluginParkingPrice::with("promo")->get();
$setting  = \App\Models\PluginParkingSetting::first();
?>

<section id="block-parking-{{ $parking->id }}" class="block-formpro">
    <div class="container">

        <h3 class="title">{{ $parking->title }}</h3>
        {!! $parking->subtitle !!}

        {!! $parking->description !!}

        <div class="row gap-3 gap-lg-0">

            <div class="col-lg-12 colonna-modulo-prenotazione">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{$errors->first()}}
                    </div>
                @endif

                <form action="{{ route('plugin_parking.send_request') }}" name="form_prenota_parking" method="post" id="form" class="card border">
                    @honeypot

                    {{ csrf_field() }}

                    <div class="card-header text-center bg-primary text-white">
                        <span class="font-weight-bold font-2xl">{{ @$labels['parking-prenota-online'] }}</span>
                    </div>

                    <div class="p-4 bg-light">

                        <div class="row row-cols-2 align-items-center mb-4">
                            <strong>{{ @$labels['parking-tipologia'] }}</strong>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type_park" id="tipologia_1" value="1" checked>
                                    <label class="form-check-label fw-semibold" for="tipologia_1">{{ @$labels['parking-scoperto'] }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type_park" id="tipologia_2" value="2">
                                    <label class="form-check-label fw-semibold" for="tipologia_2">{{ @$labels['parking-coperto'] }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-giorno-ingresso'] }}</label>
                                    <input id="giorno_ingresso" type="text" name="date_start" class="form-control bg-white" placeholder="Giorno ingresso" required>
                                </div>
                            </div>

                            <div class="col-sm mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-ora-ingresso'] }}</label>
                                    <select id="ora_consegna" name="time_start" class="form-select bg-white" required>
                                        <option value="00:30">00:30</option>
                                        <option value="01:00">01:00</option>
                                        <option value="01:30">01:30</option>
                                        <option value="02:00">02:00</option>
                                        <option value="02:30">02:30</option>
                                        <option value="03:00">03:00</option>
                                        <option value="03:30">03:30</option>
                                        <option value="04:00">04:00</option>
                                        <option value="04:30">04:30</option>
                                        <option value="05:00">05:00</option>
                                        <option value="05:30">05:30</option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:30">06:30</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:30">07:30</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:30">22:30</option>
                                        <option value="23:00">23:00</option>
                                        <option value="23:30">23:30</option>
                                        <option value="00:00">00:00</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-giorno-uscita'] }}</label>
                                    <input id="giorno_uscita" type="text" name="date_end" class="form-control bg-white" placeholder="Giorno uscita" required disabled>
                                </div>
                            </div>

                            <div class="col-sm mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-ora-uscita'] }}</label>
                                    <select id="ora_ritiro" name="time_end" class="form-select bg-white" required>
                                        <option value="00:30">00:30</option>
                                        <option value="01:00">01:00</option>
                                        <option value="01:30">01:30</option>
                                        <option value="02:00">02:00</option>
                                        <option value="02:30">02:30</option>
                                        <option value="03:00">03:00</option>
                                        <option value="03:30">03:30</option>
                                        <option value="04:00">04:00</option>
                                        <option value="04:30">04:30</option>
                                        <option value="05:00">05:00</option>
                                        <option value="05:30">05:30</option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:30">06:30</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:30">07:30</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:30">22:30</option>
                                        <option value="23:00">23:00</option>
                                        <option value="23:30">23:30</option>
                                        <option value="00:00">00:00</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-nome-cognome'] }}</label>
                                    <input type="text" id="nome" name="name" placeholder="Il tuo Nome e Cognome" class="form-control bg-white" data-cons-subject="first_name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-telefono'] }}</label>
                                    <input type="text" id="telefono" name="mobile" placeholder="Indicare un solo numero di telefono" class="form-control bg-white" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="has-float-label">
                                    <label class="floated">Email</label>
                                    <input type="email" id="email" name="email" placeholder="La tua E-Mail" class="form-control bg-white" data-cons-subject="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-numero-volo'] }}</label>
                                    <input type="text" id="volo_rientro" name="number_flight" placeholder="Digita il numero del tuo volo" class="form-control bg-white">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-numero-passeggeri'] }}</label>
                                    <input type="text" id="nr_pax" name="number_partecipants" placeholder="Indica il numero di persone da trasportare" class="form-control bg-white" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="has-float-label">
                                    <label class="floated">{{ @$labels['parking-targa-veicolo'] }}</label>
                                    <input type="text" id="targa" name="targa" placeholder="Digita la targa del tuo veicolo" class="form-control bg-white" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-check">

                            @if($parking->link_iubenda)
                                    <?php
                                    $url_pagina = $parking->link_iubenda;
                                    if(is_numeric(strpos($url_pagina, "https://www.iubenda.com"))){
                                        echo "
                                    <input type='checkbox' name='privacy' value='1' class='form-check-input' id='pfc_privacy_control_1' required data-cons-preference='privacy'>
                                    <label class='form-check-label' for='pfc_privacy_control_1'>{$labels['parking-privacy']}
                                     <a href='$url_pagina' class='iubenda-nostyle no-brand iubenda-noiframe iubenda-embed iubenda-noiframe' target='_blank'>{$labels['parking-leggi']}</a>
                                     </label>
                                     <script>(function (w,d) {var loader = function () {var s = d.createElement('script'), tag = d.getElementsByTagName('script')[0]; s.src='https://cdn.iubenda.com/iubenda.js'; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener('load', loader, false);}else if(w.attachEvent){w.attachEvent('onload', loader);}else{w.onload = loader;}})(window, document);</script>";
                                    }
                                    ?>
                            @else
                                <input class="form-check-input" type="checkbox" value="" id="privacy" name="privacy" data-cons-preference="privacy" required>
                                <label class="form-check-label font-sm" for="privacy">{{ @$labels['parking-privacy'] }} &nbsp</label>
                            @endif
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="newsletter" name="newsletter" data-cons-preference="newsletter">
                            <label class="form-check-label font-sm" for="newsletter">{{ @$labels['parking-newsletter'] }}</label>
                        </div>

                        <h4 class="text-center text-primary my-4">{{ @$labels['parking-totale-prenotazione'] }}</h4>

                        <table class="table table-sm my-4">
                            <tr>
                                <th>N# giorni</th>
                                <th>Prezzo</th>
                            </tr>
                            <tr>
                                <td>
                                    <span id="n_giorni">0</span>
                                    <input type="hidden" id="number_days" name="number_days" value="0">
                                </td>
                                <td>
                                    <span id="prezzo">€&nbsp;0,00</span>
                                    <input type="hidden" id="total" name="total" value="0">
                                </td>
                            </tr>
                        </table>

                        <?php
                        $key = config('app.recaptcha_key');
                        echo "<button class='button btn btn-lg btn-primary w-100 g-recaptcha' data-sitekey='$key' data-callback='onSubmit' data-action='submit' type='submit' id='submit_button' disabled>".@$labels['parking-invia-prenotazione'] ."</button>";
                        ?>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

@push('custom_scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/plugins/rangePlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/it.min.js"></script>

    <script src="{{ url("packages/jquery-validation-1.19.5/jquery.validate.min.js") }}"></script>
    <script src="{{ url("packages/jquery-validation-1.19.5/additional-methods.min.js") }}"></script>
    <script src="{{ url("packages/jquery-validation-1.19.5/additional-methods-custom.js") }}"></script>
    <script src="{{ url("packages/jquery-validation-1.19.5/localization/messages_".\App::getLocale().".min.js") }}"></script>

    <script>

        $('input[type=radio][name=type_park]').change(function() {
            var type = this.value;
            var date_start = $('#giorno_ingresso').val();
            var date_end = $('#giorno_uscita').val();
            var token = '{{ csrf_token() }}';

            $.ajax({
                type: 'POST',
                url: '{{ route('plugin_parking.calculate_price') }}',
                data: "type="+type+"&date_start="+date_start+"&date_end="+date_end+"&_token="+token,
                dataType: 'json',
                success: function (data) {
                    if(data.error == 1){
                        Swal.fire({
                            title: "Attenzione",
                            html: data.html,
                            icon: "error",
                            timer: 4000,
                        });

                        $('#submit_button').attr("disabled", true);
                    }else{
                        if(data.item){
                            $('#number_days').val(data.days);
                            $('#n_giorni').html(data.days);

                            $('#prezzo').html(data.price_view);
                            $('#total').val(data.price);

                            $('#submit_button').attr("disabled", false);
                        }
                    }

                },
                error: function() {}
            });

        });

        flatpickr('#giorno_ingresso', {
            enableTime: false,
            dateFormat: 'd-m-Y',
            minDate: 'today',
            locale: 'it',
            disableMobile: 'true',
            onChange: function(selectedDates, dateStr, instance) {
                $('#giorno_uscita').val(null);
                $('#giorno_uscita').prop({disabled: false});
                calcPriceParking();

                flatpickr('#giorno_uscita', {
                    enableTime: false,
                    dateFormat: 'd-m-Y',
                    minDate: $('#giorno_ingresso').val(),
                    locale: 'it',
                    disableMobile: 'true',
                    onChange: function(selectedDates, dateStr, instance) {
                        calcPriceParking();
                    },
                });
            },
        });

        function calcPriceParking() {
            var date_start = $('#giorno_ingresso').val();
            var date_end = $('#giorno_uscita').val();
            var type = $('input[name="type_park"]:checked').val();
            var token = '{{ csrf_token() }}';

            if (date_end) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('plugin_parking.calculate_price') }}',
                    data: "type="+type+"&date_start="+date_start+"&date_end="+date_end+"&_token="+token,
                    dataType: 'json',
                    success: function (data) {
                        if(data.error == 1){
                            Swal.fire({
                                title: "Attenzione",
                                html: data.html,
                                icon: "error",
                                timer: 4000,
                            });

                            $('#submit_button').attr("disabled", true);
                        }else{
                            if(data.item){
                                $('#number_days').val(data.days);
                                $('#n_giorni').html(data.days);

                                $('#prezzo').html(data.price_view);
                                $('#total').val(data.price);

                                $('#submit_button').attr("disabled", false);
                            }
                        }

                    },
                    error: function() {}
                });
            }
        }

        /*flatpickr('#giorno_ingresso', {
             enableTime: false,
             dateFormat: 'd-m-Y',
             minDate: 'today',
             disableMobile: 'true',
             locale: 'it',
             'plugins': [new rangePlugin({ input: "#giorno_uscita"})],
             onChange: function(selectedDates, dateStr, instance) {
                 var date_start = $('#giorno_ingresso').val();
                 var date_end = $('#giorno_uscita').val();
                 var type = $('input[name="type_park"]:checked').val();
                 var token = '{{ csrf_token() }}';

                if (date_end) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('plugin_parking.calculate_price') }}',
                        data: "type="+type+"&date_start="+date_start+"&date_end="+date_end+"&_token="+token,
                        dataType: 'json',
                        success: function (data) {
                            if(data.item){
                                $('#number_days').val(data.days);
                                $('#n_giorni').html(data.days);

                                $('#prezzo').html(data.price_view);
                                $('#total').val(data.price);

                                $('#button-park').attr("disabled", false);
                            }
                        },
                        error: function() {}
                    });
                }
            },
        });*/




        /*  $("#giorno_uscita").change(function (){

              console.log('change');

              var date_start = $('#giorno_ingresso').val();
              var date_end = $(this).val();
              var type = $("input[name='type_park']:checked").val();
              var token = "{{ csrf_token() }}";

            $.ajax({
                type: 'POST',
                url: '{{ route('plugin_parking.calculate_price') }}',
                data: "type="+type+"&date_start="+date_start+"&date_end="+date_end+"&_token="+token,
                dataType: 'json',
                success: function (data) {
                    if(data.item){
                        $("#number_days").val(data.days);
                        $("#n_giorni").html(data.days);

                        $("#prezzo").html(data.price_view);
                        $("#total").val(data.price);

                        $("#button-park").attr("disabled", false);
                    }
                },
                error: function() {}
            });
        });*/


    </script>
@endpush
