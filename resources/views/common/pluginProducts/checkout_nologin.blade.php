<?php
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
$symbol = "&euro;";
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
    $symbol = "&#36;";
}
if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
    $symbol = "&euro;";
}
?>
<main>
    <section class="section-page-header bg-light py-4 border-bottom">
        <div class="container">
            <h2 class="h3 my-0">{{ @$labels['shop-completa-acquisto'] }}</h2>
        </div>
    </section>
    @php
        $tot = 0;
        $totShip = 0;
        $totNoTax = 0;
    @endphp

    @foreach ($cart as $item)
        @php
            $productTotal = $item->price * $item->qty;
            $tot = $tot + $productTotal;
        @endphp
    @endforeach

    <form method="post" action="{{ route('save.order_new') }}" id="form">
        {{ csrf_field() }}

        <section class="py-4">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <main class="col-12 col-lg-8 order-2 order-lg-1">
                        <div class="card-step">
                            <h5 class="mb-3">{{ @$labels['shop-checkout-nologin-gia-cliente'] }}</h5>
                            <div class="form-group">
                                <a class="btn btn-primary btn-block btn-auto" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif href="{{ url('/login') }}">
                                    <span class="d-block">{{ @$labels['shop-checkout-nologin-accedi'] }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-step">

                            <h5 class="mb-3">{{ @$labels['shop-checkout-tipo-cliente'] }}</h5>
                            <div class="form-group">
                                <select class="custom-select" name="type_client" id="type_client">
                                    <option value=""></option>
                                    <option value="0">{{ @$labels['shop-checkout-privato'] }}</option>
                                    <option value="1">{{ @$labels['shop-checkout-azienda'] }}</option>
                                </select>
                            </div>


                            <h5 class="mb-3">{{ @$labels['shop-indirizzo-spedizione'] }}</h5>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">{{ @$labels['shop-email-nologin'] }}</label>
                                        <input type="email" class="form-control" name="email_access" id="email_access" data-cons-subject="email" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ @$labels['shop-checkout-nome'] }}</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" data-cons-subject="first_name" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="last_name">{{ @$labels['shop-checkout-cognome'] }}</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" data-cons-subject="last_name"  required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country_id">{{ @$labels['shop-checkout-nazione'] }}</label>
                                <div class="form-select-container">
                                    <select class="form-control select2" name="country_id" id="country_id" onchange="change_country('country_id')" autocomplete="nope" required>
                                        <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                        @if($countries)
                                            @foreach ($countries as $country)
                                                @if($country->id == old('country_id'))
                                                    <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                                @else
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="box_province">
                                <label id="province">{{ @$labels['shop-provincia'] }}</label>
                                <div class="form-select-container">
                                    <select name="province" id="provinceSel" class="custom-select select2" onchange="change_province('provinceSel')" autocomplete="nope">
                                        <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                        @foreach ($cities as $city)
                                            @php
                                                $selected = '';
                                                if(old('province') == $city->sigla_provincia){
                                                    $selected = 'selected';
                                                }
                                            @endphp
                                            <option value="{{ $city->sigla_provincia }}" {{ $selected }}>{{ $city->sigla_provincia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div id="box_city_temp"></div>
                            <div id="box_city"></div>
                            <div id="box_city_edit"></div>

                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="address">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                        <input type="text" class="form-control" name="address" id="address" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="number_street">{{ @$labels['shop-checkout-civico'] }}</label>
                                        <input type="text" class="form-control" name="number_street" id="number_street" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ @$labels['shop-checkout-telefono'] }}</label>
                                        <input type="text" class="form-control" name="mobile_phone" id="mobile_phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ @$labels['shop-checkout-note-spedizione'] }}</label>
                                        <textarea class="form-control" id="comment" name="comment"></textarea>
                                    </div>
                                </div>
                            </div>

                            @include('common.pluginProducts.partials.checkout.custom_fields_shipping')




                        </div>

                        <br><br>

                        <div class="card-step">


                            <!--<div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fattura_si">
                                    <label class="custom-control-label" for="fattura_si">{{ @$labels['shop-indirizzo-spedizione-diverso'] }}</label>
                                </div>
                            </div> -->

                            <div id="campi_aggiuntivi_fatturazione_privato"></div>

                            <div id="fatturazione">
                                <h5 class="mb-3">{{ @$labels['shop-indirizzo-fatturazione-no-login'] }}</h5>

                                <div class="form-group">
                                    <label for="first_name_2">{{ @$labels['shop-checkout-nominativo'] }}</label>
                                    <input type="text" class="form-control" name="name" id="name" value="" required>
                                </div>

                                <div id="box_azienda">
                                    <div class="form-group">
                                        <label for="first_name_2">{{ @$labels['shop-checkout-ragione-sociale'] }}</label>
                                        <input type="text" class="form-control" name="business_name" id="business_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">{{ @$labels['shop-checkout-pec'] }}</label>
                                        <input type="text" class="form-control" id="pec" name="pec">
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">{{ @$labels['shop-checkout-sdi'] }}</label>
                                        <input type="text" class="form-control" id="sdi" name="sdi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile">{{ @$labels['shop-checkout-piva-codfis'] }}</label>
                                    <input type="text" class="form-control" id="fiscal_code_vat" name="fiscal_code_vat" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ @$labels['shop-checkout-nazione'] }}</label>
                                    <div class="form-select-container">
                                        <select class="form-control select2 required-if-show-address" name="country_id_fatt" id="country_id_fatt" required>
                                            <option value="">{{ @$labels['shop-seleziona'] }}</option>
                                            @if($countries)
                                                @foreach ($countries as $country)
                                                    @if($country->id == old('country_id_fatt'))
                                                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                                    @else
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ @$labels['shop-checkout-citta'] }}</label>
                                            <input type="text" class="form-control" name="city_fatt" id="city_fatt" required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>{{ @$labels['shop-checkout-provincia'] }}</label>
                                            <input type="text" class="form-control" name="province_fatt" id="province_fatt" required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>{{ @$labels['shop-checkout-cap'] }}</label>
                                            <input type="text" class="form-control" name="postal_code_fatt" id="postal_code_fatt">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="address">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                            <input type="text" class="form-control" name="address_fatt" id="address_fatt" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="number_street">{{ @$labels['shop-checkout-civico'] }}</label>
                                            <input type="text" class="form-control" name="number_street_fatt" id="number_street_fatt" required>
                                        </div>
                                    </div>
                                </div>

                                <div id="campi_aggiuntivi"></div>

                            </div>
                            <hr class="my-4">
                        </div>

                        <div class="card-step">
                            <div id="shippings"></div>
                            <hr class="my-4">
                        </div>

                       <div class="card-step">
                            <div id="checkout_box_method_payments">
                                <h5 class="mb-3">{{ @$labels['shop-checkout-nologin-modalita-pagamento'] }}</h5>
                                @if($payments)
                                    <div class="list-methods">
                                        <div id="payment_method">
                                            @php $i = 0; @endphp
                                            @foreach ($payments as $payment)
                                                @php
                                                    $checked = '';
                                                    $active_class = '';
                                                    $class = 'is_not_contrassegno';

                                                    if($i == 0){
                                                        $checked = 'checked';
                                                        $active_class = 'active';
                                                    }
                                                    if($payment->is_contrassegno){
                                                        $class = 'is_contrassegno';
                                                    }
                                                    if($hasContrassegno == 0){
                                                        $class = '';
                                                    }

                                                    if($payment->name == "GiftCard"){
                                                        $class = 'gift_card';
                                                    }
                                                @endphp

                                                <label class="method-item card py-3 px-3 {{ $active_class }}" for="payment_id_{{ $i }}"  @if($payment->name == "GiftCard") id="giftcard_payment" @endif>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="payment_id" id="payment_id_{{ $i }}" value="{{ $payment->id }}" class="custom-control-input {{ $class }}" {{ $checked }} onchange="change_payment({{ $payment->id }})">
                                                        <span class="custom-control-label d-inline-block">{{ $payment->name }}</span>
                                                    </div>
                                                    <div class="method-description text-muted mt-2">{{ $payment->info }}</div>
                                                </label>

                                                @php $i++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- <button class="btn btn-primary btn-block btn-lg my-3">{{ @$labels['shop-checkout-acquista-ora'] }}</button> -->

                    </main> <!-- col.// -->

                    <aside class="col-12 col-lg-4 order-1 order-lg-2">

                        <div class="sticky-container">
                            <div class="sticky-element">
                                <div class="row">

                                    <div class="col-12 order-2 mb-3 mb-lg-3">
                                        <div class="card bg-light">
                                            <div class="card-header">
                                                <h5 class="my-0">{{ @$labels['shop-checkout-riepilogo-ordine'] }}</h5>
                                            </div>
                                            <div class="card-body summary-table">
                                                <table class="table table-sm my-0">
                                                    <tbody class="small">
                                                    @php
                                                        $tot = 0;
                                                        $totShip = 0;
                                                        $totNoTax = 0;
                                                        $v_tax = [];
                                                    @endphp

                                                    @foreach ($cart as $item)
                                                        @php
                                                            $product = \App\Models\PluginProducts::with("tax")->find($item->product_id);
                                                            $productTotal = $item->price * $item->qty;

                                                            $vat = $product->tax ? $product->tax->value : 22;
                                                            $vat_calculate = ($vat / 100) + 1;
                                                            $v_tax[$vat] = 0;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                @if(trim($product->custom_1) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_1 }}; font-size: 10px; color:white; padding:3px;">{{ $product->custom_1 }}</label> @endif
                                                                @if(trim($product->custom_2) != "") <label class="product-label" style="background-color: {{ $shopSetting->custom_color_2 }}; font-size: 10px; color:white; padding:3px;">{{ $product->custom_2 }}</label> @endif
                                                                <br>
                                                                {{ $product->name }}
                                                                <strong>x {{ $item->qty }}</strong>
                                                                    @if(property_exists($item, "extra"))
                                                                        @if($item->extra)
                                                                            <br>
                                                                            @foreach($item->extra as $extra_id => $value)
                                                                                <?php
                                                                                $extra = \App\Models\ShopExtra::find($extra_id);
                                                                                ?>
                                                                                {{ $extra->name }}<br>
                                                                                <small>{{ $value }}</small>
                                                                            @endforeach
                                                                        @endif
                                                                    @endif
                                                            </td>
                                                            <td class="text-right" width="90">{!! $symbol !!}
                                                                @php
                                                                    echo number_format($productTotal,2, ',','.');
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $tot = $tot + $productTotal;
                                                            $totShip = $totShip + ($item->qty * $product->getShipPrice($item->price));
                                                            $prezzoNoIva = $productTotal / ((100+$product->tax->value)/100);

                                                            $v_tax[$vat] += $productTotal - $prezzoNoIva;

                                                            $totNoTax = $totNoTax + $prezzoNoIva;
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                                <table class="table table-sm my-0">
                                                    <tbody id="checkout_tbody">
                                                    @if(env('HIDE_TASSE') == 0)
                                                        <tr>
                                                            <th>{{ @$labels['shop-partials-tot-tasse-esc'] }}</th>
                                                            <td class="text-right">{!! $symbol !!} <span id="total_no_tax">{{ number_format(round($totNoTax, 2),2, ',','.') }}</span></td>
                                                        </tr>

                                                        @if($v_tax)
                                                            @foreach($v_tax as $k=>$v)
                                                                <tr>
                                                                    <th>{{ @$labels['shop-checkout-tasse'] }} <small>{{ (int) $k }}%</small></th>
                                                                    <td class="text-right">{!! $symbol !!} <span id="sum_tax">@php echo number_format(round($v,2),2, ',','.'); @endphp</span></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                    @php
                                                        $tot = $tot;
                                                    @endphp

                                                    <tr id="discount_coupon"></tr>
                                                    <tr id="shipping_view"></tr>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr class="text-danger">
                                                        <th>{{ @$labels['shop-checkout-totale'] }}</th>
                                                        <td  class="text-right">{!! $symbol !!} <span id="total_view">{{ number_format(round($tot, 2),2, ',','.') }}</span>
                                                            <input type="hidden" id="total_product" name="total_product" value="{{ (float) $tot }}">
                                                            <input type="hidden" name="total" id="total" value="{{ (float) $tot }}">
                                                            <input type="hidden" name="total_ship" id="total_ship" value="0">
                                                            <input type="hidden" name="total_extra" id="total_extra" value="0">
                                                            <input type="hidden" name="total_coupon" id="total_coupon" value="0">
                                                            <input type="hidden" name="total_gift" id="total_gift" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr id="giftcard" class="text-danger"></tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- <div class="mt-3">
                                            <label>{{ @$labels['shop-checkout-note-ordine'] }}</label>
                                            <textarea name="note" class="form-control"></textarea>
                                        </div> -->

                                        <div class="card-step">
                                            <!-- <h5 class="mb-3">{{ @$labels['shop-checkout-coupon'] }}</h5> -->
                                            <div class="mt-4" id="box_coupon">
                                                <h6>{{ @$labels['shop-checkout-hai-coupon'] }}</h6>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="{{ @$labels['shop-checkout-inserisci-coupon'] }}" name="code_coupon" id="code_coupon" autocomplete="off">
                                                    <div class="input-group-append" id="button_coupon">
                                                        <button class="btn btn-primary" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif id="check_code_coupon" type="button" onclick="set_coupon()">{{ @$labels['shop-checkout-applica'] }}</button>
                                                    </div>
                                                </div>
                                                <div id="result_code_coupon"></div>
                                            </div>
                                        </div>

                                        <br>

                                        <small class="privacy-text">{{ @$labels['shop-checkout-privacy'] }}</small>
                                        @if($shopSetting->url_condition)
                                            <small><a href="{{ $shopSetting->url_condition }}" target="_blank">{{ @$labels['shop-checkout-condizioni'] }}</a></small>
                                        @else
                                            @if($website->iubenda_termini)
                                                {!! $website->iubenda_termini !!}
                                            @endif
                                        @endif


                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check_condition" name="check_condition" value="1" data-cons-preference="term" required>
                                                <label class="custom-control-label" for="check_condition">{{ @$labels['shop-checkout-condition-check'] }}</label>
                                            </div>
                                        </div>

                                        <p class="privacy-text">{{ @$labels['shop-registrati-letto-privacy'] }}
                                            @if($shopSetting->url_privacy)
                                                <small><a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a></small>
                                            @else
                                                @if($website->iubenda_privacy)
                                                    {!! $website->iubenda_privacy !!}
                                                @endif
                                            @endif
                                        </p>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check_privacy_1" name="check_privacy" value="1" data-cons-preference="privacy" required>
                                                <label class="custom-control-label" for="check_privacy_1">{{ @$labels['shop-registrati-privacy'] }}</label>
                                            </div>
                                        </div>

                                        <p class="privacy-text">{{ @$labels['shop-registrati-info-4'] }}
                                            @if($shopSetting->url_privacy)
                                                <small><a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a></small>
                                            @else
                                                @if($website->iubenda_privacy)
                                                    {!! $website->iubenda_privacy !!}
                                                @endif
                                            @endif
                                        </p>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check_newsletter" name="check_newsletter" data-cons-preference="newsletter" value="1">
                                                <label class="custom-control-label" for="check_newsletter">{{ @$labels['shop-registrati-newsletter'] }}</label>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary btn-block btn-lg my-3" id="submit_button" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif >{{ @$labels['shop-checkout-acquista-ora'] }}</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </aside>
                </div>

            </div>
        </section>

    </form>
