@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" crossorigin="anonymous" />
    <link href="{{ asset('packages/summernote/dist/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div id="modal" class="modal"></div>

    <div class="card card-body">
        <div id="calendar"></div>
    </div>

    <div id="datepicker-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scegli il giorno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="la la-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="datepicker-planning"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('before_styles')
    <link rel="stylesheet" href="{{ asset('packages/fullcalendar-4.4.0/packages/core/main.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('packages/fullcalendar-4.4.0/packages/daygrid/main.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('packages/fullcalendar-4.4.0/packages/timegrid/main.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('packages/fullcalendar-4.4.0/packages-premium/timeline/main.css') }}"/>
    <link rel="stylesheet" href="{{ asset('packages/fullcalendar-4.4.0/packages-premium/resource-timeline/main.css') }}"/>

    <link rel="stylesheet" href="{{ asset('packages/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.css') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/select2/dist/js/select2.full.js') }}"></script>
    <script src="{{ asset('packages/select2/dist/js/i18n/it.js') }}"></script>


    <script src="{{ asset('packages/fullcalendar-4.4.0/packages/core/main.js') }}"></script>
    <script src="{{ asset('packages/fullcalendar-4.4.0/packages/core/locales/it.js') }}"></script>

    <script src="{{ asset('packages/fullcalendar-4.4.0/packages/interaction/main.js') }}"></script>
    <script src="{{ asset('packages/fullcalendar-4.4.0/packages/daygrid/main.js') }}"></script>
    <script src="{{ asset('packages/fullcalendar-4.4.0/packages/timegrid/main.js') }}"></script>

    <script src="{{ asset('packages/fullcalendar-4.4.0/packages-premium/timeline/main.js') }}"></script>
    <script src="{{ asset('packages/fullcalendar-4.4.0/packages-premium/resource-common/main.js') }}"></script>
    <script src="{{ asset('packages/fullcalendar-4.4.0/packages-premium/resource-daygrid/main.js') }}"></script>
    <script src="{{ asset('packages/fullcalendar-4.4.0/packages-premium/resource-timegrid/main.js') }}"></script>
    <script src="{{ asset('packages/fullcalendar-4.4.0/packages-premium/resource-timeline/main.js') }}"></script>

    <script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('packages/bootstrap-datepicker/dist/locales/bootstrap-datepicker.it.min.js') }}"></script>

    <script src="{{ asset('packages/summernote/dist/summernote-bs4.min.js') }}"></script>

    <script type="text/javascript">
        /** Fullcalendar */
        $(document).ready(function() {

            /** Date Picker **/
            $('#datepicker-planning').datepicker({
                language: "it",
                calendarWeeks: false,
                todayHighlight: true
            }).on('changeDate',function(e) {
                calendar.gotoDate( e.date );
                $('#datepicker-modal').modal('hide');
            });

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                themeSystem: 'standard',
                customButtons: {
                    calendarButton: {
                        text: 'Scegli il giorno',
                        click: function() {
                            $('#datepicker-modal').modal({
                                show: true
                            })
                        }
                    },
                },
                lang: 'it',
                locale: 'it',
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'resourceDayGrid', 'resourceTimeGrid' ],
                defaultView: 'resourceTimeGridDay', //dayGridMonth
                nowIndicator: true,
                views: {},
                defaultDate: '{{ \Carbon\Carbon::now()->toDateString() }}',
                editable: false,
                selectable: true,
                droppable : false,
                eventLimit: true,
                header: {
                    left: 'prev, next, today, calendarButton',
                    center: 'title',
                    right: 'resourceTimeGridDay, dayGrid dayGridWeek, dayGridMonth'
                },
                buttonText: {
                    today: 'Oggi',
                    month:    'Mese',
                    week:     'Settimana',
                    day:      'Dettaglio',
                    dayGrid:  'Giorno'
                },
                titleFormat: { month: 'long', year: 'numeric', day: 'numeric', weekday: 'long'},
                height: 'parent',
                aspectRatio: 1,
                slotDuration: '00:{{ $setting->planning_slot }}:00',
                minTime: '{{ $setting->planning_start }}',
                maxTime: '{{ $setting->planning_end }}',
                businessHours: {
                    daysOfWeek: [ 1,2,3,4,5 ],
                    startTime: '{{ $setting->planning_start }}',
                    endTime: '{{ $setting->planning_end }}',
                },
                allDaySlot: false,
                resourceOrder: 'order',
                resources: [
                    @if($units)
                        @foreach($units as $unit)
                            { id: '{{ $unit->id }}',
                                title: '{{ $unit->name }}',
                                eventColor: '{{ $unit->color }}',
                                order: 0
                            },
                        @endforeach
                    @endif
                ],
                eventSources: [{
                    url: '{{ route('pluginOrders.events') }}'
                }],
                eventRender: function (info) {
                    $('.tooltip').tooltip('dispose');
                    if ( info.event.extendedProps.description === ''){
                        $title = info.event.title;
                    } else {
                        $title = '' + info.event.extendedProps.status_name + '';
                    }

                    /** console.log(info.event); **/
                    $(info.el).tooltip({
                        /** title: info.event.title + ' ' +info.event.extendedProps.description,  **/
                        title: $title,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                },
                eventDrop: function(info) {
                    var id = info.event.id;
                    swal('Prenotazione', 'Non è possibile spostare questa prenotazione', 'error');
                    if(info.event.id) {
                        swal({
                            title: 'Sposta Prenotazione',
                            text: 'Sicuro di spostare questa prenotazione?',
                            icon: 'warning',
                            buttons: {
                                cancel: 'Annulla',
                                confirm: {
                                    text: 'Conferma',
                                    value: 'confirm',
                                }
                            },
                        }).then((value) => {
                            console.log(info.event);
                            switch (value) {
                                case 'confirm':
                                    var unit_id = null;
                                    if(info.newResource){
                                        unit_id = info.newResource.id;
                                    }


                                    $.post('/admin/pluginOrders/planning/drop_and_resize', {id: info.event.id, date: info.event.start, unit_id: unit_id}).done(function (d) {

                                        calendar.refetchEvents();
                                    }).fail(function () {
                                        swal('Prenotazione', 'Non è possibile spostare questa prenotazione', 'danger')
                                        info.revert();
                                    });
                                    break;
                                default:
                                    info.revert();
                                    break;
                            }
                        });
                    }else{
                        swal('Prenotazione', 'Non è possibile spostare questa prenotazione', 'error');
                        info.revert();
                    }
                },
                dateClick: function(date, jsEvent, view) {
                    @if(backpack_user()->roles[0]->id <= 3)
                    if(date.resource){
                        var resourceId = date.resource.id;
                    }else{
                        var resourceId = 0;
                    }

                    $.post('/admin/pluginOrders/planning/open_reservation_new', {dateStr: date.dateStr, resourceId: resourceId}).done(function (data) {
                        $('#modal').html(data.modal);
                        $('#modal').modal({
                            backdrop: 'static',
                            show: true
                        });
                    }).fail(function () {
                        swal('Appuntamento', 'Errore generico', 'danger')
                    });
                    @endif
                },
                eventClick: function(info) {
                    var id = info.event.id;
                    var title = info.event.title;
                    var event_type = id.split("-");
                    if(title != ''){
                        $.post('/admin/pluginOrders/planning/open_reservation', {id: info.event.extendedProps.id_res}).done(function (data) {
                            $('#modal').html(data.modal);
                            $('#modal').modal({
                                backdrop: 'static',
                                show: true
                            });
                        }).fail(function () {
                            swal('Appuntamento', 'Errore generico', 'danger')
                        });
                    }
                },
                resourceRender: function(info) {
                    $( info.el ).html( '<div><a class="d-block" href="/admin/unit/' + info.resource.id + '/edit"><i class="icon-pencil2"></i></a><span class="d-block">' + info.resource.title + '</span></div>' );
                },
            });
            calendar.render();

            /** Alla chiusura della modal aggiorna calendario */
            $('#modal').on('hidden.bs.modal', function (e) {
                calendar.refetchEvents();
            });

            /** Mobile view --> select first resource planning */
            var count_units = {{ count($units) }};
            if (($(window).width() < 768) && (count_units > 4)) {

                /** disable 1st option */
                $('#sidebar_unit option').eq(0).attr('disabled', true);

                /** get 2nd option value */
                resourceSelected = $('#sidebar_unit option').eq(1).val();
                $('#sidebar_unit').val(resourceSelected);

                calendar.refetchResources();
                var units = @php echo json_encode($units) @endphp;
                units.forEach(function (unit) {
                    if(unit.id != resourceSelected) {
                        var staff = calendar.getResourceById(unit.id);
                        staff.remove();
                    }
                });

            } else {
                $('#sidebar_unit option').eq(0).attr('disabled', false);
                $('#sidebar_unit').val(0);

                calendar.refetchResources();
            }

            $(window).resize(function(){
                if (($(window).width() < 768) && (count_units > 4)) {
                    /** disable 1st option */
                    $('#sidebar_unit option').eq(0).attr('disabled', true);

                    /** get 2nd option value */
                    resourceSelected = $('#sidebar_unit option').eq(1).val();
                    $('#sidebar_unit').val(resourceSelected);

                    calendar.refetchResources();
                    var units = @php echo json_encode($units) @endphp;
                    units.forEach(function (unit) {
                        if(unit.id != resourceSelected) {
                            var staff = calendar.getResourceById(unit.id);
                            staff.remove();
                        }
                    });
                } else {
                    $('#sidebar_unit option').eq(0).attr('disabled', false);
                    $('#sidebar_unit').val(0);

                    calendar.refetchResources();
                }
            });
            /** #### */
        });
    </script>

    <script type="text/javascript">
        function new_prenotazione(date) {
            $.post('/admin/pluginOrders/planning/open_reservation_new', {dateStr: date}).done(function (data) {
                $('#modal').html(data.modal);
                $('#modal').modal({
                    backdrop: 'static',
                    show: true
                });
            }).fail(function () {
                swal('Ordine', 'Errore generico', 'danger')
            });
        }

    </script>
@endsection

