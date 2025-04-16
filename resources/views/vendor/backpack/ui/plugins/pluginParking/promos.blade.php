<div class="card">
    <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
        <div class="row align-items-center">
            <div class="col line-height-sm">Promozioni</div>
            <div class="col-auto">
                <button type="button" class="btn btn-dark btn-sm py-1" id="add-promo"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
            </div>
        </div>
    </div>
    <div class="card-table" id="box_promos">
        @if($list_promos)
            @foreach($list_promos as $item)
                <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_promo_{{ $item->id }}">
                    <div class="form-group col-md-1">
                        <label>Tipo</label>
                        <select class="form-control" name="rule_discount[]" id="rule_discount_{{ $item->id }}">
                            @if($item->rule_discount == 0)
                                <option value="0" selected>Sottrai</option>
                                <option value="1">Aggiungi</option>
                            @else
                                <option value="0">Sottrai</option>
                                <option value="1" selected>Aggiungi</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Valore</label>
                        <input type="text" class="form-control" name="discount[]" id="discount_{{ $item->id }}" value="{{ @$item->discount }}">
                    </div>

                    <div class="form-group col-md-1">
                        <label>Tipo sconto</label>
                        <select class="form-control" name="type_discount[]" id="type_discount_{{ $item->id }}">
                            @if($item->type_discount == 0)
                                <option value="0" selected>&euro;</option>
                                <option value="1">%</option>
                            @else
                                <option value="0">&euro;</option>
                                <option value="1" selected>%</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Data inizio</label>
                        <input type="date" class="form-control" name="discount_date_start[]" id="discount_date_start_{{ $item->id }}" value="{{ @$item->date_start }}" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Data fine</label>
                        <input type="date" class="form-control" name="discount_date_end[]" id="discount_date_end_{{ $item->id }}" value="{{ @$item->date_end }}" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Tipo Parcheggio</label>
                        <select class="form-control" name="condition_discount[]" id="condition_discount_{{ $item->id }}">
                            <option value="0"></option>
                            @if($item->condition_discount == 1)
                                <option value="1" selected>Scoperto</option>
                                <option value="2">Coperto</option>
                            @else
                                @if($item->condition_discount == 2)
                                    <option value="1">Scoperto</option>
                                    <option value="2" selected>Coperto</option>
                                @else
                                    <option value="1">Scoperto</option>
                                    <option value="2">Coperto</option>
                                @endif

                            @endif
                        </select>
                    </div>

                <!--
                    <div class="form-group col-md-1">
                        <label>Regola</label>
                        <select class="form-control" name="rule_discount[]" id="rule_discount_{{ $item->id }}">
                            @if($item->rule_discount == 0)
                                <option value="0" selected>Uguale</option>
                                <option value="1">Maggiore</option>
                            @else
                                <option value="0">Uguale</option>
                                <option value="1" selected>Maggiore</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Valore</label>
                        <input type="number" class="form-control" name="value_discount[]" id="value_discount_{{ $item->id }}" value="{{ @$item->value_discount }}">
                    </div> -->

                    <div class="form-group col-md-1">
                        <label>Ordine</label>
                        <input type="number" class="form-control" name="lft_discount[]" id="lft_discount_{{ $item->id }}" value="{{ @$item->lft }}">
                    </div>

                    <div class="form-group col-md-1">
                        <a class="btn-danger btn" onclick="deleteRow({{ $item->id }}, 'promo')" href="#"><i class="la la-trash la-lg"></i></a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
