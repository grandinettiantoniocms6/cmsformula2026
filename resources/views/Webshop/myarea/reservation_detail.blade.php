<?php
$adminPluginProducts = \App\Models\AdminPlugin::where("name", "pluginProducts")
    ->where("version", 3)
    ->where("is_active", 1)
    ->first();


$adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();

if($adminPluginProducts){
    $labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
}

if($adminPluginBooking){
    $labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
}

$symbol = "&euro;";
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
    $symbol = "&#36;";
}
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
    $symbol = "&euro;";
}
?>


<section class="border-top border-bottom page-myarea py-3 py-sm-4">
    <div class="container">
        <h3>{{ @$labels['shop-dettaglio-prenotazione'] }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ @$labels['booking-myarea-home'] }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ @$labels['booking-myarea-dettaglio-prenotazione'] }}</li>
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
                <?php
                $payment = \App\Models\PluginBookingPayments::where("id", $reservation->plugin_booking_payment_id)->first();
                $type = \App\Models\PluginBookingType::where("id", $reservation->type_id)->first();
                ?>

                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-check-circle font-xl me-3"></i>
                    <div class="line-height-md">
                        <div class="font-md-xl font-weight-700">{{ $reservation->status->name }}</div>
                        @if($reservation->payment_date)
                            <div>{{ @$labels['booking-myarea-pagamento-effettuato-il-giorno'] }} {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $reservation->payment_date)->format("d/m/Y H:i") }}</div>
                        @endif
                    </div>

                    @if($payment)
                        @if($reservation->status && $reservation->is_payed == 0)
                            @if($reservation->status->is_payment == 0 && $reservation->total > 0)
                                <a class="btn btn-success btn-sm ms-auto" href="{{ route("pluginBooking.order.it", $reservation->id) }}?order_id={{ $reservation->id }}"><span data-bs-toggle="tooltip" title="{{ @$labels['booking-myarea-paga'] }}"><i class="fas fa-money-check-alt"></i> {{ @$labels['booking-myarea-paga'] }}</span></a>
                            @endif
                        @endif
                    @endif
                </div>

                <div class="card card-myarea">
                    <div class="card-header"><h5>{{ @$labels['booking-myarea-dettaglio-prenotazione'] }}</h5></div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>{{ @$labels['booking-myarea-ordine-numero'] }}</th>
                                <td>{{ $reservation->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ @$labels['booking-myarea-ordine-effettuato-il'] }}</th>
                                <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $reservation->created_at)->format("d/m/Y H:i") }}</td>
                            </tr>
                            <tr>
                                <th>{{ @$labels['booking-myarea-ordine-dal'] }}</th>
                                <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_start)->format("d/m/Y") }}
                                    @if($reservation->start_time)
                                        ore {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->start_time)->format("H:i") }}
                                    @endif
                                </td>
                            </tr>
                            @if($reservation->date_end)
                                <tr>
                                    <th>{{ @$labels['booking-myarea-ordine-al'] }}</th>
                                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_end)->format("d/m/Y") }}
                                        @if($reservation->end_time)
                                            {{ @$labels['booking-myarea-ore'] }} {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->end_time)->format("H:i") }}
                                        @endif
                                    </td>
                                </tr>
                                @if($reservation->date_end && $reservation->date_start)
                                <tr>
                                    <th>{{ @$labels['booking-myarea-ordine-notti'] }}</th>
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
                                <th>{{ @$type->label_checkout }}</th>
                                <td>
                                    <?php
                                    $reservation_room = \App\Models\PluginBookingReservationRoom::where("plugin_booking_reservation_id", $reservation->id)->first();
                                    $room = \App\Models\PluginBookingRoom::find($reservation_room->plugin_booking_room_id); ?>
                                    @if($room)
                                        {{ $room->name }}
                                        <?php
                                        $price = number_format($reservation_room->price,2,",",".");
                                        ?>
                                        @if($reservation_room->price > 0)
                                       <!-- &euro; {{ $price }} -->
                                        @endif
                                    @endif
                                </td>
                            </tr>

                            @if(@$type->is_checkin == 0)
                                <tr>
                                    <th>{{ @$labels['booking-myarea-numero-ospiti'] }}</th>
                                    <td>
                                       {{ $reservation->total_qty }}
                                    </td>
                                </tr>
                            @endif

                            <?php
                            $reservation_services = \App\Models\PluginBookingReservationService::where("plugin_booking_reservation_id", $reservation->id)->get();
                            ?>

                            @if(count($reservation_services))
                                <tr>
                                    <th>{{ @$labels['booking-myarea-servizi-aggiuntivi'] }}</th>
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
                                    <th>{{ @$labels['booking-myarea-totale'] }}</th>
                                    <td>&euro; {{ number_format($reservation->total,2,",",".") }}</td>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                @if($type->is_checkin == 1)
                <div class="card card-myarea">
                    <div class="card-header"><h5>{{ @$labels['booking-myarea-effettua-check-in-digitale'] }}</h5></div>

                    <?php
                    $reservation_partecipants = \App\Models\PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $reservation_room->id)->get();
                    $readonly = "";
                    if($reservation->is_block_upload == 1){
                        $readonly = "readonly";
                    } ?>

                    @if(session()->has('message'))
                        <div class="alert alert-info d-flex align-items-center mt-4 mx-4 mb-0">
                            <i class="bi bi-check-circle font-xl me-3"></i>
                            <div class="font-md-xl font-weight-700">{!! session()->get('message') !!}</div>
                        </div>
                    @endif

                    <form method="post" action="{{ route('pluginBooking.save_documents.it') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                        <?php $i = 1; ?>
                        @foreach($reservation_partecipants as $partecipant)
                            <div class="card-header" id="box_{{ $partecipant->id }}">
                                <label class="badge bg-primary">{{ @$labels['booking-myarea-ospite'] }}{{ $i }}</label>
                                <div class="row">
                                    <div class="form-group col-md-6 col-xl-6">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-nome-ospite'] }}</label>
                                        <input type="text" value="{{ $partecipant->first_name }}" class="form-control" name="first_name[]" id="first_name_{{ $partecipant->id }}" <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-6">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-cognome-ospite'] }}</label>
                                        <input type="text" value="{{ $partecipant->last_name }}" class="form-control" name="last_name[]" id="last_name_{{ $partecipant->id }}"  <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group col-md-4 col-xl-4">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-data-di-nascita'] }}</label>
                                        <input type="date" value="{{ $partecipant->birthdate }}" class="form-control" name="birthdate[]" id="birthdate_{{ $partecipant->id }}"  <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group col-md-4 col-xl-4">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-email'] }}</label>
                                        <input type="text" value="{{ $partecipant->email }}" class="form-control" name="email[]" id="email_{{ $partecipant->id }}"  <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group col-md-4 col-xl-4">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-telefono'] }}</label>
                                        <input type="text" value="{{ $partecipant->mobile }}" class="form-control" name="mobile[]" id="mobile_{{ $partecipant->id }}"  <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-4">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-numero-documento'] }}</label>
                                        <input type="text" value="{{ $partecipant->numero_carta_identita }}" class="form-control" name="carta[]" id="carta_{{ $partecipant->id }}"  <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-3">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-scadenza-documento'] }}</label>
                                        <input type="date" value="{{ $partecipant->scadenza_carta_identita }}" class="form-control" name="scadenza_carta[]" id="scadenza_carta_{{ $partecipant->id }}"  <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group col-xl-5">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-documento-rilasciato-da'] }}</label>
                                        <input type="text" value="{{ $partecipant->comune_carta_identita }}" class="form-control" name="comune[]" id="comune_carta_{{ $partecipant->id }}"  <?php echo $readonly;?>>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label font-sm">{{ @$labels['booking-myarea-documento-file'] }}</label>
                                        @if($partecipant->document_file)
                                            <div><a href="{{ route('getUrl') }}?url={{ $partecipant->document_file }}" target="_blank">{{ @$labels['booking-myarea-documento-caricato'] }}</a></div>
                                        @endif
                                        @if($reservation->is_block_upload != 1)
                                            <input class="form-control" name="file[]" id="file_carta_{{ $partecipant->id }}"  type="file">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                        @endforeach

                        @if($reservation->is_block_upload != 1)
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary px-lg-4">{{ @$labels['booking-myarea-aggiorna-dati'] }}</button>
                            </div>
                        @endif
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

