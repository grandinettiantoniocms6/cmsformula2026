@if($rooms)
    @foreach($rooms as $item)
        <?php
        $room = \App\Models\PluginBookingRoom::where("id", $item->plugin_booking_room_id)->first();
        $partecipants = \App\Models\PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $id)->get();
        ?>
        <div class="card mb-2">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col"><h4 class="mb-0">{{ $room->name }}

                            <span class="badge badge-primary">{{ number_format($item->price,2,",",".") }} &euro;</span>
                        </h4>
                    </div>

                    <div class="col">
                        <input type="text" class="form-control" name="prices_rooms[{{ $room->id }}]" value="{{ $item->price }}">
                    </div>
                    <div class="col-auto">
                        @if($type)
                            @if($type->is_checkin)
                                <a class="btn btn-primary btn-sm" href="javascript:add_checkin({{ $room->id }});"><span>Aggiungi</span></a>
                            @endif
                        @endif
                    </div>


                </div>

                @if($type)
                    @if($type->is_addiction)
                        <?php
                        $reservations = \App\Models\PluginBookingReservation::where("parent_id", $item->id)->get();
                        ?>
                        @if(count($reservations))
                            <strong>Strutture collegate a questa prenotazione</strong><br>
                            @foreach($reservations as $res)
                                <?php
                                $room_temp = \App\Models\PluginBookingRoom::find($res->plugin_booking_room_id);
                                ?>
                                {{ $room_temp->name }}<br>
                            @endforeach
                        @endif
                    @endif
                @endif
            </div>
        </div>
        <div id="box_{{ $room->id }}">
            @if($partecipants)
                @foreach($partecipants as $partecipant)
                    <div class="card mb-2" id="box_{{ $partecipant->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right"><a class="btn-danger btn btn-sm" onclick="deleteRow({{ $partecipant->id }})" href="#">Elimina</a></div>
                                <div class="form-group col-md-6 col-xl-3">
                                    <label>Nome</label>
                                    <input type="text" value="{{ $partecipant->first_name }}" class="form-control" name="first_name[]" id="first_name_{{ $partecipant->id }}">
                                </div>
                                <div class="form-group col-md-6 col-xl-3">
                                    <label>Cognome</label>
                                    <input type="text" value="{{ $partecipant->last_name }}" class="form-control" name="last_name[]" id="last_name_{{ $partecipant->id }}">
                                </div>
                                <div class="form-group col-md-4 col-xl-2">
                                    <label>Data di nascita</label>
                                    <input type="date" value="{{ $partecipant->birthdate }}" class="form-control" name="birthdate[]" id="birthdate_{{ $partecipant->id }}">
                                </div>
                                <div class="form-group col-md-4 col-xl-2">
                                    <label>Email</label>
                                    <input type="text" value="{{ $partecipant->email }}" class="form-control" name="email[]" id="email_{{ $partecipant->id }}">
                                </div>
                                <div class="form-group col-md-4 col-xl-2">
                                    <label>Telefono</label>
                                    <input type="text" value="{{ $partecipant->mobile }}" class="form-control" name="mobile[]" id="mobile_{{ $partecipant->id }}">
                                </div>
                                <div class="form-group col-md-6 col-xl-3">
                                    <label>Carta di identita</label>
                                    <input type="text" value="{{ $partecipant->numero_carta_identita }}" class="form-control" name="carta[]" id="carta_{{ $partecipant->id }}">
                                </div>
                                <div class="form-group col-md-6 col-xl-3">
                                    <label>Scadenza</label>
                                    <input type="date" value="{{ $partecipant->scadenza_carta_identita }}" class="form-control" name="scadenza_carta[]" id="scadenza_carta_{{ $partecipant->id }}">
                                </div>
                                <div class="form-group col-xl-6">
                                    <label>Rilasciato da</label>
                                    <input type="text" value="{{ $partecipant->comune_carta_identita }}" class="form-control" name="comune[]" id="comune_carta_{{ $partecipant->id }}">
                                </div>
                                <div class="col-12">
                                    <label>Documento File</label>
                                    @if($partecipant->document_file)
                                        <div><a href="{{ route('getUrl') }}?url={{ $partecipant->document_file }}" target="_blank">Documento caricato</a></div>
                                        <input type="hidden" value="{{ $partecipant->document_file }}" class="form-control" name="document_file[]" id="file_d_{{ $partecipant->id }}">
                                    @else
                                        <input type="file" value="" class="form-control" name="file[]" id="file_carta_{{ $partecipant->id }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endforeach
@endif
