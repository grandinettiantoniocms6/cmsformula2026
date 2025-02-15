<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
$setting = \App\Models\PluginBookingSettings::first();
?>
<?php
$payments = \App\Models\PluginBookingPayments::where("is_active", 1)->get();
$user = \App\User::find(\Session::get('user_id'));
?>
@if($type->can_payment == 1 && $payments)
<form id="booking-form" method="post" action="{{ route('pluginBooking.save_order.it') }}" class="card bg-light">
    {{ csrf_field() }}

    <div class="p-4 p-md-5">
        <h4 class="text-center mb-4">{{ @$labels['booking-inserisci-nota'] }}</h4>
        <div class="form-group">
            <label>{{ @$labels['booking-descrizione-nota'] }}</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

    </div>

    <div class="p-4 p-md-5">
        <?php
          $i = 1;
        ?>
        <h4 class="text-center mb-4">{{ @$labels['booking-payment-title'] }}</h4>
        <div class="card card-payment bg-transparent">
            @foreach($payments as $payment)
                <div class="mb-1">
                    <input type="radio" name="payment_id" id="payment_{{ $payment->id }}" value="{{ $payment->id }}" class="form-check-input" @if($i == 1) checked @endif>
                    <label class="form-check-label rounded w-100 bg-white" for="payment_{{ $payment->id }}">
                        <h5>{{ $payment->name }}</h5>
                        {!! $payment->description !!}
                    </label>
                </div>

                    <?php
                    $i++;
                    ?>
            @endforeach
        </div>

        @if($setting->want_invoice)
            <div class="form-group">
                <a href="javascript:box_invoice()">{{ @$labels['booking-serve-fattura'] }}</a>
            </div>

            <div id="box_invoice" class="d-none">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-ragione-sociale'] }}</label>
                            <input type="text" class="form-control" id="business_name" name="business_name" placeholder="" value="{{ old('business_name', $user->business_name) }}">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-vat'] }}</label>
                            <input type="text" class="form-control" id="vat" name="vat" placeholder="" value="{{ old('vat', $user->vat) }}">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-pec'] }}</label>
                            <input type="text" class="form-control" id="pec" name="pec" placeholder="" value="{{ old('pec', $user->pec) }}">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-sdi'] }}</label>
                            <input type="text" class="form-control" id="sdi" name="sdi" placeholder="" value="{{ old('sdi', $user->sdi) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-address'] }}</label>
                            <input type="text" class="form-control" id="address_invoice" name="address_invoice" placeholder="" value="{{ old('address_invoice', $user->address_invoice) }}">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-street'] }}</label>
                            <input type="text" class="form-control" id="street_invoice" name="street_invoice" placeholder="" value="{{ old('street_invoice', $user->street_invoice) }}">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-zip'] }}</label>
                            <input type="text" class="form-control" id="zip_invoice" name="zip_invoice" placeholder="" value="{{ old('zip_invoice', $user->zip_invoice) }}">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-city'] }}</label>
                            <input type="text" class="form-control" id="city_invoice" name="city_invoice" placeholder="" value="{{ old('city_invoice', $user->city_invoice) }}">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-province'] }}</label>
                            <input type="text" class="form-control" id="province_invoice" name="province_invoice" placeholder="" value="{{ old('province_invoice', $user->province_invoice) }}">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label">{{ @$labels['booking-invoice-state'] }}</label>
                            <input type="text" class="form-control" id="state_invoice" name="state_invoice" placeholder="" value="{{ old('state_invoice', $user->state_invoice) }}">
                        </div>
                    </div>
                </div>

            </div>

        @endif

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-primary w-100" name="button"><i class="bi bi-box-arrow-in-left"></i> {{ @$labels['booking-payment-acquista-prenota'] }}</button>
        </div>
    </div>
</form>

@else
    <form id="booking-form" method="post" action="{{ route('pluginBooking.save_order.it') }}" class="card bg-light">
        {{ csrf_field() }}
        <div class="p-4 p-md-5">
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary w-100" name="button"><i class="bi bi-box-arrow-in-left"></i> {{ @$labels['booking-payment-prenota'] }}</button>
            </div>
        </div>
    </form>
@endif

