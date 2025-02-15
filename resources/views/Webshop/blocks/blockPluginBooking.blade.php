<?php $rooms = \App\Models\PluginBookingRoom::where("is_active",1)->get(); ?>
<section class="block-booking">
    <div class="container">
            @if(count($rooms))
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
                                                <a class="glightbox d-block" href="{{ url($image->image) }}"><img loading="lazy" src="{{ url($image->image) }}" alt="{{ $room->name }}" width="360" height="360"></a>
                                            @endforeach
                                        </div>
                                        <div class="owl-carousel owl-theme gallery-carousel" id="gallery-carousel-{{ $room->id }}">
                                            @foreach($gallery as $image)
                                                <a class="d-block" href="{{ url($image->image) }}"><img loading="lazy" src="{{ url($image->image) }}" alt="{{ $room->name }}" width="360" height="360"></a>
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
                                        @include("Webshop.plugins.pluginBooking.inc.promo")
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(count($gallery))
                        <script>
                            window.addEventListener('DOMContentLoaded', function() {
                                owlGallery( $('#image-carousel-{{ $room->id }}'), $('#gallery-carousel-{{ $room->id }}'), $('#room-gallery-{{ $room->id }}'));
                            });
                        </script>
                    @endif
                @endforeach
            @endif
    </div>
</section>

@push('custom_scripts')
<script>
    function owlGallery(owl_1, owl_2, room) {
        var flag = false;

        owl_1.on('initialized.owl.carousel', function() {
            setTimeout(function(){
                room.removeClass('d-none');
            }, 1000);
        });

        owl_1.owlCarousel({
            items: 1,
            lazyLoad: true,
            loop: false,
            margin: 0,
            nav: false,
            dots: false,
            navText: [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ],
            responsiveClass: true
        }).on('changed.owl.carousel', function(e) {
            if (!flag) {
                flag = true;
                owl_2.find('.owl-item').removeClass('current').eq(e.item.index).addClass('current');
                if ( owl_2.find('.owl-item').eq(e.item.index).hasClass('active') ) {
                } else {
                    owl_2.trigger("to.owl.carousel", [e.item.index, 300, true]);
                }
                flag = false;
            }
        });

        owl_2.on('initialized.owl.carousel', function() {
            owl_2.find('.owl-item').eq(0).addClass('current');
        }).owlCarousel({
            items: 3,
            lazyLoad: true,
            loop: false,
            margin: 5,
            navText: [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ],
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 2,
                },
                576: {
                    items: 2,
                },
                767: {
                    items: 3,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 3,
                }
            },
            responsiveClass: true
        }).on('click', '.owl-item', function(e) {
            e.preventDefault();
            var number = $(this).index();
            owl_1.trigger('to.owl.carousel', [number, 300, true]);
        });
    }
</script>

@endpush
