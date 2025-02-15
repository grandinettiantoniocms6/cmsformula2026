<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>
<form id="form_servizi">
    {{ csrf_field() }}

    <h4 class="mb-4">{{ @$labels['booking-services-title'] }}</h4>

    @if(count($services))
        @foreach($services as $serviceId)
            <?php
            $item_service = \App\Models\PluginBookingServices::find($serviceId);
            if(!$item_service){
                continue;
            }
            ?>

            <div class="card card-service">

            @if($item_service->is_edit_qty)
                <input class="form-check-input" type="checkbox" name="services[]" value="{{ $item_service->id }}" id="service_{{ $item_service->id }}">
                <label class="form-check-label">
                    <div class="row gx-0 gx-lg-3">
                        <div class="col-xl-2 col-lg-3 col-4">
                            <div class="service-gallery">
                                @if($item_service->photo)
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url($item_service->get_foto_front('list')) }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @else
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <h4 class="title"> {{ $item_service->name }}</h4>
                                <div class="description">{!! $item_service->description !!}</div>
                                <div class="prices">
                                    <ins class="new-price">&euro; {{ number_format($item_service->price_1, 2, ",", ".") }}</ins>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center h-100">
                                <label class="form-label">{{ @$labels['booking-services-qty'] }}</label>

                                <div class="input-group">
                                    <button class="btn btn-primary btn-sm button-minus" type="button" onclick="decreaseValueB('#service_qty_{{ $item_service->id }}')"><i class="fas fa-minus"></i></button>
                                    <input class="form-control form-control-sm text-center" type="number" name="services_qty[{{ $item_service->id }}]" value="0" id="service_qty_{{ $item_service->id }}" step="1" min="0" max="{{ $session->qty }}" onchange="seleziona_servizio('{{ $item_service->id }}')">
                                    <button class="btn btn-primary btn-sm button-plus" type="button" onclick="increaseValueB('#service_qty_{{ $item_service->id }}')"><i class="fas fa-plus"></i></button>
                                </div>

                                @if($diff_days > 1)
                                    <label class="form-label">{{ @$labels['booking-riassume-n-notti'] }}</label>
                                    <div class="input-group">
                                        <button class="btn btn-primary btn-sm button-minus" type="button" onclick="decreaseValueB('#service_day_{{ $item_service->id }}')"><i class="fas fa-minus"></i></button>
                                        <input class="form-control form-control-sm text-center" type="number" name="services_day[{{ $item_service->id }}]" value="0" id="service_day_{{ $item_service->id }}" step="1" min="1" max="{{ $diff_days }}" onchange="seleziona_servizio('{{ $item_service->id }}')">
                                        <button class="btn btn-primary btn-sm button-plus" type="button" onclick="increaseValueB('#service_day_{{ $item_service->id }}')"><i class="fas fa-plus"></i></button>
                                    </div>
                                @else
                                    <input type="hidden" name="services_day[{{ $item_service->id }}]" value="1">
                                @endif

                            </div>
                        </div>
                    </div>
                </label>
            @else
                <input class="form-check-input" type="checkbox" name="services[{{ $item_service->id }}]" value="{{ $item_service->id }}" id="service_{{ $item_service->id }}">
                <label class="form-check-label pointer" for="service_{{ $item_service->id }}">
                    <div class="row gx-0 gx-lg-3">
                        <div class="col-xl-2 col-lg-3 col-4">
                            <div class="service-gallery">
                                @if($item_service->photo)
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url($item_service->photo) }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @else
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <h4 class="title">{{ $item_service->name }}</h4>
                                <div class="description">{!! $item_service->description !!}</div>
                                <div class="prices">
                                    <ins class="new-price">&euro; {{ number_format($item_service->price_1, 2, ",", ".") }}</ins>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center h-100">
                                <span class="btn btn-primary w-100">{{ @$labels['booking-services-seleziona'] }}</span>
                            </div>
                        </div>
                    </div>
                </label>
            @endif
            </div>
        @endforeach
    @else
        <div class="alert alert-danger d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div>{{ @$labels['booking-services-no-disponibile'] }}</div>
        </div>
    @endif

    <div class="mt-4">
        <button class="btn btn-success btn-lg text-white width-lg-auto width-100" onclick="carica_partecipanti()" type="button">{{ @$labels['booking-continua'] }} <i class="bi bi-arrow-right"></i></button>
    </div>
</form>


