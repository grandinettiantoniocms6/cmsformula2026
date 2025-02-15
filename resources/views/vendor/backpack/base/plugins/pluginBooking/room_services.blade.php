<div class="card">
    <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
        <div class="row align-items-center">
            <div class="col line-height-sm">Servizi</div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary btn-sm py-1" id="add-price"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
            </div>
        </div>
    </div>
    <div class="card-table" id="box">
        @if($list)
            @foreach($list as $item)
                <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_{{ $item->id }}">
                    <div class="form-group col-md-2">
                        <label>Servizio</label>
                        <select class="form-control" name="service_id[]" id="sample_select_{{ $item->id }}">
                            <option value=""></option>
                            @foreach($services as $k=>$label)
                                <option value="{{ $k }}" @if($k == $item->service_id) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Prezzo 1</label>
                        <input type="text" class="form-control" name="name[]" id="name_{{ $item->id }}" value="{{ @$item->name }}">
                    </div>

                    <div class="form-group col-md-1">
                        <label>Prezzo 2</label>
                        <input type="text" class="form-control" name="name[]" id="name_{{ $item->id }}" value="{{ @$item->name }}">
                    </div>

                    <div class="form-group col-md-1">
                        <label>Incluso?</label>
                        <input type="checkboxù" class="form-control" name="tipologia[]" id="tipologia_{{ $item->id }}" value="{{ @$item->tipologia }}" required>
                    </div>

                    <div class="form-group col-md-1">
                        <a class="btn-danger btn" onclick="deleteRow({{ $item->id }})" href="#">Elimina</a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
