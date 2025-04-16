@if($services)
<div class="card">
    <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
        <div class="row align-items-center">
            <div class="col line-height-sm">Servizi Inclusi</div>
            <div class="col-auto">
                  <button type="button" class="btn btn-dark btn-sm py-1" id="add-service-gratis"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
            </div>
        </div>
    </div>
    <div class="card-table" id="box_services_gratis">
        @if($list_values_free)
            @foreach($list_values_free as $item)
                <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_service_gratis_{{ $item->id }}">
                    <div class="form-group col-md-8">
                        <label>Servizio</label>
                        <select name="services_list_free[]" class="form-control">
                            @foreach($services as $k=>$service)
                                <option value="{{ $k }}" @if($k == $item->plugin_booking_service_id) selected @endif>{{ $service }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Ordine</label>
                        <input type="number" class="form-control" name="lft_free[]" id="lft_free_{{ $item->id }}" value="{{ @$item->lft }}">
                    </div>

                    <div class="form-group col-md-1">
                        <a class="btn-danger btn" onclick="deleteRow({{ $item->id }}, 'service_gratis')" href="#"><i class="la la-trash la-lg"></i></a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endif


@if($services_payments)
    <div class="card">
        <div class="card-header list-group-item-accent-secondary bg-light font-600 border-bottom-0 py-2">
            <div class="row align-items-center">
                <div class="col line-height-sm">Servizi a Pagamento</div>
                <div class="col-auto">
                    <button type="button" class="btn btn-dark btn-sm py-1" id="add-service-payment"><i class="icon-plus fa-15"></i> <span class="d-none d-md-inline">Aggiungi</span></button>
                </div>
            </div>
        </div>
        <div class="card-table" id="box_services_payment">
            @if($list_values)
                @foreach($list_values as $item)
                    <div class="col-md-12 well repeatable-element row m-1 p-2" id="box_service_payment_{{ $item->id }}">
                        <div class="form-group col-md-8">
                            <label>Servizio</label>
                            <select name="services_list[]" class="form-control">
                                @foreach($services_payments as $k=>$service)
                                    <option value="{{ $k }}" @if($k == $item->plugin_booking_service_id) selected @endif>{{ $service }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Ordine</label>
                            <input type="number" class="form-control" name="lft[]" id="lft_{{ $item->id }}" value="{{ @$item->lft }}">
                        </div>

                        <div class="form-group col-md-1">
                            <a class="btn-danger btn" onclick="deleteRow({{ $item->id }}, 'service_payment')" href="#"><i class="la la-trash la-lg"></i></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endif
