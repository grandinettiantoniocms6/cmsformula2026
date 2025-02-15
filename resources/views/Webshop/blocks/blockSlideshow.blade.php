<?php
$agent = new \Jenssegers\Agent\Agent();
$adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>

<style>
    #block-slideshow-container-{{ $item->id }} {
        @if($item->border_color) --slideshow-block-color-border: {{ $item->border_color }}; @endif
        @if($item->thickness_border) border-width: {{ $item->thickness_border }}; @endif
    }
    @media screen and (max-width: 767px) {
        #block-slideshow-container-{{ $item->id }} {
            @if($item->thickness_border_mobile) border-width: {{ $item->thickness_border_mobile }}; @endif
        }
    }
</style>

<section class="block-slideshow style-{{ $item->style }} @if($adminPluginBooking && $item->is_search_booking == 1) searchbar-exist @endif" id="block-slideshow-container-{{ $item->id }}">
    @if($array)
        <div id="slideshow-block-{{ $item->id }}" class="owl-carousel owl-theme owl-block-slideshow"
             data-toggle='owlcarousel'
             data-margin='[0,0,0,0,0,0,0]'
             data-autowidth='[false,false,false,false,false,false,false]'
             data-autoplay='[true,5000]'
             data-loop=true
             data-responsive='[1,1,1,1,1,1,1]'
             data-dots='[true,true,true,true,true,true,true]'
             data-nav='[false,false,false,false,false,false,false]'
             @if($item->animate_in) data-animatein="{{ $item->animate_in }}" @endif @if($item->animate_out)data-animateout="{{ $item->animate_out }}" @endif
        >
            @foreach($array as $value)
                <?php
                $title = json_decode($value->title, true);
                if($title === null){
                    $title = [];
                }

                $title_background = $value->title_background;
                $slide_height = $item->slide_height;
                $abstract = json_decode($value->abstract, true);
                if($abstract === null){
                    $abstract = [];
                }

                $url_interno = json_decode($value->url_interno, true);
                if($url_interno === null){
                    $url_interno = [];
                }

                $url_esterno = json_decode($value->url, true);
                if($url_esterno === null){
                    $url_esterno = [];
                }

                $button = json_decode($value->button, true);
                if($button === null){
                    $button = [];
                }

                $type_href = $value->type_href;

                $url = "#";
                if(key_exists(\App::getLocale(), $url_interno)){
                    if(trim($url_interno[\App::getLocale()]) != ""){
                        $url = "/{$url_interno[\App::getLocale()]}";
                    }
                }
                if(key_exists(\App::getLocale(), $url_esterno)){
                    if(trim($url_esterno[\App::getLocale()]) != ""){
                        $url = $url_esterno[\App::getLocale()];
                    }
                }

                if(!key_exists(\App::getLocale(), $abstract)){
                    $abstract[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $title)){
                    $title[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $button)){
                    $button[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $url_interno)){
                    $url_interno[\App::getLocale()] = "";
                }

                if(!key_exists(\App::getLocale(), $url_esterno)){
                    $url_esterno[\App::getLocale()] = "";
                }

                $foto = null;
                if($agent->isMobile() || $agent->isTablet()){
                    if($value->foto_mobile){
                        $photo = $value->foto_mobile;
                    }else{
                        $photo = $value->foto;
                    }
                }else{
                    $photo = $value->foto;
                }

                $alt_img = '';
                if($title[\App::getLocale()]){
                    $alt_img = strip_tags($title[\App::getLocale()]);
                }elseif ($abstract[\App::getLocale()]) {
                    $alt_img = strip_tags($abstract[\App::getLocale()]);
                }

                // serve per le thumb
                if($photo){
                    $basename = basename($photo);
                    $temp = explode(".", $basename);

                    if($agent->isMobile() || $agent->isTablet()){
                        $check = "thumb/blocks_slideshows/$temp[0]-mobile.webp";
                    }else{
                        $check = "thumb/blocks_slideshows/$temp[0]-large.webp";
                    }

                    if(file_exists($check)){
                        $foto = url($check);
                    }else{
                        $foto = url($photo);
                    }
                }

                // Sfondo testo slide
                $captionbg = 'transparent';

                if($value->is_alphabg == 1){
                    switch ($value->alpha_bgtext) {
                        case 0:
                            $alpha_bg = '00';
                            break;
                        case 100:
                            $alpha_bg = '';
                            break;
                        default:
                            $alpha_bg = $value->alpha_bgtext;
                    }
                    $captionbg = $value->bgcolor.$alpha_bg;
                } ?>

                <div class="item image-wrapper bg-overlay bg-overlay-black-{{ $item->alpha }}" id="item-id-{{ $value->id }}" style="--slideshow-block-caption-padding: {{ $value->padding }}; --slideshow-block-caption-bgcolor: {{ $captionbg }}; @if($value->title_background) --slideshow-block-title-color: {{ $value->title_background }};@endif ">
                    <div class="caption alignment-{{ $value->text_align }}">
                        <div class="container-full">
                            <div class="caption-inner">
                                @if($title[\App::getLocale()])
                                    <h1 class="title">{{ $title[\App::getLocale()] }}</h1>
                                @endif
                                @if($abstract[\App::getLocale()])
                                    <div class="description">{!! $abstract[\App::getLocale()] !!}</div>
                                @endif
                                @if(trim($button[\App::getLocale()])!="")
                                    <a target="{{ $type_href }}" href="{{ $url }}" class="btn btn-primary shadow">{{ $button[\App::getLocale()] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <picture>
                        @if($agent->isMobile() || $agent->isTablet())
                            @if($value->foto_mobile)
                                <source media="(max-width:575px)" srcset="{{ $value->foto_mobile }}">
                            @endif
                        @endif
                        <img alt="{{ $alt_img }}" height="{!! $slide_height !!}" width="auto" src="{{ $foto }}" @if(!$loop->first) loading="lazy" @endif>
                    </picture>
                </div>
            @endforeach
        </div>

        <style>
            #slideshow-block-{{ $item->id }} {
                @if($item->slide_height) --slideshow-block-height: {{ $item->slide_height }}; @endif
                @media screen and (max-width: 767px) {
                    @if($item->slide_height_mobile) --slideshow-block-height: {{ $item->slide_height_mobile }}; @endif
                }
            }
            #slideshow-block-{{ $item->id }} .animated {
                -webkit-animation-duration: 1000ms;
                animation-duration: 1000ms;
            }
        </style>
    @endif

    @if($adminPluginBooking && $item->is_search_booking == 1)
        <?php $lang = \App::getLocale(); ?>
        <div class="searchbar">
            <div class="container">
                <form class="card validation" id="form_date_searchbar" method="post" action="{{ route("pluginBookingHidden.$lang") }}"
                 style="background-color: {{ $item->form_booking_bgcolor }};bottom:{{ $item->form_booking_top }}; border-radius: {{ $item->form_booking_border_radius }}; border-color: {{ $item->form_booking_border_color }}; border-style: solid; border-width: {{ $item->form_booking_border_width }};">
                    {{ csrf_field() }}
                    <div class="row gx-2">
                            <?php
                            $type = \App\Models\PluginBookingType::find($item->booking_type_id);
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
                                <input type="text" name="start" class="form-control form-control-lg" placeholder="Quando?" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group mb-lg-0">
                                <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti'] }}" name="letti" class="form-control form-control-lg" min="1" max="10" value="" id="letti" required>
                            </div>
                        </div>
                            <?php
                            break;
                        case 1:
                            ?>
                        <div class="col-lg-3">
                            <div class="form-group mb-lg-0">
                                <input type="text" name="start" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-quando'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-lg-0">
                                <input type="text" name="start_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-ora'] }}" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start_time" required>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group mb-lg-0">
                                <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti'] }}" name="letti" class="form-control form-control-lg" min="1" max="10" value="" id="letti" required>
                            </div>
                        </div>

                            <?php
                            break;
                        case 2:
                            ?>
                        <div class="col-lg-3">
                            <div class="form-group mb-lg-0">
                                <input type="text" name="start" class="form-control form-control-lg" placeholder="Check In" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start-range" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-lg-0">
                                <input type="text" name="end" class="form-control form-control-lg" placeholder="Check Out" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="end-range" required>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group mb-lg-0">
                                <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti'] }}" name="letti" class="form-control form-control-lg" min="1" value="" id="letti" required>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group mb-lg-0">
                                <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti-bimbi'] }}" name="letti_bimbi" class="form-control form-control-lg" min="0" value="" id="letti_bimbi">
                            </div>
                        </div>
                            <?php
                            break;
                        case 3:
                            ?>
                        <div class="col-lg-2">
                            <div class="form-group mb-lg-0">
                                <input type="text" name="start" class="form-control form-control-lg" placeholder="Check In" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="start-range" required>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group mb-lg-0">
                                <input type="text"  name="end" class="form-control form-control-lg" placeholder="Check Out" value="" min="{{ \Carbon\Carbon::now()->toDateString() }}" id="end-range" required>
                            </div>
                        </div>

                        <div class="col-lg-1">
                            <div class="form-group mb-lg-0">
                                <input type="text" name="start_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-start'] }}" value="" min="{{ \Carbon\Carbon::now()->toTimeString() }}" id="start_time" required>
                            </div>
                        </div>

                        <div class="col-lg-1">
                            <div class="form-group mb-lg-0">
                                <input type="text" name="end_time" class="form-control form-control-lg" placeholder="{{ @$labels['booking-date-end'] }}" value="" min="{{ \Carbon\Carbon::now()->toTimeString() }}" id="end_time"  required>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group mb-lg-0">
                                <input type="number" placeholder="{{ @$labels['booking-riassume-n-ospiti'] }}" name="letti" class="form-control form-control-lg" min="1" max="10" value="" id="letti" required>
                            </div>
                        </div>
                            <?php
                            break;
                        }
                            ?>
                        <div class="col-lg-3 mb-lg-0">
                            <button class="btn btn-primary btn-lg width-100" type="submit">{{ @$labels['booking-date-cerca-button'] }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</section>

@if($adminPluginBooking && $item->is_search_booking == 1)
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
@endif



