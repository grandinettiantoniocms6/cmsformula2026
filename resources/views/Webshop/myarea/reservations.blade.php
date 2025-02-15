<?php $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray(); ?>

<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['booking-myarea-le-mie-prenotazioni'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="bi bi-chevron-left d-inline-block d-md-none"></i> {{ @$labels['shop-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['booking-myarea-le-mie-prenotazioni'] }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="row">
            <aside class="col-12 col-xl-3">
                @include("$thema.inc.myarea_menu")
            </aside>
            <div class="col-12 col-xl-9">
                <div class="card card-myarea">
                    <div class="card-header">
                        <h5>{{ @$labels['booking-myarea-storico-prenotazioni'] }}</h5>
                    </div>
                    <div class="card-body">
                        @if(count($reservations))
                            <table class="table table-fluid">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-end">{{ @$labels['booking-myarea-id'] }}</th>
                                        <th width="200">{{ @$labels['booking-myarea-data-inizio'] }}</th>
                                        <th width="200">{{ @$labels['booking-myarea-data-fine'] }}</th>
                                        <th width="200">{{ @$labels['booking-myarea-cosa'] }}</th>
                                        <th width="200">{{ @$labels['booking-myarea-stato'] }}</th>
                                        <th class="text-end">{{ @$labels['booking-myarea-totale'] }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($reservations as $reservation)
                                    <?php
                                    $room = \App\Models\PluginBookingRoom::find($reservation->plugin_booking_room_id);
                                    $payment = \App\Models\PluginBookingPayments::where("id", $reservation->plugin_booking_payment_id)->first();
                                    ?>
                                    <tr>
                                        <td data-column="Ordine" class="text-end"><a href="{{ route('reservation.detail') }}?reservation_id={{ $reservation->id }}" title="Prenotazione #{{ $reservation->id }}">#{{ $reservation->id }}</a></td>
                                        <td data-column="Data inizio">{{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_start)->format("d/m/Y") }}

                                            @if($reservation->start_time)
                                                <br/> {{ @$labels['booking-myarea-ore'] }} {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->start_time)->format("H:i") }}
                                            @endif

                                        </td>
                                        <td data-column="Data fine">
                                            @if($reservation->date_end)
                                            {{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_end)->format("d/m/Y") }}
                                                @if($reservation->end_time)
                                                    <br/>{{ @$labels['booking-myarea-ore'] }} {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->end_time)->format("H:i") }}
                                                @endif
                                            @endif
                                        </td>
                                        <td data-column="Cosa">
                                            @if($room)
                                               {{ $room->name }}
                                            @endif
                                        </td>
                                        <td data-column="Stato">
                                            @if($reservation->status)
                                             <span class="{{ $reservation->status->class }}">{{ $reservation->status->name }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end" data-column="Totale">
                                            @if($reservation->total > 0)
                                                &euro; {{ number_format($reservation->total,2,",", ".") }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end" data-column="Azioni">
                                            <a class="btn btn-primary btn-sm" href="{{ route('reservation.detail') }}?reservation_id={{ $reservation->id }}">{{ @$labels['booking-myarea-guarda-prenotazione'] }}</a>
                                            @if($payment)
                                                @if($reservation->status && $reservation->is_payed == 0)
                                                    @if($reservation->status->is_payment == 0 && $reservation->total > 0)
                                                           <a class="btn btn-success btn-sm ms-1 ms-md-0" href="{{ route("pluginBooking.order.it", $reservation->id) }}?order_id={{ $reservation->id }}"><span data-bs-toggle="tooltip" title="{{ @$labels['booking-myarea-paga'] }}"><i class="fas fa-money-check-alt"></i> {{ @$labels['booking-myarea-paga'] }}</span></a>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @else
                            <div class="py-4 text-center my-0">
                                <div class="display-4 text-muted"><i class="fab fa-creative-commons-nc-eu"></i></div>
                                <h5 class="mb-4">{{ @$labels['booking-myarea-nessuna-prenotazione-effettuata'] }}</h5>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
