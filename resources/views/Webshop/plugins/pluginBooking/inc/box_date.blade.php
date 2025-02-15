<?php $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray(); ?>
<h4 class="mb-4">{{ @$labels['booking-date-title'] }}</h4>

<form id="form_date" class="validation" type="post">
    <input type="hidden" name="type" id="type" value="{{ $type->id }}">
    <?php
    //[0 => "per data singola", 1 => "per data e orario singolo", 2=> "per range di date", 3 => "per range date e orari"]
    switch($type->type_booking){
        case 0:
            ?>
                <div class="form-group">
                    <label class="form-label">{{ @$labels['booking-date-quando'] }}</label>
                    <input type="text" name="start" class="form-control form-control-lg" value="{{ $start }}" id="start" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ @$labels['booking-date-quanti'] }}</label>
                    <input type="number" name="letti" class="form-control form-control-lg" min="1" max="10" value="{{ $letti }}" id="letti" required>
                </div>
            <?php
            break;
        case 1:
        ?>
        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-date-quando'] }}</label>
            <input type="text" name="start" class="form-control form-control-lg" value="{{ $start }}" id="start" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-date-ora'] }}</label>
            <input type="time" name="start_time" class="form-control form-control-lg" id="start_time" value="" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-date-quanti'] }}</label>
            <input type="number" name="letti" class="form-control form-control-lg" min="1" max="10" value="{{ $letti }}" id="letti" required>
        </div>
        <?php
        break;
        case 2:
        ?>
        <div class="row gx-2">
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">{{ @$labels['booking-check-in'] }}</label>
                    <input type="text" name="start" class="form-control form-control-lg" value="{{ $start }}" id="start-range" required>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">{{ @$labels['booking-check-out'] }}</label>
                    <input type="text" name="end" class="form-control form-control-lg" value="{{ $end }}" id="end-range" required>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-label">{{ @$labels['booking-ospiti'] }}</label>
                    <input type="number" name="letti" class="form-control form-control-lg" min="1" max="10" value="{{ $letti }}" id="letti" required>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">{{ @$labels['booking-riassume-n-bimbi'] }}</label>
                    <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti-bimbi'] }}" name="letti_bimbi" class="form-control form-control-lg" min="0" max="10" value="" id="letti_bimbi">
                </div>
            </div>

            <div class="col-lg-3">

            </div>


        </div>

        <?php
            break;
            case 3:
        ?>
        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-check-in'] }}</label>
            <input type="text" name="start" class="form-control form-control-lg" value="{{ $start }}" id="start-range" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-check-out'] }}</label>
            <input type="text" name="end" class="form-control form-control-lg" value="{{ $end }}" min="{{ $end }}" id="end-range" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-date-dalle'] }}</label>
            <input type="time" name="start_time" class="form-control form-control-lg" id="start_time" value="" required>
        </div>

        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-date-alle'] }}</label>
            <input type="time" name="end_time" class="form-control form-control-lg" id="end_time" value="" required>
        </div>
        <div class="form-group">
            <label class="form-label">{{ @$labels['booking-date-quanti'] }}</label>
            <input type="number" name="letti" class="form-control form-control-lg" min="1" max="10" value="{{ $letti }}" id="letti" required>
        </div>

        <?php
            break;
    }
    ?>

    <div class="mt-4">
        <input type="hidden" name="type" id="type" value="1">
        <button class="btn btn-primary btn-lg width-lg-auto width-100" type="button" onclick="carica_camere()">{{ @$labels['booking-date-cerca-button'] }}</button>
    </div>
</form>

<script>
    $('#form_date').validate({
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            error.addClass( "invalid-feedback" );

            switch (element.attr("name")) {
                case 'accept':
                    element.closest('.form-group').append( error );
                    break;
                default:
                    error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
    });
</script>

<script>
    flatpickr('#start', {
        enableTime: false,
        dateFormat: 'd-m-Y',
        minDate: 'today',
        locale: 'it',
        disableMobile: 'true',
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#start").val() );
        },
    });

    flatpickr('#start_time', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: 'it',
        // minTime: "10:00",
        // maxTime: "22:00",
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#start_time").val() );
        },
    });

    flatpickr('#start-range', {
        enableTime: false,
        dateFormat: 'd-m-Y',
        minDate: 'today',
        disableMobile: 'true',
        locale: 'it',
        'plugins': [new rangePlugin({ input: "#end-range"})],
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#start-range").val() );
            console.log( $("#end-range").val() );
        },
    });

    flatpickr('#end_time', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: 'it',
        // minTime: "10:00",
        // maxTime: "22:00",
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#end_time").val() );
        },
    });
</script>
