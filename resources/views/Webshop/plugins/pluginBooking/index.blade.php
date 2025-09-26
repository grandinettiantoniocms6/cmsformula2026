<?php
$thema = env('TEMA');
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
$types = \App\Models\PluginBookingType::where("is_visible", 1)->orderBy("lft", "asc")->get();

$session = null;
if(\Session::has('buy')){
    $session = \Session::get('buy');

   /* if(!property_exists($session, "html")){
        header('Location: /');
        exit;
    }*/
}
?>

@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")
@endsection

@section('recaptcha')
    @include('common.recaptcha')
@endsection

@section('meta')
    @include("$thema.inc.meta")
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @include("$thema.inc.topbar")
    @endsection

    @section('topbar_ecommerce')
        @include("$thema.inc.topbar_ecommerce")
    @endsection

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content')
        <section class="page-title-block image-wrapper bg-overlay bg-overlay-black-60 jarallax block-parallax py-5" @if($plugin->image_height) style="--page-title-height: {{ $plugin->image_height }}px;" @endif>
            @if($plugin->image)
                <img class="jarallax-img" src="{{ url($plugin->image) }}" alt="{{ $plugin->title }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto">
            @endif
            <div class="container-fluid container-2xl">
                <h1 class="page-title">{{ $plugin->title }}</h1>
                <div  class="page-subtitle">{{ $plugin->subtitle }}</div>
            </div>
        </section>

        <section class="page-shop">
           @if ($errors->any())
                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <div><strong>{{ $error }}</strong></div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-success text-center shadow-sm mb-4 alert-fixed-bottom-xs">
                    <div class="font-3xl"><i class="bi bi-check"></i></div>
                    <h5>{{ session()->get('message') }}</h5>
                </div>
            @endif

            @if(session()->has('noUser'))
                <div class="alert alert-danger text-center shadow-sm mb-4 alert-dismissible fade show" role="alert">
                    <div class="font-3xl"><i class="far fa-exclamation-triangle"></i></div>
                    <div><strong class="font-xl">{{ session()->get('noUser') }}</strong></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

             <div class="container-fluid container-2xl">
                <!--<a href="{{ route("pluginBooking.it") }}?r" class="btn btn-sm btn-danger pull-right">Resetta Sessione</a>

                <br> -->

                <nav class="dot-steps mb-5" id="dot-steps">

                    @if(!$session)
                        <button class="dot-step" data-target="#box_struttura" onclick="change_step('#box_struttura', '.collapse-booking')" type="button" disabled><span data-namestep="{{ @$labels['booking-home-step-strutture'] }}"></span></button>
                        <button class="dot-step" data-target="#box_date" onclick="change_step('#box_date', '.collapse-booking')" type="button" disabled><span data-namestep="{{ @$labels['booking-home-step-date'] }}"></span></button>
                    @endif

                    <button class="dot-step" id="step_camere" data-target="#box_camere" onclick="change_step('#box_camere', '.collapse-booking')" type="button" disabled><span data-namestep="{{ @$labels['booking-home-step-disponibilita'] }}"></span></button>

                    <button class="dot-step" id="step_servizi" data-target="#box_servizi" onclick="change_step('#box_servizi', '.collapse-booking')" type="button" disabled><span data-namestep="{{ @$labels['booking-home-step-servizi'] }}"></span></button>

                    @if($session)
                         <?php
                         $type_ = \App\Models\PluginBookingType::find($session->type);
                         ?>

                         @if($type_->is_checkin == 1)
                             <button class="dot-step" id="step_partecipanti" data-target="#box_partecipanti" onclick="change_step('#box_partecipanti', '.collapse-booking')" type="button" disabled><span data-namestep="{{ @$labels['booking-home-step-ospiti'] }}"></span></button>
                         @endif
                    @else
                         <button class="dot-step" id="step_partecipanti" data-target="#box_partecipanti" onclick="change_step('#box_partecipanti', '.collapse-booking')" type="button" disabled><span data-namestep="{{ @$labels['booking-home-step-ospiti'] }}"></span></button>
                    @endif

                    <button class="dot-step" id="step_servizi_2" data-target="#box_servizi_2" onclick="change_step('#box_servizi_2', '.collapse-booking')" type="button" disabled><span data-namestep="{{ @$labels['booking-home-step-offerte'] }}"></span></button>

                    <button class="dot-step" disabled><span data-namestep="{{ @$labels['booking-home-step-checkout'] }}"></span></button>
                </nav>

                <div class="accordion" id="accordion-booking">

                    <div id="box_struttura" class="collapse collapse-booking @if(!$session) show @endif" data-parent="#accordion-booking">

                        <h4 class="mb-4">{{ @$labels['booking-home-title'] }}</h4>

                        <form id="form_type" class="validation">
                            @if(count($types))
                                @foreach($types as $type)
                                    <div class="card card-service">
                                            <input class="form-check-input" type="radio" name="type_id" value="{{ $type->id }}" id="type_{{ $type->id }}">
                                            <label class="form-check-label pointer" for="type_{{ $type->id }}">
                                                <div class="row gx-0 gx-lg-3">
                                                    <div class="col-xl-2 col-lg-3 col-4">
                                                        <div class="service-gallery">
                                                            @if($type->image)
                                                                <img loading="lazy" class="img-fluid mx-auto" src="{{ url($type->image) }}" alt="{{ $type->name }}" width="360" height="420">
                                                            @else
                                                                <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $type->name }}" width="360" height="420">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card-body">
                                                            <h4 class="title">{{ $type->title }}</h4>
                                                            <div class="description">{!! $type->description !!}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="card-body d-flex flex-column align-items-center justify-content-center h-100">
                                                            <span class="btn btn-primary w-100">{{ @$labels['booking-home-seleziona'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                    </div>
                                @endforeach
                            @endif

                            <div class="mt-4">
                                <button class="btn btn-primary btn-lg width-lg-auto width-100" type="button" onclick="scelta_struttura()">{{ @$labels['booking-continua'] }}</button>
                            </div>
                        </form>
                    </div>

                    <div id="box_date" class="collapse collapse-booking" data-parent="#accordion-booking"></div>

                    <div id="box_camere" class="collapse collapse-booking @if($session) show @endif" data-parent="#accordion-booking">
                        @if($session)
                            @if(property_exists($session, "html"))
                                @if($session->html === false)
                                    <div class="alert alert-warning">
                                        <h5 style="text-align: center;"><a href="/"> {{ @$labels['booking-home-sessione-scaduta'] }} </a></h5>
                                    </div>
                                @else
                                    {!! $session->html !!}
                                @endif
                            @else
                                <div class="alert alert-warning">
                                    <h5 style="text-align: center;"><a href="/"> {{ @$labels['booking-home-sessione-scaduta'] }} </a></h5>
                                </div>
                            @endif
                        @endif

                    </div>

                    <div id="box_servizi" class="collapse collapse-booking" data-parent="#accordion-booking"></div>

                    <div id="box_partecipanti" class="collapse collapse-booking" data-parent="#accordion-booking"></div>

                    <div id="box_servizi_2" class="collapse collapse-booking" data-parent="#accordion-booking"></div>

                    <div id="box_checkout" class="collapse collapse-booking" data-parent="#accordion-booking"></div>

                </div>

            </div>
        </section>
    @endsection

    @section('content_footer')
        <?php $page = \App\Models\Page::where("is_homepage", 1)->where("is_active", 1)->first(); ?>
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif

@section('after_scripts')
    <script src="{{ url("packages/jquery-validation-1.19.5/jquery.validate.min.js") }}"></script>
    <script src="{{ url("packages/jquery-validation-1.19.5/additional-methods.min.js") }}"></script>
    <script src="{{ url("packages/jquery-validation-1.19.5/additional-methods-custom.js") }}"></script>

    <script src="{{ url("packages/jquery-validation-1.19.5/localization/messages_".\App::getLocale().".min.js") }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/plugins/rangePlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/it.min.js"></script>

    <script>
        <?php if(\request()->has('type_id')){ ?>
              change_step('#box_date', '#box_struttura');
              change_step('#box_camere', '#box_date');
              scelta_struttura_special({{ \request()->get('type_id') }});
              carica_camere_special();
         <?php } ?>

        function return_date(){
            <?php $lang = \App::getLocale(); ?>
            window.location.href = "{{ route("pluginBooking.$lang") }}";
        }

        function box_invoice(){
            $("#box_invoice").removeClass("d-none");
        }

        function change_step(next_step, prev_step){
            $('[data-parent="#accordion-booking"]').removeClass('show');
            $(next_step).addClass('show');
            $( 'button[data-target="'+ prev_step +'"]' ).prop('disabled', false);
            $( 'button[data-target="'+ next_step +'"]' ).prop('disabled', true);

            scrollTop();
        }

        function scelta_struttura_special(type){
            var value = type;
            if (value == null){
                Swal.fire({
                    title: "Attenzione",
                    html: "Selezionare una tipologia",
                    icon: "error",
                    timer: 4000,
                });
                return;
            }else{
                var token = '{{ csrf_token() }}';

                $.ajax({
                    type: 'POST',
                    url: '{{ route('pluginBooking.choose_type.it') }}',
                    data: 'type='+value+'&_token=' + token,
                    success: function (data) {
                        if(data.step_partecipanti == 0){
                            $("#step_partecipanti").addClass('d-none');
                        }else{
                            $("#step_partecipanti").removeClass('d-none');
                        }
                        $('#box_date').html(data.html);
                    },
                    error: function() {}
                });
            }
        }

        function scelta_struttura(){

            var value = $('input[name=type_id]:checked').val();
            if (value == null){
                Swal.fire({
                    title: "Attenzione",
                    html: "Selezionare una tipologia",
                    icon: "error",
                    timer: 4000,
                });
                return;
            }else{
                var token = '{{ csrf_token() }}';

                $.ajax({
                    type: 'POST',
                    url: '{{ route('pluginBooking.choose_type.it') }}',
                    data: 'type='+value+'&_token=' + token,
                    success: function (data) {
                        if(data.step_partecipanti == 0){
                            $("#step_partecipanti").addClass('d-none');
                        }else{
                            $("#step_partecipanti").removeClass('d-none');
                        }
                        change_step('#box_date', '#box_struttura');

                        $('#box_date').html(data.html);
                    },
                    error: function() {}
                });
            }
        }

        function carica_camere_special(){
            var start = "{{ \request()->get('start') }}";
            var end = "{{ \request()->get('end') }}";
            var start_time = "{{ \request()->get('start_time') }}";
            var end_time = "{{ \request()->get('end_time') }}";

            var letti = "{{ \request()->get('letti') }}";
            var letti_bimbi = "{{ \request()->get('letti_bimbi') }}";
            var type = "{{ \request()->get('type_id') }}";

            var token = '{{ csrf_token() }}';

            $.ajax({
                type: 'POST',
                url: '{{ route('pluginBooking.get_rooms.it') }}',
                data: 'type='+type+'&start='+start+'&end='+end+'&start_time='+start_time+'&end_time='+end_time+'&letti='+letti+'&letti_bimbi='+letti_bimbi+'&_token=' + token,
                success: function (data) {
                    $('#box_camere').html(data.html);
                    change_step('#box_camere', '#box_date');
                    lightbox.reload();
                },
                error: function() {}
            });
        }

        function carica_camere(){
            if($("#start").length){
                var start = $("#start").val();
            }else{
                if($("#start-range").length){
                    var start = $("#start-range").val();
                }
            }

            if($("#end").length){
                var end = $("#end").val();
            }else{
                if($("#end-range").length){
                    var end = $("#end-range").val();
                }
            }

            var start_time = $("#start_time").val();
            var end_time = $("#end_time").val();

            var letti = $("#letti").val();
            var letti_bimbi = $("#letti_bimbi").val();
            var type = $("#type").val();

            var token = '{{ csrf_token() }}';

            if ($('#form_date').valid()) {
                $.ajax({
                    async: false,
                    type: 'POST',
                    url: '{{ route('pluginBooking.get_rooms.it') }}',
                    data: 'type='+type+'&start='+start+'&end='+end+'&start_time='+start_time+'&end_time='+end_time+'&letti='+letti+'&letti_bimbi='+letti_bimbi+'&_token=' + token,
                    success: function (data) {
                        $('#box_camere').html(data.html);
                        change_step('#box_camere', '#box_date');
                        lightbox.reload();
                    },
                    error: function() {}
                });
            }
        }

        function carica_servizi(id, price){
            var token = '{{ csrf_token() }}';
            $.ajax({
                type: 'POST',
                url: '{{ route('pluginBooking.get_services.it') }}',
                data: 'price='+price+'&id='+id+'&_token=' + token,
                success: function (data) {
                    if(data.list > 0){
                        $('#box_servizi').html(data.html);
                        change_step('#box_servizi', '#box_camere');
                    }else{
                        if(data.step_partecipanti > 0){
                            var token = '{{ csrf_token() }}';
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('pluginBooking.set_partecipants.it') }}',
                                data: "_token="+token,
                                success: function (data) {
                                    $('#box_partecipanti').html(data.html);
                                    if(data.step_partecipanti == 0){
                                        carica_servizi_2();
                                        change_step('#box_servizi_2','#box_servizi');
                                    }else{
                                        $('#step_servizi').hide();
                                        change_step('#box_partecipanti','#box_servizi');
                                    }
                                },
                                error: function() {}
                            });
                        }else{
                            change_step('#box_servizi', '#box_camere');
                            var token = '{{ csrf_token() }}';
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('pluginBooking.get_services_2.it') }}',
                                data: "_token="+token,
                                success: function (data) {
                                    if(data.list > 0){
                                        $('#box_servizi_2').html(data.html);
                                        change_step('#box_servizi_2', '#box_servizi');
                                    }else{
                                        change_step('#box_servizi_2', '#box_servizi');
                                        var token = '{{ csrf_token() }}';
                                        $.ajax({
                                            type: 'POST',
                                            url: '{{ route('pluginBooking.get_checkout.it') }}',
                                            data: "_token="+token,
                                            success: function (data) {
                                                $('#box_checkout').html(data.html);
                                                change_step('#box_checkout','#box_servizi_2');
                                            },
                                            error: function() {}
                                        });
                                    }

                                },
                                error: function() {}
                            });
                        }
                    }
                },
                error: function() {}
            });
        }

        function carica_servizi_2(){
            $.ajax({
                type: 'POST',
                url: '{{ route('pluginBooking.get_services_2.it') }}',
                data: $("#form_partecipanti").serialize(),
                success: function (data) {

                    if ($('#form_partecipanti').valid()) {

                        $('#box_servizi_2').html(data.html);
                        change_step('#box_servizi_2','#box_partecipanti');
                    }

                },
                error: function() {}
            });
        }

        function carica_partecipanti(){
            $.ajax({
                type: 'POST',
                url: '{{ route('pluginBooking.set_partecipants.it') }}',
                data: $('#form_servizi').serialize(),
                success: function (data) {
                    $('#box_partecipanti').html(data.html);
                    if(data.step_partecipanti == 0){
                        carica_servizi_2();
                        change_step('#box_servizi_2','#box_servizi');
                    }else{
                        change_step('#box_partecipanti','#box_servizi');
                    }
                },
                error: function() {}
            });
        }

        function carica_checkout(){
            $.ajax({
                type: 'POST',
                url: '{{ route('pluginBooking.get_checkout.it') }}',
                data: $("#form_servizi_2").serialize(),
                success: function (data) {
                    $('#box_checkout').html(data.html);
                    change_step('#box_checkout','#box_servizi_2');

                    startIubendaBadge();
                },
                error: function() {}
            });
        }

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

        function seleziona_servizio(id){
            console.log(id);
            console.log($('#service_qty_'+id).val());
            if ($('#service_qty_'+id).val() > 0) {
                $('#service_'+id).prop('checked', true);
            } else {
                $('#service_'+id).prop('checked', false);
            }
        }

        function validate_form(id){
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

            if ($("#"+id).valid()) {

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

            }
        }

        function recovery_psw(){
            var email = $("#email_recovery").val();

            var token = '{{ csrf_token() }}';

            $.ajax({
                type: 'POST',
                url: '{{ route('index.recoveryProcess') }}',
                data: 'ajax=1&email='+email+'&_token=' + token,
                success: function (data) {
                    if(data.error == 1){
                        Swal.fire({
                            title: "Attenzione",
                            html: data.message,
                            icon: "error",
                            timer: 4000,
                        });
                    }else{
                        Swal.fire({
                            title: "Recupera password",
                            html: data.message,
                            icon: "success"
                        });
                    }
                },
                error: function() {}
            });
        }

        $(document.body).on('click', 'button[type="submit"]', function(){
            var id = $(this).data('form-id');
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

        function increaseValueB(el) {
            var currentVal = parseInt( jQuery(el).val() );

            if ( jQuery(el).attr("max") ) {
                var maxVal = parseInt( jQuery(el).attr("max") );
                if(currentVal < maxVal){
                    if (!isNaN(currentVal)) {
                        jQuery(el).val(currentVal + 1);
                    } else {
                        jQuery(el).val(0);
                    }
                }
            } else {
                if (!isNaN(currentVal)) {
                    jQuery(el).val(currentVal + 1);
                } else {
                    jQuery(el).val(0);
                }
            }
            jQuery(el).change();
        }

        function decreaseValueB(el) {
            var currentVal = parseInt( jQuery(el).val() );

            if ( jQuery(el).attr("min") ) {
                var minVal = parseInt( jQuery(el).attr('min') );
                if(currentVal > minVal){
                    if (!isNaN(currentVal)) {
                        jQuery(el).val(currentVal - 1);
                    } else {
                        jQuery(el).val(0);
                    }
                }
            } else {
                if (!isNaN(currentVal) && currentVal > 0) {
                    jQuery(el).val(currentVal - 1);
                } else {
                    jQuery(el).val(0);
                }
            }
            jQuery(el).change();
        }

        function startIubendaBadge() {
            var loadIubendaBadge = function() {
                var s = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                s.src = "https://cdn.iubenda.com/iubenda.js";
                tag.parentNode.insertBefore(s, tag);
            };

            @if(trim($website->iubenda_client_id) != "")
                var aLink = $('<a href="https://www.iubenda.com/privacy-policy/{{ $website->iubenda_client_id }}" class="iubenda-white no-brand iubenda-noiframe iubenda-embed iubenda-noiframe" title="Privacy Policy">Privacy Policy</a>');
            @else
                var aLink = $('');
            @endif

            $('#iubenda-badge').append(aLink);
            loadIubendaBadge();
        }

        flatpickr('#start', {
            enableTime: false,
            dateFormat: 'd-m-Y',
            minDate: 'today',
            disableMobile: 'true',
            locale: 'it',
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
@endsection
