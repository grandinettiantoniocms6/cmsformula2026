<tr data-catid="new-{{ $product->id }}-{{ $rand }}" data-catidsel="{{ $product->id }}" id="product-{{ $product->id }}-row-{{ $rand }}">
    <td class="align-middle" width="60">
        <button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="las la-trash-alt"></i></button>
    </td>
    <td class="align-middle">
        <input type="hidden" name="products[]" value="{{ $product->id }}">
        <h6 class="font-weight-bold">{{ $product->name }}</h6>
        <div class="row">
            <div class="col">
                <label class="d-block small mb-0">Persone</label>
                <input type="number" class="form-control" name="products_num[]" value="1" min="1">
            </div>
            <div class="col">
                <label class="d-block small mb-0">Reparto</label>
                <select class="custom-select form-control" name="products_units[]">
                    @if($units)
                        @foreach ($units as $unit)
                            @if($unit->id == $resourceId)
                                <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                            @else
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <label class="d-block small mb-0">Quantità</label>
                <input type="text" class="form-control" name="products_qty[]" value="1">
            </div>
            <div class="col">
                <label class="d-block small mb-0">Prezzo</label>
                <input type="text" class="form-control" name="products_price[]" value="{{ $product->price }}">
            </div>
            <div class="col">

            </div>
        </div>
    </td>
</tr>
