<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>
<h4 class="mb-4">{{ @$labels['booking-riassume-title'] }}</h4>

@if(!\Session::get('user_id'))
    <div class="alert alert-warning d-flex align-items-center">
        <i class="fas fa-exclamation-circle me-2"></i>
        <div>{!! $type->info !!} </div>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <?php
        $room = \App\Models\PluginBookingRoom::find($session->room_id); ?>
        @if($room)
            @if($room->cover_photo)
                 <img class="img-fluid mx-auto" src="{{ url($room->get_foto_front('cover')) }}">
            @endif
        @endif
    </div>
    <div class="col-md-6">
        <table class="table table-sm">
            <tbody>
            @if($type->type_booking == 0)
                <tr>
                    <th>{{ @$labels['booking-riassume-quando'] }}</th>
                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->format("d/m/Y") }}</td>
                </tr>
            @endif

            @if($type->type_booking == 1)
                <tr>
                    <th>{{ @$labels['booking-riassume-quando'] }}</th>
                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->format("d/m/Y") }} {{ @$labels['booking-riassume-alle'] }} {{ $session->start_time }}</td>

            @endif

            @if($type->type_booking == 2)
                <tr>
                    <th>{{ @$labels['booking-riassume-dal'] }}</th>
                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->format("d/m/Y") }}</td>
                </tr>
                <tr>
                    <th>{{ @$labels['booking-riassume-al'] }}</th>
                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $session->end)->format("d/m/Y") }}</td>
                </tr>
                @if($session->end && $session->start)
                <tr>
                    <th>{{ @$labels['booking-riassume-n-notti'] }}</th>
                    <td>
                        <?php
                        $diff = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->diffInDays(\Carbon\Carbon::createFromFormat("Y-m-d", $session->end));
                        if($diff == 0){
                            $diff = 1;
                        }
                        echo $diff;
                        ?>
                    </td>
                </tr>
                @endif
            @endif

            @if($type->type_booking == 3)
                <tr>
                    <th>{{ @$labels['booking-riassume-dal'] }}</th>
                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->format("d/m/Y") }} {{ @$labels['booking-riassume-alle'] }} {{ $session->start_time }}</td>
                </tr>
                <tr>
                    <th>{{ @$labels['booking-riassume-al'] }}</th>
                    <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $session->end)->format("d/m/Y") }} {{ @$labels['booking-riassume-alle'] }} {{ $session->end_time }}</td>
                </tr>
                @if($session->end && $session->start)
                <tr>
                    <th>{{ @$labels['booking-riassume-n-notti'] }}</th>
                    <td>
                        <?php
                        $diff = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->diffInDays(\Carbon\Carbon::createFromFormat("Y-m-d", $session->end));
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
                <th>{{ @$labels['booking-riassume-n-ospiti'] }}</th>
                <td>
                    {{  $session->qty  }}
                </td>
            </tr>
            <tr>
                <th>{{ $type->label_checkout }}</th>
                <td>
                    <?php
                    $room = \App\Models\PluginBookingRoom::find($session->room_id); ?>
                    @if($room)
                    {{ $room->name }}
                    @endif

                    @if($tot > 0)
                    &euro; {{ number_format($tot,2,",",".") }}
                    @endif

                    {!! $session->listino_vet[$room->id] !!}
                </td>
            </tr>

            @if($type->is_checkin)
                <tr>
                    <th>{{ @$labels['booking-riassume-ospiti'] }}</th>
                    <td>
                        @if($session->partecipants)
                            <ol class="ps-3 mb-0">
                                @foreach($session->partecipants as $partecipant)
                                    <li>{{ $partecipant['first_name'] }} {{ $partecipant['last_name'] }} {{ @$labels['booking-riassume-nato-il'] }} {{ \Carbon\Carbon::createFromFormat("Y-m-d", $partecipant['birthdate'])->format("d/m/Y") }}</li>
                                @endforeach
                            </ol>
                        @endif
                    </td>
                </tr>
            @endif

            @if($session->services)
                <tr>
                    <th>{{ @$labels['booking-riassume-servizi'] }}</th>
                    <td>
                        <ul class="style-1">
                            @foreach($session->services as $k=>$servizio)
                                <?php
                                $temp = explode("|", $servizio);
                                if(!key_exists(3, $temp)){
                                    $temp[3] = 1;
                                }

                                if(property_exists($session, "services_day")){
                                    if(key_exists($k, $session->services_day)){
                                        $tot_serv = (($temp[2]*$temp[3]) * $session->services_day[$k]);
                                        $tot_serv = number_format($tot_serv,2,",", ".");

                                        $label = $labels['booking-riassume-giorno'] ;
                                        if($session->services_day[$k] > 1){
                                            $label = $labels['booking-riassume-giorni'];
                                        }

                                        $label_price = "x {$session->services_day[$k]} $label = € $tot_serv";
                                        $tot = $tot + (($temp[2]*$temp[3]) * $session->services_day[$k]);
                                    }else{
                                        $label_price = "";
                                        $tot = $tot + ($temp[2]*$temp[3]);
                                    }
                                }else{
                                    $label_price = "";
                                    $tot = $tot + ($temp[2]*$temp[3]);
                                }

                                ?>
                                <li>{{ $temp[3] }} {{ $temp[1] }} (&euro; {!! number_format($temp[2],2,",", ".") !!}) {{ $label_price }} </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endif
            </tbody>

            @if($tot > 0)
                <tfoot>
                <th>{{ @$labels['booking-riassume-totale'] }}</th>
                <td>&euro; {{ number_format($tot,2,",",".") }}

                    @if($session->end && $session->start)
                            <?php
                            $diff = \Carbon\Carbon::createFromFormat("Y-m-d", $session->start)->diffInDays(\Carbon\Carbon::createFromFormat("Y-m-d", $session->end));
                            $setting = \App\Models\PluginBookingSettings::first();
                            ?>
                        @if($diff >= $setting->number_days_for_acconto && $setting->number_days_for_acconto > 0)
                            {{ @$labels['booking-riassume-acconto'] }} {{ $setting->perc_acconto }}%
                            <?php
                            $perc = 1+($setting->perc_acconto / 100);

                            $tot_acconto = round($tot - ($tot / $perc),2);
                            ?>
                            di &euro; {{ number_format($tot_acconto,2,",",".") }}
                        @endif
                    @endif

                </td>
                </tfoot>
            @endif


        </table>
    </div>
</div>

