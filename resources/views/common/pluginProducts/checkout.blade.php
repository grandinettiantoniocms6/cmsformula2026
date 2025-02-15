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
    <div class="modal fade" id="modal-nuovo-indirizzo-spedizione" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ @$labels['shop-indirizzo-spedizione'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new_address" name="new_address" action="{{ route('ajax.checkout.new_address_checkout') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="first_name">{{ @$labels['shop-checkout-nome'] }}</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="last_name">{{ @$labels['shop-checkout-cognome'] }}</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country_id">{{ @$labels['shop-checkout-nazione'] }}</label>
                            <div class="form-select-container">
                                <select class="custom-select select2" name="country_id" id="country_id" onchange="change_country('country_id')" autocomplete="nope" required>
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

                        <button type="submit" class="btn btn-block btn-primary" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-checkout-salva-indirizzo'] }}</button>
                        <br>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-nuovo-indirizzo-fatturazione" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ @$labels['shop-checkout-dati-fatturazione'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new_fatturazione" name="new_fatturazione" action="{{ route('ajax.checkout.new_fatturazione_checkout') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="first_name_2">{{ @$labels['shop-checkout-nominativo'] }}</label>
                            <input type="text" class="form-control" name="name" id="name" value="" required>
                        </div>

                        <div class="form-group">
                            <label for="business_name">{{ @$labels['shop-checkout-tipo-cliente'] }}</label>
                            <select class="custom-select" name="type_client" id="type_client">
                                <option value="0">{{ @$labels['shop-checkout-privato'] }}</option>
                                <option value="1">{{ @$labels['shop-checkout-azienda'] }}</option>
                            </select>
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
                                <select class="form-control select2 required-if-show-address" name="country_id" id="country_id_fatt" required>
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

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>{{ @$labels['shop-checkout-citta'] }}</label>
                                    <input type="text" class="form-control" name="city" id="city" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>{{ @$labels['shop-checkout-provincia'] }}</label>
                                    <input type="text" class="form-control" name="province" id="province" required>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label>{{ @$labels['shop-checkout-cap'] }}</label>
                                    <input type="text" class="form-control" name="postal_code" id="postal_code" required>
                                </div>
                            </div>
                        </div>

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

                        <div id="campi_aggiuntivi"></div>

                        <button type="submit" class="btn btn-block btn-primary" @if($website->btn_background) style="background-color: {{ $website->btn_background }}" @endif>{{ @$labels['shop-checkout-salva-indirizzo'] }}</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <form method="post" action="{{ route('save.order_new') }}" id="form-checkout">
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
                            <div id="checkout_box_shippings"></div>
                            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modal-nuovo-indirizzo-spedizione" onclick="clearModalAddress();">{{ @$labels['shop-checkout-aggiungi-nuovo-indirizzo'] }}</button>
                            <hr class="my-4">
                        </div>

                        <div class="card-step">
                            <div id="checkout_box_fatturazione"></div>
                            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modal-nuovo-indirizzo-fatturazione" onclick="clearModalCompany();">{{ @$labels['shop-checkout-aggiungi-nuovo-indirizzo-fatt'] }}</button>
                            <hr class="my-4">
                        </div>

                        <div class="card-step">
                            <div id="checkout_box_method_shippings"></div>
                            <hr class="my-4">
                        </div>



                        <div class="card-step">
                            <div id="checkout_box_method_payments"></div>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg my-3">{{ @$labels['shop-checkout-acquista-ora'] }}</button>

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

                                        <!--<div class="mt-3">
                                            <label>{{ @$labels['shop-checkout-note-ordine'] }}</label>
                                            <textarea name="note" class="form-control"></textarea>
                                        </div>-->

                                        <div class="card-step">
                                            <!--<h5 class="mb-3">{{ @$labels['shop-checkout-coupon'] }}</h5>-->
                                            <div class="mt-4" id="box_coupon">
                                                <h6>{{ @$labels['shop-checkout-hai-coupon'] }}</h6>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="{{ @$labels['shop-checkout-inserisci-coupon'] }}" name="code_coupon" id="code_coupon" autocomplete="off">
                                                    <div class="input-group-append" id="button_coupon">
                                                       <button class="btn btn-primary" id="check_code_coupon" type="button" onclick="set_coupon()">{{ @$labels['shop-checkout-applica'] }}</button>
                                                    </div>
                                                </div>
                                                <div id="result_code_coupon"></div>
                                            </div>
                                        </div>

                                        <br>
                                        <!-- Link Condizioni di vendita e Privacy in CheckOut da loggato colonna dx -->
                                        <small class="privacy-text">{{ @$labels['shop-checkout-privacy'] }}</small>
                                        @if($shopSetting->url_condition)
                                           <a href="{{ $shopSetting->url_condition }}" target="_blank">{{ @$labels['shop-checkout-condizioni'] }}</a>
                                        @else
                                            @if($website->iubenda_termini)
                                                {!! $website->iubenda_termini !!}
                                            @endif
                                        @endif

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check_condition" name="check_condition" value="1" required>
                                                <label class="custom-control-label" for="check_condition">{{ @$labels['shop-checkout-condition-check'] }}</label>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary btn-block btn-lg my-3">{{ @$labels['shop-checkout-acquista-ora'] }}</button>
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
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_fields_custom_checkout') }}',
            data: 'value=0&_token=' + token,
            success: function (data) {
                $("#campi_aggiuntivi").html(data);
            },
            error: function() {}
        });

        $("#box_azienda").hide();
        $('#business_name').removeAttr('required');
        $('#fiscal_code_vat').removeAttr('required');

        $('#type_client').change(function(){
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

            $("#campi_aggiuntivi").html("");

            var token = '{{ csrf_token() }}';
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.checkout.get_fields_custom_checkout') }}',
                data: 'value='+value+'&_token=' + token,
                success: function (data) {
                    $("#campi_aggiuntivi").html(data);
                },
                error: function() {}
            });
        });

        $("#new_address").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $("#address_edit_id").remove();
                    $("#modal-nuovo-indirizzo-spedizione").modal('hide');
                    //$('#new_address').trigger("reset");
                    //$("#new_address #box_province").hide();
                    //$("#new_address #box_city").hide();
                    //$("#new_address #country_id").val(null).trigger('change');

                    if(data.address){
                        load_box_shippings(data.address.id);
                    }else{
                        load_box_shippings(0);
                    }

                    load_box_fatturazione(0);
                }
            });
        });

        $("#new_fatturazione").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $("#fatturazione_edit_id").remove();
                    $("#modal-nuovo-indirizzo-fatturazione").modal('hide');
                    $('#new_fatturazione').trigger("reset");
                    $("#new_fatturazione #country_id_fatt").val(null).trigger('change');

                    $("#box_azienda").hide();
                    $('#business_name').removeAttr('required');
                    $('#fiscal_code_vat').removeAttr('required');

                    if(data.address){
                        load_box_fatturazione(data.address.id);
                    }else{
                        load_box_fatturazione(0);
                    }
                }
            });
        });

        load_box_shippings(0);
        load_box_fatturazione(0);
    });

    function load_box_shippings(id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_box_shippings_checkout') }}',
            data: 'id='+id+'&_token=' + token,
            success: function (data) {
                $("#checkout_box_shippings").html(data.html);
                get_info_for_method_shippings($('input[name="address_id"]:checked').val());
            },
            error: function() {}
        });
    }

    function load_box_fatturazione(id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_box_fatturazione_checkout') }}',
            data: 'id='+id+'&_token=' + token,
            success: function (data) {
                $("#checkout_box_fatturazione").html(data.html);
                methodCheckRadioDisabled();
            },
            error: function() {}
        });
    }

    function load_box_payments(shipping_id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_box_payments_checkout') }}',
            data: 'shipping_id='+shipping_id+'&_token=' + token,
            success: function (data) {
                $("#checkout_box_method_payments").html(data.html);
                if(shipping_id == 4) { //contrassegno...
                    $('.is_not_contrassegno').prop('disabled', true);
                    $('.is_contrassegno').prop('disabled', false).prop('checked', true);
                    methodCheckRadioDisabled();
                } else {
                    $('.is_not_contrassegno').prop('disabled', false);
                    $('.is_not_contrassegno:first').prop('checked', true);
                    $('.is_contrassegno').prop('disabled', true);
                    methodCheckRadioDisabled();
                }
            },
            error: function() {}
        });
    }

    function clearModalAddress(){
        $("#address_edit_id").remove();
        $('#new_address').trigger("reset");
        $("#new_address #box_province").hide();
        $("#new_address #box_city").html("");
        $("#new_address #box_city_edit").html("");
        $("#new_address #box_city_temp").html("<div id='box_city'></div>");
        $("#new_address #country_id").val("106").trigger('change');
    }

    function clearModalCompany(){
        $("#fatturazione_edit_id").remove();
        $('#new_fatturazione').trigger("reset");
        $("#new_fatturazione #box_azienda").hide();
        $("#new_fatturazione #country_id_fatt").val(null).trigger('change');
    }

    function get_info_for_method_shippings(address_id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_info_for_method_shippings_checkout') }}',
            data: 'address_id='+address_id+'&_token=' + token,
            success: function (data) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get.shippings_by_cities') }}',
                    data: 'nazioneId='+data.address.country_id+'&id='+data.address.city_id+'&_token=' + token,
                    dataType: 'json',
                    success: function (data) {
                        $('#checkout_box_method_shippings').html(data.contents);
                        $('#total').val(data.total);
                        $('#total_no_tax').val(data.total_no_tax);
                        $('#sum_tax').val(data.sum_tax);
                        $('#total_ship').val(data.total_ship);

                        load_box_payments($('input[name="shipping_id"]:checked').val());

                        var sum_total = data.total + data.total_ship;
                        var sum_total_format = sum_total.toFixed(2).replace(".", ",");

                        var sum_total_ship = data.total_ship;
                        var sum_total_ship_format = sum_total_ship.toFixed(2).replace(".", ",");

                        $('#total_view').html(sum_total_format);
                        $('#shipping_view').html('<th>Spedizione</th><td class="text-right">€ ' + sum_total_ship_format + '</td>');
                    },
                    error: function(){}
                });
            },
            error: function() {}
        });
    }

    function change_radio_fatturazione(){
        methodCheckRadioDisabled();
    }

    function delete_address(id) {
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.delete_address_checkout') }}',
            data: 'address_id='+id+'&_token=' + token,
            success: function (data) {
                load_box_shippings(0);
                if(data.count == 0){
                    $('#checkout_box_method_shippings').html("");
                }
            },
            error: function() {}
        });
    }

    function edit_address(id) {
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_address_checkout') }}',
            data: 'address_id='+id+'&_token=' + token,
            success: function (data) {
                $.each($('.custom_fields_shipping'),function() {
                    $(this).val("")
                });

                $("#modal-nuovo-indirizzo-spedizione").modal('show');
                if(data.address){
                    if ($("#address_edit_id").length == 0) {
                        $("#new_address").append("<input type='hidden' id='address_edit_id' name='id' value='" + data.address.id + "'>");
                    }else{
                        $("#address_edit_id").val(data.address.id);
                    }
                    var name = data.address.name.split(" ");

                    $("#new_address #first_name").val(name[0]);
                    $("#new_address #last_name").val(name[1]);

                    $("#new_address #country_id").val(data.address.country_id).trigger('change');

                    if(data.address.country_id == 106){
                        $("#new_address #provinceSel").val(data.address.county).trigger('change');
                        $("#box_city").remove();
                        $("#box_city_edit").html('<div class="row"><div class="col-8"> <div class="form-group"><label for="city_id">Città *</label><input type="text" class="form-control" name="city_id" id="city_id" value="'+data.address.city+'" required></div> </div> <div class="col-4"><div class="form-group"><label for="zip">CAP *</label><input type="text" class="form-control" name="zip" id="zip" value="'+data.address.postal_code+'" required> </div> </div> </div>');
                    }else{
                        $("#new_address #province").val(data.address.county);
                        $("#city_id").val(data.address.city);
                        $("#zip").val(data.address.postal_code);
                    }

                    var obj = jQuery.parseJSON((data.address.custom_fields_shipping));
                    $.each(obj, function (index, value) {
                        $("#new_address #"+index+"").val(value);
                    });

                    $("#new_address #address").val(data.address.address1);
                    $("#new_address #number_street").val(data.address.number_street);
                    $("#new_address #mobile_phone").val(data.address.phone);
                    $("#new_address #comment").val(data.address.comment);
                }
            },
            error: function() {}
        });
    }

    function edit_fatturazione(id) {
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_fatturazione_checkout') }}',
            data: 'address_id='+id+'&_token=' + token,
            success: function (data) {
                $.each($('.custom_fields_checkout'),function() {
                    $(this).val("")
                });

                $("#modal-nuovo-indirizzo-fatturazione").modal('show');
                if(data.address){
                    if ($("#fatturazione_edit_id").length == 0) {
                        $("#new_fatturazione").append("<input type='hidden' id='fatturazione_edit_id' name='id' value='"+data.address.id+"'>");
                    }else{
                        $("#fatturazione_edit_id").val(data.address.id);
                    }

                    $("#new_fatturazione #name").val(data.address.name);
                    $("#new_fatturazione #country_id_fatt").val(data.address.country_id).trigger('change');

                    var obj = jQuery.parseJSON((data.address.custom_fields_checkout));
                    $.each(obj, function (index, value) {
                        $("#new_fatturazione #"+index+"").val(value);
                    });

                    if(data.address.business_name){
                        $("#new_fatturazione #box_azienda").show();
                        $("#new_fatturazione #type_client").val(1);
                        $("#new_fatturazione #business_name").val(data.address.business_name);
                        $("#new_fatturazione #pec").val(data.address.pec);
                        $("#new_fatturazione #sdi").val(data.address.sdi);
                    }else{
                        $("#new_fatturazione #box_azienda").hide();
                        $("#new_fatturazione #type_client").val(0);
                    }

                    $("#new_fatturazione #city").val(data.address.city);
                    $("#new_fatturazione #province").val(data.address.county);
                    $("#new_fatturazione #address").val(data.address.address1);
                    $("#new_fatturazione #number_street").val(data.address.number_street);
                    $("#new_fatturazione #fiscal_code_vat").val(data.address.fiscal_code_vat);
                    $("#new_fatturazione #postal_code").val(data.address.postal_code);
                }
            },
            error: function() {}
        });
    }

    function delete_fatturazione(id) {
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.delete_fatturazione_checkout') }}',
            data: 'address_id='+id+'&_token=' + token,
            success: function (data) {
                load_box_fatturazione(0);
            },
            error: function() {}
        });
    }
</script>
@endsection
