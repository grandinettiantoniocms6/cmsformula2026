<div class="card">
    <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
        <div class="row align-items-center">
            <div class="col line-height-sm">Strutture dipendenti</div>
            <div class="col-auto">
                  <button type="button" class="btn btn-primary btn-sm py-1" id="add-addiction"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
            </div>
        </div>
    </div>
    <div class="card-table" id="box_addictions">
        @if($list_addictions)
            @foreach($list_addictions as $item)
                <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_addiction_{{ $item->id }}">
                    <div class="form-group col-md-8">
                        <label>Struttura</label>
                        <br>
                        <?php
                        $room  = \App\Models\PluginBookingRoom::find($item->room_id);
                        ?>
                        @if($room)
                            {{ $room->name }}
                            <input type="hidden" name="addictions[]" value="{{ $room->id }}">
                        @endif
                    </div>

                    <div class="form-group col-md-1">
                        <a class="btn-danger btn" onclick="deleteRow({{ $item->id }}, 'addiction')" href="#"><i class="la la-trash la-lg"></i></a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

