<?php
$thema = env('TEMA');
$adminPlugin = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_ID') }}&currency=EUR"></script>
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
    <section class="page-title-block image-wrapper bg-overlay bg-overlay-black-60 jarallax block-parallax py-5">
        @if($plugin->image)
            <img class="jarallax-img" src="{{ url($plugin->image) }}" alt="{{ $plugin->title }}" @if($plugin->image_height) height="{{ $plugin->image_height }}" @endif width="auto">
        @endif
        <div class="container-fluid container-2xl">
            <h1 class="page-title">{{ $plugin->title }}</h1>
            <div  class="page-subtitle">{{ $plugin->subtitle }}</div>
        </div>
    </section>

    <section class="py-4">
        <div class="container-fluid container-2xl">

            <div class="row">
                <div class="col-12 col-lg-7 col-xl-8">

                    <div id="error_payment"></div>

                    @if($reservation->plugin_booking_payment_id && $reservation->is_payed == 1)
                        <div class="alert alert-info text-center">
                            <div class="display-4 mb-3"><i class="bi bi-info-circle"></i></div>
                            <h5>{{ @$labels['booking-dettaglio-prenotazione-success'] }}</h5>
                            <p>{{ @$labels['booking-dettaglio-prenotazione-effettuato'] }} {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $reservation->payment_date)->format("d/m/Y H:i") }}</p>
                            {{ @$labels['booking-dettaglio-caricato-doc'] }}

                            <br><a href="{{ route('reservation.detail') }}?reservation_id={{ $reservation->id }}" class="btn btn-primary w-100">{{ @$labels['booking-dettaglio-prenotazione'] }}</a>
                        </div>
                    @else
                        <?php
                        $payment = \App\Models\PluginBookingPayments::where("id", $reservation->plugin_booking_payment_id)->first();
                        $type = \App\Models\PluginBookingType::where("id", $reservation->type_id)->first();
                        ?>
                        @if($payment)
                            @if($payment->is_paypal == 1)
                                <div class="alert text-center">
                                    <div class="display-4 mb-3"><i class="bi bi-info-circle"></i></div>
                                    <?php
                                    $room = \App\Models\PluginBookingRoom::find($reservation->plugin_booking_room_id);
                                    if($room){
                                        $type = \App\Models\PluginBookingType::find($room->plugin_booking_type_id);
                                        if($type){
                                            echo $type->description_post_register;
                                        }
                                    }
                                    ?>


                                    <h4>{{ @$labels['booking-order-result-pay-to-paypal'] }}</h4>

                                    @if(trim($payment->description) != "")
                                        <div>{!! $payment->description !!}
                                        </div>
                                    @endif

                                    <div id="paypal-button-container" class="w-100 text-center mx-auto"></div>

                                </div>

                            @else
                                <div class="alert alert-info text-center">
                                    <div class="display-4 mb-3"><i class="bi bi-info-circle"></i></div>
                                    <?php
                                    $room = \App\Models\PluginBookingRoom::find($reservation->plugin_booking_room_id);
                                    if($room){
                                        $type = \App\Models\PluginBookingType::find($room->plugin_booking_type_id);
                                        if($type){
                                            echo $type->description_post_register;
                                        }
                                    }
                                    ?>

                                    <h4 class="mb-4">{{ @$labels['order-result-pay-to-bonifico'] }}</h4>

                                    @if(trim($payment->description) != "")
                                    <div>{!! $payment->description !!}</div>
                                    @endif

                                </div>

                                <?php $paymentPaypal = \App\Models\PluginBookingPayments::where("is_paypal", 1)->where("is_active", 1)->first(); ?>

                                @if($paymentPaypal)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="text-center mb-0">{{ @$labels['booking-order-result-cambio-tipo-pagamento'] }}</h5>
                                        <h4 class="text-center mb-4">{{ @$labels['booking-order-result-scelgo-paypal'] }}</h4>

                                        <div id="paypal-button-container" class="w-100 text-center mx-auto"></div>
                                    </div>
                                </div>
                                @endif
                            @endif
                        @else
                            <div class="alert alert-info text-center">
                                <div class="display-4 mb-3"><i class="bi bi-info-circle"></i></div>
                                <?php
                                $room = \App\Models\PluginBookingRoom::find($reservation->plugin_booking_room_id);
                                if($room){
                                    $type = \App\Models\PluginBookingType::find($room->plugin_booking_type_id);
                                    if($type){
                                        echo $type->description_post_register;
                                    }
                                }
                                ?>
                            </div>
                        @endif
                    @endif


                </div>

                <aside class="col-12 col-lg-5 col-xl-4">

                    <h4 class="mb-4">{{ @$labels['booking-riassume-title'] }}</h4>

                    <?php
                    $type = \App\Models\PluginBookingType::find($reservation->type_id);
                    ?>

                    <table class="table table-sm font-sm">
                        <tbody>
                        <tr>
                            <th>{{ @$labels['booking-riassume-dal'] }}</th>
                            <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_start)->format("d/m/Y") }}
                                @if($reservation->start_time)
                                    ore {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->start_time)->format("H:i") }}

                                @endif
                            </td>
                        </tr>
                        @if($reservation->date_end)
                            <tr>
                                <th>{{ @$labels['booking-riassume-al'] }}</th>
                                <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_end)->format("d/m/Y") }}
                                    @if($reservation->end_time)
                                        ore {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->end_time)->format("H:i") }}
                                    @endif
                                </td>
                            </tr>
                            @if($reservation->date_end && $reservation->date_start)
                            <tr>
                                <th>{{ @$labels['booking-riassume-n-notti'] }}</th>
                                <td>
                                    <?php
                                    $diff = \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_start)->diffInDays(\Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_end));
                                    if($diff == 0){
                                        $diff = 1;
                                    }
                                    echo $diff;
                                    ?>
                                </td>
                            </tr>
                            @endif
                        @endif
                        <tr>
                            <th>{{ $type->label_checkout }}</th>
                            <td>
                                <?php
                                $reservation_room = \App\Models\PluginBookingReservationRoom::where("plugin_booking_reservation_id", $reservation->id)
                                    ->first();
                                $room = \App\Models\PluginBookingRoom::find($reservation_room->plugin_booking_room_id); ?>
                                @if($room)
                                {{ $room->name }}
                                <?php
                                $price = number_format($reservation_room->price,2,",",".");
                                ?>
                                <!-- &euro; {{ $price }} -->
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ @$labels['booking-riassume-n-ospiti'] }}</th>
                            <td>
                                @if($type->is_checkin)
                                    <?php
                                    $reservation_partecipants = \App\Models\PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $reservation_room->id)
                                        ->get();
                                    ?>
                                    @if($reservation_partecipants)
                                        <ul class="style-1">
                                            @foreach($reservation_partecipants as $partecipant)
                                                <li>{{ $partecipant->first_name }} {{ $partecipant->last_name }} {{ @$labels['booking-riassume-nato-il'] }}
                                                    @if($partecipant->birthdate)
                                                       {{ \Carbon\Carbon::createFromFormat("Y-m-d", $partecipant->birthdate)->format("d/m/Y") }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @else
                                    {{ $reservation->total_qty }}
                                @endif
                            </td>
                        </tr>
                        <?php
                        $reservation_services = \App\Models\PluginBookingReservationService::where("plugin_booking_reservation_id", $reservation->id)->get();
                        ?>

                        @if(count($reservation_services))
                            <tr>
                                <th>{{ @$labels['booking-riassume-servizi'] }}</th>
                                <td>
                                    <ul class="style-1">
                                        @foreach($reservation_services as $servizio)
                                            <?php
                                            $label = $labels['booking-riassume-giorno'];
                                            if($servizio->days > 1){
                                                $tot_serv = ($servizio->price * $servizio->days);
                                                $tot_serv = number_format($tot_serv,2,",", ".");
                                                $label = $labels['booking-riassume-giorni'];

                                                $label_price = "x $servizio->days $label = € $tot_serv";
                                            }else{
                                                $label_price = "";
                                            }
                                            ?>
                                            <li>{{ $servizio->name }} (&euro; {!! number_format($servizio->price,2,",", ".") !!}) {{ $label_price }} </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                        @if($reservation->total > 0)
                        <tfoot>
                        <th>{{ @$labels['booking-riassume-totale'] }}</th>
                        <td>&euro; {{ number_format($reservation->total,2,",",".") }}

                            @if($reservation->total_acconto)
                                <br> {{ @$labels['booking-riassume-acconto'] }}
                                di &euro; {{ number_format($reservation->total_acconto,2,",",".") }}
                            @endif
                        </td>
                        </tfoot>
                        @endif
                    </table>
                    <br><a href="{{ route('reservation.detail') }}?reservation_id={{ $reservation->id }}" class="btn btn-primary w-100">{{ @$labels['booking-dettaglio-prenotazione'] }}</a>
                </aside>
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
    <?php
      $total = $reservation->total;
      if($reservation->total_acconto){
          $total = $reservation->total_acconto;
      }
    ?>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        name: 'Prenotazione n.{{ $reservation->id }}',
                        description: '{{ env('PROJECT_NAME') }} prenotazione n.{{ $reservation->id }}',
                        amount:
                            {
                                value:'{{ ($total) }}',
                                breakdown:
                                    {
                                        'item_total':
                                            {
                                                'currency_code':'EUR',
                                                'value':'{{ ($total) }}'
                                            }
                                    }
                            },
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    console.log('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    if(transaction.status == 'COMPLETED') {
                        var order_id = '{{ $reservation->id }}';
                        var token = '{{ csrf_token() }}';
                        $.ajax({
                            type: 'POST',
                            url: '/paypal-transaction-complete-booking',
                            data: 'details='+JSON.stringify(orderData)+'&orderID='+transaction.id+'&order_id='+order_id+'&_token='+token,
                            success: function (msg) {
                                location.reload();
                            },
                            error: function () {
                                $('#error_payment').html('<div class="alert alert-danger">Errore pagamento! Contattaci tramite chat!</div>');
                            }
                        });
                    }else{
                        $('#error_payment').html('<div class="alert alert-danger">Errore pagamento! Contattaci tramite chat!</div>');
                    }
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
