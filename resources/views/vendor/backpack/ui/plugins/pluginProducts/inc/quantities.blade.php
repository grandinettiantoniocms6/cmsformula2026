<div class="card">
    <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
        <div class="row align-items-center">
            <div class="col line-height-sm">Sconto su quantità</div>
            <div class="col-auto">
                <button type="button" class="btn btn-dark btn-sm py-1" id="add-quantity"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
            </div>
        </div>
    </div>
    <div class="card-table" id="box_quantities">
        @if($products_quantities)
            @foreach($products_quantities as $item)
                <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_quantity_{{ $item->id }}">
                    <div class="form-group col-md-4">
                        <label>Pezzi minimo</label>
                        <input type="number" class="form-control" name="min_quantities[]" id="min_quantities_{{ $item->id }}" value="{{ @$item->quantity_min }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Prezzo &euro; iva escl.</label>
                        <input type="text" class="form-control" name="price_quantities[]" id="price_quantities_{{ $item->id }}" value="{{ @$item->price }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <a class="btn-danger btn mt-4" onclick="deleteRow({{ $item->id }}, 'quantity')" href="#"><i class="la la-trash la-lg"></i></a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
