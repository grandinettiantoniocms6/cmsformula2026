<?php $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();

$session = null;
if(\Session::has('buy')){
    $session = \Session::get('buy');
}
?>
@if(count($rooms))
    <h4 class="mb-4">{{ @$labels['booking-rooms-title'] }}</h4>

    @foreach($rooms as $room)
        <?php
        $gallery = \App\Models\PluginBookingRoomImages::where("plugin_booking_room_id", $room->id)->get();
        $services = \App\Models\PluginBookingRoomServices::where("plugin_booking_room_id", $room->id)->where("is_free", 1)->get();
        ?>

        <div class="card card-room">
            <div class="row">
                <div class="col-lg-3">
                    @if(count($gallery))
                        <div class="room-gallery d-none" id="room-gallery-{{ $room->id }}">
                            <div class="owl-carousel owl-theme image-carousel flex-grow-1 mb-1" id="image-carousel-{{ $room->id }}">
                                @foreach($gallery as $image)
                                    <?php
                                    $url_image = $image->get_foto_front('large');
                                    ?>

                                    <a class="glightbox d-block" href="{{ $url_image }}">
                                        <img loading="lazy" src="{{ $url_image }}" alt="{{ $room->name }}" width="600" height="450">
                                    </a>
                                @endforeach
                            </div>
                            <div class="owl-carousel owl-theme gallery-carousel" id="gallery-carousel-{{ $room->id }}">
                                @foreach($gallery as $image)
                                    <?php
                                    $url_image = $image->get_foto_front('large');
                                    ?>

                                    <a class="d-block" href="{{ $url_image }}">
                                        <img loading="lazy" src="{{ $url_image }}" alt="{{ $room->name }}" width="240" height="180">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $room->name }}" width="360" height="420">
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="px-3 pt-4 pb-4">
                        <h2 class="room-title">{{ $room->name }}</h2>
                        {!! $room->description !!}

                        @if(count($services))
                            <div class="list-services">
                                <h6 class="text-button-color">{{ @$labels['booking-servizi-inclusi'] }}</h6>
                                <ul class="style-1 grid-columns-2">
                                    @foreach($services as $service)
                                        <?php $service_item = \App\Models\PluginBookingServices::find($service->plugin_booking_service_id);?>
                                        <li>{{ $service_item->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ps-4 ps-lg-0 pe-4 pt-lg-4 pb-4 d-flex flex-column h-100">
                       <div class="mb-4">
                           @include("Webshop.plugins.pluginBooking.inc.calculate_price")
                       </div>
                        @if($room->is_disp == 1 && $room->total_euro_rooms > 0)
                            <button class="btn btn-primary btn-lg mt-auto line-height-sm" type="button" onclick="carica_servizi({{ $room->id }}, '{{ $room->total_euro_rooms }}')">{{ @$labels['booking-rooms-seleziona'] }}</button>
                        @else
                            <div class="alert alert-danger d-flex align-items-center mt-auto line-height-sm">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>
                                    <div>{{ @$labels['booking-rooms-non-disponibile'] }}</div>
                                    <div>{!! $room->msg_disp !!}</div>
                                    <u class="text-underline fw-bold mt-1"><a href="#" data-bs-toggle="modal" data-bs-target="#changedateModal">{{ @$labels['booking-rooms-cambia-data'] }}</a></u>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(count($gallery))
            @if(property_exists($session, "out"))
                <script>
                    window.addEventListener('DOMContentLoaded', function() {
                        owlGallery( $('#image-carousel-{{ $room->id }}'), $('#gallery-carousel-{{ $room->id }}'), $('#room-gallery-{{ $room->id }}'));
                    });
                </script>
            @else
                <script>
                    owlGallery( $('#image-carousel-{{ $room->id }}'), $('#gallery-carousel-{{ $room->id }}'), $('#room-gallery-{{ $room->id }}'));

                    @if($loop->first)
                        /** gLightbox */
                        const lightbox = GLightbox({
                            selector: '.glightbox',
                            touchNavigation: true,
                            loop: true,
                            autoplayVideos: true
                        });
                    @endif
                </script>
            @endif
        @endif
    @endforeach

@else
    <div class="alert alert-danger d-flex align-items-center">
        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
        <div>
            <h5 class="mb-0">{{ @$labels['booking-rooms-non-disponibile-title'] }}</h5>
            <div>{{ @$labels['booking-rooms-non-disponibile-info'] }}</div>
            <u class="text-underline fw-bold mt-1"><a href="#" data-bs-toggle="modal" data-bs-target="#changedateModal">{{ @$labels['booking-rooms-cambia-data'] }}</a></u>
        </div>
    </div>
@endif

<!-- Modal -->
<div class="modal changedateModal fade" id="changedateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ @$labels['booking-cambia-date'] }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $lang = \App::getLocale();

                $item = new stdClass();
                $item->plugin_booking_type_id = $session->type;
                ?>
                <form class="validation" id="form_date_searchbar" method="post" action="{{ route("pluginBookingHidden.$lang") }}">
                    {{ csrf_field() }}
                    <div class="container">
                        <div class="row gx-2">
                            <?php
                            $type = \App\Models\PluginBookingType::find($item->plugin_booking_type_id);
                            $start = \Carbon\Carbon::now()->toDateString();
                            $end =  \Carbon\Carbon::now()->toDateString();
                            $letti = 1;

                            echo "<input type='hidden' name='type' value='$type->id'>";

                            //[0 => "per data singola", 1 => "per data e orario singolo", 2=> "per range di date", 3 => "per range date e orari"]
                            switch($type->type_booking){
                            case 0:
                            ?>
                            <div class="col-lg-4">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-quando'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" data-rule-min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start" required>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-lg-0">
                                    <input type="number" placeholder="{{ @$labels['booking-date-quanti'] }}" name="letti" class="form-control form-control-lg" min="1" max="10" value="" id="letti" required>
                                </div>
                            </div>
                            <?php
                            break;
                            case 1:
                            ?>
                            <div class="col-lg-3">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-quando'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start_room" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="start_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-ora'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start_time_room" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-lg-0">
                                    <input type="number" placeholder="{{ @$labels['booking-date-quanti'] }}" name="letti" class="form-control form-control-lg" min="1" max="10" value="" id="letti_room" required>
                                </div>
                            </div>
                            <?php
                            break;
                            case 2:
                            ?>
                            <div class="col-lg-2">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-in'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" data-rule-min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start-range_room" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="end" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-out'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="end-range_room" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-lg-0">
                                    <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti'] }}" name="letti" class="form-control form-control-lg" min="1" max="10" value="" id="letti_room" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-lg-0">
                                    <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti-bimbi'] }}" name="letti_bimbi" class="form-control form-control-lg" min="0" max="10" value="" id="letti_bimbi_room">
                                </div>
                            </div>
                            <?php
                            break;
                            case 3:
                            ?>
                            <div class="col-lg-2">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-in'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start-range_room" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-lg-0">
                                    <input type="text"  name="end" class="form-control form-control-lg" placeholder="{{ @$labels['booking-check-out'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="end-range_room" required>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="start_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-start'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start_time_room" required>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <div class="form-group mb-lg-0">
                                    <input type="text" name="end_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-end'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="end_time_room"  required>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group mb-lg-0">
                                    <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti'] }}" name="letti" class="form-control form-control-lg" min="1" max="10" value="" id="letti_room" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-lg-0">
                                    <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti-bimbi'] }}" name="letti_bimbi" class="form-control form-control-lg" min="0" max="10" value="" id="letti_bimbi_room">
                                </div>
                            </div>
                            <?php
                            break;
                            }
                            ?>
                            <div class="col-lg-3 mb-lg-0">
                                <button class="btn btn-primary btn-lg width-100" type="submit">{{ @$labels['booking-cerca'] }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ @$labels['booking-chiudi'] }}</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/plugins/rangePlugin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/it.min.js"></script>

<script src="{{ url("packages/jquery-validation-1.19.5/jquery.validate.min.js") }}"></script>
<script src="{{ url("packages/jquery-validation-1.19.5/additional-methods.min.js") }}"></script>
<script src="{{ url("packages/jquery-validation-1.19.5/additional-methods-custom.js") }}"></script>
<script src="{{ url("packages/jquery-validation-1.19.5/localization/messages_".\App::getLocale().".min.js") }}"></script>

<script>
    flatpickr('#start_room', {
        enableTime: false,
        dateFormat: 'd-m-Y',
        minDate: 'today',
        locale: 'it',
        disableMobile: 'true',
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#start_room").val() );
        },
    });

    flatpickr('#start_time_room', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: 'it',
        // minTime: "10:00",
        // maxTime: "22:00",
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#start_time_room").val() );
        },
    });

    flatpickr('#start-range_room', {
        enableTime: false,
        dateFormat: 'd-m-Y',
        minDate: 'today',
        disableMobile: 'true',
        locale: 'it',
        'plugins': [new rangePlugin({ input: "#end-range_room"})],
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#start-range_room").val() );
            console.log( $("#end-range_room").val() );
        },
    });

    flatpickr('#end_time_room', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        locale: 'it',
        // minTime: "10:00",
        // maxTime: "22:00",
        onChange: function(selectedDates, dateStr, instance) {
            console.log( $("#end_time_room").val() );
        },
    });
</script>
