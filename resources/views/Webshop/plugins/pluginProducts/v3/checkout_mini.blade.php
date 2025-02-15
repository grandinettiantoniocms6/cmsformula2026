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

<section class="border-top border-bottom py-3 py-sm-4">
    <div class="container">
        <h1 class="page-title font-2xl my-0">{{ @$labels['shop-checkoutmini-invia-ordine'] }}</h1>
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

    <div class="modal fade" id="modal-nuovo-indirizzo-spedizione">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ @$labels['shop-indirizzo-spedizione'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x"></i>
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

                        <button type="submit" class="btn btn-block btn-primary" >{{ @$labels['shop-checkout-salva-indirizzo'] }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-nuovo-indirizzo-fatturazione">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ @$labels['shop-checkout-dati-fatturazione'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
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
                        <button type="submit" class="btn btn-block btn-primary">{{ @$labels['shop-checkout-salva-indirizzo'] }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('save.order_new') }}" id="form-checkout">
        {{ csrf_field() }}
        <input type="hidden" name="mini" value="1">
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
                        <div class="card-step">
                            <div id="checkout_box_shippings"></div>
                            <button type="button" class="btn btn-secondary btn-block" data-bs-toggle="modal" data-target="#modal-nuovo-indirizzo-spedizione" onclick="clearModalAddress();">{{ @$labels['shop-checkout-aggiungi-nuovo-indirizzo'] }}</button>
                        </div>

                        <div class="card-step">
                            <div id="checkout_box_fatturazione"></div>
                            <button type="button" class="btn btn-secondary btn-block" data-bs-toggle="modal" data-target="#modal-nuovo-indirizzo-fatturazione" onclick="clearModalCompany();">{{ @$labels['shop-checkout-aggiungi-nuovo-indirizzo-fatt'] }}</button>
                        </div>

                        <button class="btn btn-primary w-100 btn-lg my-3">{{ @$labels['shop-checkoutmini-invia-ordine'] }}</button>
                    </div>

                    <aside class="col-lg-4">
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
                                    @endphp

                                    @foreach ($cart as $item)
                                        @php
                                            $product = \App\Models\PluginProducts::with("tax")->find($item->product_id);
                                            //$productTotal = $item->price * $item->qty;
                                            $productTotal = $item->price * $item->qty;
                                        @endphp
                                        <tr>
                                            <td>{{ $product->sku }} <strong>x {{ $item->qty }}</strong></td>
                                            <td class="text-end" width="90">{!! $symbol !!} {{ number_format($productTotal,2, ',','.') }}</td>
                                        </tr>
                                        @php
                                            $tot = $tot + $productTotal;
                                            $totShip = $totShip + ($item->qty * $product->getShipPrice($item->price));
                                            $prezzoNoIva = $productTotal / ((100+$product->tax->value)/100);
                                            $totNoTax = $totNoTax + $prezzoNoIva;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                                <table class="table table-sm my-0">
                                    <tbody id="checkout_tbody">
                                    @if(env('PROJECT_NAME') != "Maison-Flaneur")
                                        <tr>
                                            <th>{{ @$labels['shop-checkout-totale'] }} <small>{{ @$labels['shop-checkout-tasse-escl'] }}</small></th>
                                            <td class="text-end">{!! $symbol !!} <span id="total_no_tax">{{ number_format(round($totNoTax, 2),2, ',','.') }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ @$labels['shop-checkout-tasse'] }} <small>{{ @$labels['shop-checkout-iva'] }}</small></th>
                                            <td class="text-end">{!! $symbol !!} <span id="sum_tax">{{ number_format(round($tot - $totNoTax, 2),2, ',','.') }}</span></td>
                                        </tr>
                                    @endif
                                    <tr id="discount_coupon"></tr>
                                    <tr id="shipping_view"></tr>
                                    </tbody>
                                    <tfoot>
                                    <tr class="text-danger">
                                        <th>Totale</th>
                                        <td  class="text-end">{!! $symbol !!} <span id="total_view">{{ number_format(round($tot, 2),2, ',','.') }}</span>
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
                        <div class="mt-3">
                            <label>{{ @$labels['shop-checkout-note-ordine'] }}</label>
                            <textarea name="note" class="form-control"></textarea>
                        </div>
                        <small class="privacy-text">{{ @$labels['shop-checkout-privacy'] }} <br><br></small>
                    </aside>
                </div>

            </div>
    </form>
</section>

@section('after_scripts')
<script type="text/javascript">
    $(document).ready(function(){

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

                        <?php
                        $symbol = "&euro;";
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_dollar'))){
                            $symbol = "&#36;";
                        }
                        if(\Auth::user() && in_array(\Auth::user()->country_id, config('config.default_country_user_listino_2'))){
                            $symbol = "&euro;";
                        }
                        ?>
                        $('#shipping_view').html('<th>Spedizione</th><td class="text-end">{!! $symbol !!} ' + sum_total_ship_format + '</td>');
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
                $("#modal-nuovo-indirizzo-fatturazione").modal('show');
                if(data.address){
                    if ($("#fatturazione_edit_id").length == 0) {
                        $("#new_fatturazione").append("<input type='hidden' id='fatturazione_edit_id' name='id' value='"+data.address.id+"'>");
                    }else{
                        $("#fatturazione_edit_id").val(data.address.id);
                    }

                    $("#new_fatturazione #name").val(data.address.name);
                    $("#new_fatturazione #country_id_fatt").val(data.address.country_id).trigger('change');

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
