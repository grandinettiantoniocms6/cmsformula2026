<?php
$services_list = \App\Models\PluginBookingServices::get()->pluck("name", "id")->toArray();;
?>

<div class="card mb-0">
    <div class="card-header bg-light">
        <div class="row align-items-center">
            <div class="col">Servizi aggiuntivi
            </div>
            <div class="col-auto">
                <a class="btn btn-dark btn-sm py-1" href="#" id="add-service"><span>Aggiungi</span></a>
            </div>
        </div>
    </div>
    <div class="card-body py-0" id="box_services">
        @if($services)
            @foreach($services as $service)
                <div class="row border-bottom align-items-end" id="box_service_{{ $service->id }}">
                    <div class="py-2 col-md">
                        <label>Servizio</label>
                        <select class="form-control" name="service_id[]" id="service_select_{{ $service->id }}" onchange="carica_dati('+random+')">
                            @foreach($services_list as $k=>$v)
                                @if($k == $service->plugin_booking_service_id)
                                    <option value="{{ $k }}" selected>{{ $v }}</option>
                                @else
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                    <div class="py-2 col-md-2 col-xl-1">
                        <label>Qty</label>
                        <input type="number" value="{{ $service->qty }}" class="form-control" name="service_qty[]" id="service_qty_{{ $service->id }}">
                    </div>
                    <div class="py-2 col-md-2 col-xl-1">
                        <label>Prezzo</label>
                        <input type="text" value="{{ $service->price }}" class="form-control" name="service_price[]" id="service_price_{{ $service->price }}">
                    </div>
                    <div class="fpy-2 col-md-auto">
                        <a class="btn-danger btn" onclick="deleteRowService({{ $service->id }})" href="#">Elimina</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
