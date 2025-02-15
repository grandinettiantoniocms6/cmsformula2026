<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>
<form id="form_servizi_2">
    {{ csrf_field() }}

    <h4 class="mb-4">{{ @$labels['booking-offers-title'] }}</h4>

    @if(count($services))
        <div class="row">
        @foreach($services as $serviceId)
            <div class="col-sm-6 col-lg-4 col-xxl-3 d-flex">
                <?php
                    $item_service = \App\Models\PluginBookingServices::find($serviceId);
                    if(!$item_service){
                        continue;
                    }
                    ?>
                <div class="card card-service card-service-2">
                    @if($item_service->price_2 != $item_service->price_1 && $item_service->price_2 != 0)
                        <span class="badge">{{ @$labels['booking-offers-label'] }}</span>
                    @endif
                    @if($item_service->is_edit_qty)
                        <input class="form-check-input" type="checkbox" name="services[]" value="{{ $item_service->id }}" id="service_{{ $item_service->id }}_x">
                        <label class="form-check-label d-flex flex-column h-100">
                            <div class="service-gallery">
                                @if($item_service->photo)
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url($item_service->get_foto_front('list')) }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @else
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @endif
                            </div>
                            <div class="card-body flex-grow-1">
                                <h4 class="title">{{ $item_service->name }}</h4>
                                <div class="description">{!! $item_service->description !!}</div>
                            </div>
                            <div class="card-footer pb-3 bg-transparent border-top-0 mt-auto">
                                <div class="row align-items-end">
                                    <div class="col col-sm-12 col-md">
                                        <div class="prices line-height-sm">
                                            @if($item_service->price_2 != $item_service->price_1 && $item_service->price_2 != 0)
                                                <del class="old-price d-block">&euro; {{ number_format($item_service->price_1, 2, ",", ".") }}</del><ins class="new-price">&euro; {{ number_format($item_service->price_2, 2, ",", ".") }}</ins>
                                            @else
                                                <ins class="new-price d-block">&euro; {{ number_format($item_service->price_1, 2, ",", ".") }}</ins>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto col-sm-12 col-md-auto">
                                        <label class="form-label font-sm">{{ @$labels['booking-offers-qty'] }}</label>
                                        <div class="input-group">
                                            <button class="btn btn-primary btn-sm button-minus" type="button" onclick="decreaseValueB('#service_qty_{{ $item_service->id }}_x')"><i class="fas fa-minus"></i></button>
                                            <input class="form-control form-control-sm text-center" type="number" name="services_qty[{{ $item_service->id }}]" value="0" id="service_qty_{{ $item_service->id }}_x" step="1" min="0" max="{{ $session->qty }}" onchange="seleziona_servizio('{{ $item_service->id }}_x')">
                                            <button class="btn btn-primary btn-sm button-plus" type="button" onclick="increaseValueB('#service_qty_{{ $item_service->id }}_x')"><i class="fas fa-plus"></i></button>
                                        </div>

                                        @if($diff_days > 1)
                                            <label class="form-label">{{ @$labels['booking-riassume-n-notti'] }}</label>
                                            <div class="input-group">
                                                <button class="btn btn-primary btn-sm button-minus" type="button" onclick="decreaseValueB('#service_day_{{ $item_service->id }}_x')"><i class="fas fa-minus"></i></button>
                                                <input class="form-control form-control-sm text-center" type="number" name="services_day[{{ $item_service->id }}]" value="0" id="service_day_{{ $item_service->id }}_x" step="1" min="1" max="{{ $diff_days }}" onchange="seleziona_servizio('{{ $item_service->id }}_x')">
                                                <button class="btn btn-primary btn-sm button-plus" type="button" onclick="increaseValueB('#service_day_{{ $item_service->id }}_x')"><i class="fas fa-plus"></i></button>
                                            </div>
                                        @else
                                            <input type="hidden" name="services_day[{{ $item_service->id }}]" value="1">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </label>
                    @else
                        <input class="form-check-input" type="checkbox" name="services[]" value="{{ $item_service->id }}" id="service2_{{ $item_service->id }}">
                        <label class="form-check-label pointer d-flex flex-column h-100" for="service2_{{ $item_service->id }}">
                            <div class="service-gallery">
                                @if($item_service->photo)
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url($item_service->photo) }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @else
                                    <img loading="lazy" class="img-fluid mx-auto" src="{{ url("plugins/pluginProducts/no-image.jpg") }}" alt="{{ $item_service->name }}" width="360" height="420">
                                @endif
                            </div>
                            <div class="card-body flex-grow-1">
                                <h4 class="title">{{ $item_service->name }}</h4>
                                <div class="description">{!! $item_service->description !!}</div>
                            </div>
                            <div class="card-footer pb-3 bg-transparent border-top-0 mt-auto">
                                <div class="row align-items-end">
                                    <div class="col col-sm-12 col-md">
                                        <div class="prices">
                                            <div class="prices line-height-sm">
                                                @if($item_service->price_2 != $item_service->price_1 && $item_service->price_2 != 0)
                                                    <del class="old-price" d-block>&euro; {{ number_format($item_service->price_1, 2, ",", ".") }}</del><ins class="new-price">&euro; {{ number_format($item_service->price_2, 2, ",", ".") }}</ins>
                                                @else
                                                    <ins class="new-price d-block">&euro; {{ number_format($item_service->price_1, 2, ",", ".") }}</ins>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto col-sm-12 col-md-auto">
                                        <span class="btn btn-primary line-height-sm w-100">{{ @$labels['booking-offers-seleziona'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endif
                </div>
            </div>
        @endforeach
        </div>
    @else
        <div class="alert alert-danger d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div>{{ @$labels['booking-offers-no-disponibile'] }}</div>
        </div>
    @endif
    <div class="mt-4">
        <button class="btn btn-success btn-lg text-white width-lg-auto width-100" onclick="carica_checkout()" type="button">{{ @$labels['booking-continua'] }} <i class="bi bi-arrow-right"></i></button>
    </div>
</form>


