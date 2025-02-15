<div class="card">
    <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
        <div class="row align-items-center">
            <div class="col line-height-sm">Prezzi</div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary btn-sm py-1" id="add-price"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
            </div>
        </div>
    </div>
    <div class="card-table" id="box_prices">
        @if($list_prices)
            @foreach($list_prices as $item)
                <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_price_{{ $item->id }}">
                    <div class="form-group col-md-2">
                        <label>Prezzo &euro; (iva inclusa)</label>
                        <input type="text" class="form-control" name="price[]" id="price_{{ $item->id }}" value="{{ @$item->price }}" required>
                    </div>


                    <div class="form-group col-md-1 @if($room->plugin_booking_type_id != env('ID_TIPOLOGIA_MIN_MAX_GIORNI')) d-none @endif">
                        <label>Min. Giorni</label>
                        <input type="number" class="form-control" name="min_day[]" id="min_day_{{ $item->id }}" value="{{ @$item->min_day }}" required>
                    </div>

                    <div class="form-group col-md-1 @if($room->plugin_booking_type_id != env('ID_TIPOLOGIA_MIN_MAX_GIORNI')) d-none @endif">
                        <label>Max. Giorni</label>
                        <input type="number" class="form-control" name="max_day[]" id="max_day_{{ $item->id }}" value="{{ @$item->max_day }}" required>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Min. Ospiti</label>
                        <input type="number" class="form-control" name="min[]" id="min_{{ $item->id }}" value="{{ @$item->min }}" required>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Max. Ospiti</label>
                        <input type="number" class="form-control" name="max[]" id="max_{{ $item->id }}" value="{{ @$item->max }}" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Data inizio</label>
                        <input type="date" class="form-control" name="date_start[]" id="date_start_{{ $item->id }}" value="{{ @$item->date_start }}" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Data fine</label>
                        <input type="date" class="form-control" name="date_end[]" id="date_end_{{ $item->id }}" value="{{ @$item->date_end }}" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Ripetizione</label>
                        <select class="form-control" name="all_years[]">
                            <option value="0" @if(@$item->all_years == 0) selected @endif>Data specifica</option>
                            <option value="1" @if(@$item->all_years == 1) selected @endif>Ripeti ogni anno</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <a class="btn-danger btn" onclick="deleteRow({{ $item->id }}, 'price')" href="#"><i class="la la-trash la-lg"></i></a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
