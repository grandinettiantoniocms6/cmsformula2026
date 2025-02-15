@include("Webshop.blocks.blockPluginBookingSearchType.section_$item->style")

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

        $('form.validation').each(function(){
            var id = $(this).attr('id');
            $('#'+id).validate({
                errorElement: "em",
                errorPlacement: function ( error, element ) {
                    error.addClass( "invalid-feedback" );

                    switch (element.attr('type')) {
                        case 'accept':
                            element.closest('.form-group').append( error );
                            break;
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
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
                },
            });
        });
    </script>
@endpush