</main>

@section('after_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#box_azienda").hide();

            var token = '{{ csrf_token() }}';
            /*$.ajax({
                type: 'POST',
                url: '{{ route('ajax.checkout.get_fields_custom_checkout') }}',
                data: 'value=0&_token=' + token,
                success: function (data) {
                    $("#campi_aggiuntivi").html(data);
                },
                error: function() {}
            });*/

            $("#box_province").hide();
            $("#provinceSel").removeAttr("required-if-show");

            $("#box_province_new_address").hide();
            $("#provinceSel2").removeAttr("required-if-show-address");
            $("#box_city_new_address").html("<div class=\"row\"><div class=\"col-8\"><div class=\"form-group\"><input type=\"hidden\" class=\"form-control\" name=\"province_2\" id=\"province_2\" value=\"\"><label for=\"city_id\">Città *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"city_id_2\" id=\"city_id_2\" value=\"\"></div></div><div class=\"col-4\"><div class=\"form-group\"><label for=\"zip_2\">CAP *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"zip_2\" id=\"zip_2\" value=\"\"></div></div></div>");

            $("#country_id").val("106").trigger('change');
            $("#fatturazione").hide();
            $('#name').attr('required', 'false');
            $('#fiscal_code_vat').attr('required', 'false');
            $('#city_fatt').attr('required', 'false');
            $('#province_fatt').attr('required', 'false');
            $('#address_fatt').attr('required', 'false');
            $('#number_street_fatt').attr('required', 'false');
            $('#business_name').attr('required', 'false');
            $('#country_id_fatt').attr('required', 'false');

            $('#name').attr('disabled', 'true');
            $('#fiscal_code_vat').attr('disabled', 'true');
            $('#city_fatt').attr('disabled', 'true');
            $('#province_fatt').attr('disabled', 'true');
            $('#address_fatt').attr('disabled', 'true');
            $('#number_street_fatt').attr('disabled', 'true');
            $('#business_name').attr('disabled', 'true');
            $('#country_id_fatt').attr('disabled', 'true');

            $('#type_client').change(function(){
                /*var value = $(this).val();
                if( value == 0 ){
                    $("#box_azienda").hide();
                    $('#business_name').removeAttr('required');
                    $('#fiscal_code_vat').removeAttr('required');
                } else {
                    $("#box_azienda").show();
                    $('#business_name').attr('required', 'true');
                    $('#fiscal_code_vat').attr('required', 'true');
                }*/

                var value = $(this).val();
                if( value == 0 ){
                    $("#box_azienda").hide();
                    $('#business_name').removeAttr('required');
                    $('#fiscal_code_vat').removeAttr('required');
                } else {
                    $("#box_azienda").show();
                    $('#business_name').attr('required', 'true');
                    $('#fiscal_code_vat').attr('required', 'true');
                }

                $("#campi_aggiuntivi_fatturazione_privato").html("");
                $("#campi_aggiuntivi").html("");

                var token = '{{ csrf_token() }}';
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.checkout.get_fields_custom_checkout') }}',
                    data: 'value='+value+'&_token=' + token,
                    success: function (data) {
                        if(value == 1){
                            $("#campi_aggiuntivi").html(data);
                        }else{
                            $("#campi_aggiuntivi_fatturazione_privato").html(data);
                        }

                    },
                    error: function() {}
                });
            });

            $('#type_client').change(function(){
                var value = $(this).val();

                if(value == 1){
                    $("#campi_aggiuntivi_fatturazione_privato").hide();
                    $("#fatturazione").show();
                }else{
                    $("#campi_aggiuntivi_fatturazione_privato").show();
                    $("#fatturazione").hide();
                }

                if($('#fatturazione').is(':visible')){
                    $('#type_client').attr('required', 'true');
                    $('#name').attr('required', 'true');
                    $('#fiscal_code_vat').attr('required', 'true');
                    $('#city_fatt').attr('required', 'true');
                    $('#province_fatt').attr('required', 'true');
                    $('#address_fatt').attr('required', 'true');
                    $('#number_street_fatt').attr('required', 'true');

                    $('#name').removeAttr('disabled');
                    $('#fiscal_code_vat').removeAttr('disabled');
                    $('#city_fatt').removeAttr('disabled');
                    $('#province_fatt').removeAttr('disabled');
                    $('#address_fatt').removeAttr('disabled');
                    $('#number_street_fatt').removeAttr('disabled');
                    $('#business_name').removeAttr('disabled');
                    $('#country_id_fatt').removeAttr('disabled');
                }else{
                    $('#campi_aggiuntivi').html("");
                    $('#type_client').attr('required', 'false');
                    $('#name').attr('required', 'false');
                    $('#fiscal_code_vat').attr('required', 'false');
                    $('#city_fatt').attr('required', 'false');
                    $('#province_fatt').attr('required', 'false');
                    $('#address_fatt').attr('required', 'false');
                    $('#number_street_fatt').attr('required', 'false');
                    $('#business_name').attr('required', 'false');
                    $('#country_id_fatt').attr('required', 'false');

                    $('#name').attr('disabled', 'true');
                    $('#fiscal_code_vat').attr('disabled', 'true');
                    $('#city_fatt').attr('disabled', 'true');
                    $('#province_fatt').attr('disabled', 'true');
                    $('#address_fatt').attr('disabled', 'true');
                    $('#number_street_fatt').attr('disabled', 'true');
                    $('#business_name').attr('disabled', 'true');
                    $('#country_id_fatt').attr('disabled', 'true');
                }
            });
        });
    </script>
@endsection
