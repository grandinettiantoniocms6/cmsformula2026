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
<?php
$website = \App\Models\WebsiteSetting::first();
?>

<section class="border-top border-bottom py-3 py-sm-4">
    <div class="container">
        <h1 class="page-title font-2xl my-0">{{ @$labels['shop-completa-acquisto'] }}</h1>
    </div>
</section>

<section class="page-checkout py-4 py-lg-5">
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
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="style-danger my-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="mb-3 mb-lg-5 alert alert-info">{{ @$labels['shop-checkout-nologin-gia-cliente'] }} <a href="{{ url('/login') }}" title="{{ @$labels['shop-checkout-nologin-accedi'] }}">{{ @$labels['shop-checkout-nologin-accedi'] }}</a></h6>
                    <hr style="width=90%; margin: 25px 0 25px 0; border-style: inset; border-width: 1px;">
                    <h5 class="mb-3 mb-lg-5">{{ @$labels['shop-non-sei-ancora-registrato'] }}</h5>
                    <div class="card-step">
                        <h5>{{ @$labels['shop-checkout-tipo-cliente'] }}</h5>
                        <div class="form-group">
                            <select class="form-select" name="type_client" id="type_client">
                                <option value="0" >{{ @$labels['shop-checkout-privato'] }}</option>
                                <option value="1">{{ @$labels['shop-checkout-azienda'] }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-step">
                        <h5>{{ @$labels['shop-indirizzo-spedizione'] }}</h5>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-email-nologin'] }}</label>
                                    <input type="email" class="form-control" name="email_access" id="email_access" data-cons-subject="email" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-telefono'] }}</label>
                                    <input type="text" class="form-control" name="mobile_phone" id="mobile_phone" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-nome'] }}</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" data-cons-subject="first_name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-cognome'] }}</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" data-cons-subject="last_name"  required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-nazione'] }}</label>
                                    <div class="form-select-container">
                                        <select class="form-select" name="country_id" id="country_id" onchange="change_country('country_id')" autocomplete="nope" required>
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
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" id="box_province">
                                    <label class="form-label">{{ @$labels['shop-provincia'] }}</label>
                                    <div class="form-select-container">
                                        <select name="province" id="provinceSel" class="form-select" onchange="change_province('provinceSel')" autocomplete="nope">
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
                            </div>
                        </div>

                        <div id="box_city_temp"></div>
                        <div id="box_city"></div>
                        <div id="box_city_edit"></div>

                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                    <input type="text" class="form-control" name="address" id="address" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-civico'] }}</label>
                                    <input type="text" class="form-control" name="number_street" id="number_street" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ @$labels['shop-checkout-note-spedizione'] }}</label>
                            <textarea class="form-control" id="comment" name="comment"></textarea>
                        </div>

                        @include("$thema.plugins.pluginProducts.v3.partials.checkout.custom_fields_shipping")
                    </div>

                    <div class="card-step">
                        <div id="campi_aggiuntivi_fatturazione_privato"></div>
                        <div id="fatturazione">
                            <h5>{{ @$labels['shop-indirizzo-fatturazione-no-login'] }}</h5>

                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-checkout-nominativo'] }}</label>
                                <input type="text" class="form-control" name="name" id="name" value="" required>
                            </div>

                            <div id="box_azienda">
                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-ragione-sociale'] }}</label>
                                    <input type="text" class="form-control" name="business_name" id="business_name" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-pec'] }}</label>
                                    <input type="text" class="form-control" id="pec" name="pec">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{ @$labels['shop-checkout-sdi'] }}</label>
                                    <input type="text" class="form-control" id="sdi" name="sdi">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-checkout-piva-codfis'] }}</label>
                                <input type="text" class="form-control" id="fiscal_code_vat" name="fiscal_code_vat" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ @$labels['shop-checkout-nazione'] }}</label>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ @$labels['shop-checkout-citta'] }}</label>
                                        <input type="text" class="form-control" name="city_fatt" id="city_fatt" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ @$labels['shop-checkout-provincia'] }}</label>
                                        <input type="text" class="form-control" name="province_fatt" id="province_fatt" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ @$labels['shop-checkout-cap'] }}</label>
                                        <input type="text" class="form-control" name="postal_code_fatt" id="postal_code_fatt">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="form-label">{{ @$labels['shop-checkout-indirizzo'] }}</label>
                                        <input type="text" class="form-control" name="address_fatt" id="address_fatt" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ @$labels['shop-checkout-civico'] }}</label>
                                        <input type="text" class="form-control" name="number_street_fatt" id="number_street_fatt" required>
                                    </div>
                                </div>
                            </div>

                            <div id="campi_aggiuntivi"></div>
                        </div>
                    </div>


                    @if($contSub > 0)
                        <div class="card-step" id="subscriptions">
                            @for($i=1; $i<=$contSub;$i++)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ @$labels['shop-name-checkout-subscriptions'] }} n.{{ $i }}</label>
                                            <input type="text" class="form-control" name="subscriptions_name[]" required>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @endif


                    <div class="card-step" id="shippings"></div>

                    <div id="checkout_box_method_payments" class="card-step">
                        <h5>{{ @$labels['shop-checkout-nologin-modalita-pagamento'] }}</h5>
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

                                        <div class="form-check card-check">
                                            <input type="radio" name="payment_id" id="payment_id_{{ $i }}" value="{{ $payment->id }}" class="form-check-input {{ $class }}" {{ $checked }} onchange="change_payment({{ $payment->id }})">
                                            <label class="card card-body {{ $active_class }}" for="payment_id_{{ $i }}" @if($payment->name == "GiftCard") id="giftcard_payment" @endif>
                                                <h6 class="mb-1">{{ $payment->name }}</h6>
                                                <div class="text-muted font-sm">{{ $payment->info }}</div>
                                            </label>
                                        </div>

                                        @php $i++; @endphp
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <aside class="col-lg-4">
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5>{{ @$labels['shop-checkout-riepilogo-ordine'] }}</h5>

                            <table class="table table-sm table-cart-summary font-sm">
                                <tbody>
                                @php
                                    $tot = 0;
                                    $totShip = 0;
                                    $totNoTax = 0;
                                    $v_tax = [];
                                     foreach ($cart as $item){
                                        $product = \App\Models\PluginProducts::find($item->product_id);
                                        if(!$product){
                                            continue;
                                        }

                                        $vat = $product->tax ? $product->tax->value : 22;
                                        $vat_calculate = ($vat / 100) + 1;
                                        $v_tax[$vat] = 0;
                                    }
                                @endphp

                                @foreach ($cart as $item)
                                    @php
                                        $product = \App\Models\PluginProducts::with("tax")->find($item->product_id);
                                        $productTotal = $item->price * $item->qty;

                                        $vat = $product->tax ? $product->tax->value : 22;
                                        $vat_calculate = ($vat / 100) + 1;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-bold line-height-md">
                                                {{ $product->name }}
                                                @if(trim($product->custom_1) != "") <label class="product-label product-label-custom-color-1">{{ $product->custom_1 }}</label> @endif
                                                @if(trim($product->custom_2) != "") <label class="product-label product-label-custom-color-2">{{ $product->custom_2 }}</label> @endif
                                            </div>
                                            <strong>x {{ $item->qty }}</strong>
                                            @if(property_exists($item, "extra"))
                                                @if($item->extra)
                                                    <div class="extra">
                                                    @foreach($item->extra as $extra_id => $value)
                                                        <?php $extra = \App\Models\ShopExtra::find($extra_id); ?>
                                                        <div>{{ $extra->name }}</div>
                                                        <small>{{ $value }}</small>
                                                    @endforeach
                                                    </div>
                                                @endif
                                            @endif

                                            @if(property_exists($item, "message"))
                                                <div class="extra">
                                                    <div><em>Messaggio:</em> {{ $item->message }}</div>
                                                </div>
                                            @endif

                                            @if(property_exists($item, "file"))
                                                <div class="extra">
                                                    <div><em>File:</em> <a href="{{ url("uploads/$item->file") }}" target="_blank">Vedi</a> </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{!! $symbol !!} <?php echo number_format($productTotal,2, ',','.'); ?></td>
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
                                <tbody id="checkout_tbody">
                                @if(env('HIDE_TASSE') == 0)
                                    <tr>
                                        <td>{{ @$labels['shop-partials-tot-tasse-esc'] }}</td>
                                        <td>{!! $symbol !!} <span id="total_no_tax">{{ number_format(round($totNoTax, 2),2, ',','.') }}</span></td>
                                    </tr>

                                    @if($v_tax)
                                        @foreach($v_tax as $k=>$v)
                                            <tr>
                                                <td>{{ @$labels['shop-checkout-tasse'] }} <small>{{ (int) $k }}%</small></td>
                                                <td>{!! $symbol !!} <span id="sum_tax">@php echo number_format(round($v,2),2, ',','.'); @endphp</span></td>
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
                                <tbody>
                                    <tr class="text-danger">
                                        <td>{{ @$labels['shop-checkout-totale'] }}</td>
                                        <td>{!! $symbol !!} <span id="total_view">{{ number_format(round($tot, 2),2, ',','.') }}</span>
                                            <input type="hidden" id="total_product" name="total_product" value="{{ (float) $tot }}">
                                            <input type="hidden" name="total" id="total" value="{{ (float) $tot }}">
                                            <input type="hidden" name="total_ship" id="total_ship" value="0">
                                            <input type="hidden" name="total_extra" id="total_extra" value="0">
                                            <input type="hidden" name="total_coupon" id="total_coupon" value="0">
                                            <input type="hidden" name="total_gift" id="total_gift" value="0">
                                        </td>
                                    </tr>
                                    <tr id="giftcard" class="text-danger"></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-step" id="box_coupon">
                        <h6>{{ @$labels['shop-checkout-hai-coupon'] }}</h6>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ @$labels['shop-checkout-inserisci-coupon'] }}" name="code_coupon" id="code_coupon" autocomplete="off">
                            <div id="button_coupon">
                                <button class="btn btn-primary" id="check_code_coupon" type="button" onclick="set_coupon()">{{ @$labels['shop-checkout-applica'] }}</button>
                            </div>
                        </div>
                        <div id="result_code_coupon"></div>
                    </div>

                    <div class="card-privacy mb-3">
                        <p class="font-sm">
                            {{ @$labels['shop-checkout-privacy'] }}
                            @if($shopSetting->url_condition)
                                <small><a href="{{ $shopSetting->url_condition }}" target="_blank">{{ @$labels['shop-checkout-condizioni'] }}</a></small>
                            @else
                                @if($website->iubenda_termini)
                                    {!! $website->iubenda_termini !!}
                                @endif
                            @endif
                        </p>

                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="check_condition" name="check_condition" value="1" data-cons-preference="term" required>
                            <label class="form-check-label" for="check_condition">{{ @$labels['shop-checkout-condition-check'] }}</label>
                        </div>
                    </div>

                    <div class="card-privacy mb-3">
                        <p class="font-sm">
                            {{ @$labels['shop-registrati-letto-privacy'] }}
                            @if($shopSetting->url_privacy)
                                <small><a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a></small>
                            @else

                                @if($website->iubenda_privacy)
                                    {!! $website->iubenda_privacy !!}
                                @endif
                            @endif
                        </p>

                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="check_privacy_1" name="check_privacy" value="1" data-cons-preference="privacy" required>
                            <label class="form-check-label" for="check_privacy_1">{{ @$labels['shop-registrati-privacy'] }}</label>
                        </div>
                    </div>

                    <div class="card-privacy mb-3">
                        <p class="font-sm">
                            {{ @$labels['shop-registrati-info-4'] }}
                            @if($shopSetting->url_privacy)
                                <small><a href="{{ $shopSetting->url_privacy }}" target="_blank">Privacy</a></small>
                            @else

                                @if($website->iubenda_privacy)
                                    {!! $website->iubenda_privacy !!}
                                @endif
                            @endif
                        </p>

                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="check_newsletter" name="check_newsletter" data-cons-preference="newsletter" value="1">
                            <label class="form-check-label" for="check_newsletter">{{ @$labels['shop-registrati-newsletter'] }}</label>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-lg w-100 my-3" id="submit_button">{{ @$labels['shop-checkout-acquista-ora'] }}</button>
                </aside>
            </div>
        </div>
    </form>
</section>

@section('after_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#box_azienda").hide();

            var token = '{{ csrf_token() }}';
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
