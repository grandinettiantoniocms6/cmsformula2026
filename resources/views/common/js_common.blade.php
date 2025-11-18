<script src="{{ url("js_common/common.js") }}"></script>
<?php
$contr = 0;
$shipping_contr = \App\Models\Shipping::where("is_contrassegno", 1)->first();
if($shipping_contr){
    $contr = $shipping_contr->id;
}
$labels = \App\Models\PluginProductsLabels::get()->pluck("value", "key")->toArray();
?>
<script>

    function change_province(element){
        var token = '{{ csrf_token() }}';
        var id = $('#'+element).val();

        if(id != ""){
            $.ajax({
                type: 'POST',
                url: '{{ route('get.cities_by_province') }}',
                data: 'element='+element+'&id='+id+'&_token=' + token,
                dataType: 'json',
                success: function (data) {
                    if(element == "provinceSel"){
                        $('#box_city').show();
                        $('#box_city').html(data.contents);
                    }else{
                        $('#box_city_new_address').html(data.contents);
                    }
                },
                error: function(){}
            });
        }
    }
    /** Pulsanti +/- prodotto */

    function increaseValue(el) {
        var currentVal = parseInt( jQuery(el).val() );
        var maxVal = parseInt( jQuery(el).attr("max") );
        if(currentVal < maxVal){
            if (!isNaN(currentVal)) {
                jQuery(el).val(currentVal + 1);
            } else {
                jQuery(el).val(0);
            }
        }
    }

    function decreaseValue(el) {
        var currentVal = parseInt( jQuery(el).val() );
        if (!isNaN(currentVal) && currentVal > 1) {
            jQuery(el).val(currentVal - 1);
        } else {
            jQuery(el).val(1);
        }
    }

    /** Aggiungi alla wishlist */
    function add_wishlist(id){
        var token = "{{ csrf_token() }}";
        $.ajax({
            type: 'POST',
            url: '{{ route('myarea.add_wishlist') }}',
            data: 'id='+id+'&_token='+token,
            success: function(msg) {
                if(msg == 'success'){
                    location.reload();
                }
            },
            error: function(){
                console.log('Wishlist Error');
            }
        });
    }

    /** Rimuovi dalla wishlist */
    function remove_wishlist(id){
        var token = "{{ csrf_token() }}";
        $.ajax({
            type: 'POST',
            url: '{{ route('myarea.delete_wishlist') }}',
            data: 'id='+id+'&_token='+token,
            success: function(msg) {
                if(msg == 'success'){
                    location.reload();
                }
            },
            error: function(){}
        });
    }

    function change_country_myarea(element) {
        var token = '{{ csrf_token() }}';
        var id = $('#' + element).val();

        if (element == "country_id") {
            $("#provinceSel").val('').trigger('change');
        } else {
            $("#provinceSel2").val('').trigger('change');
        }

        if (id == 106) { //Italia
            if (element == "country_id") {
                $("#box_province").show();
                $("#provinceSel").addClass("required-if-show");
                $('#provinceSel').attr('required', 'true');
                $("#box_city").html("");
            } else {
                $("#box_province_new_address").show();
                $("#provinceSel2").addClass("required-if-show-address");

                $("#box_city_new_address").html("");
            }
        } else { // NON ITALIA
            if (element == "country_id") {
                $("#box_province").hide();
                $('#provinceSel').removeAttr('required');

                $("#box_city").html("<div class=\"row\"><div class=\"col-12\"><div class=\"form-group\"><label for=\"city_id\">Provincia *</label><input type=\"text\" class=\"form-control\" name=\"county\" id=\"province\" required value=\"\"></div></div></div><div class=\"row\"><div class=\"col-8\"><div class=\"form-group\"><label for=\"city_id\">Città *</label><input type=\"text\" class=\"form-control\" name=\"city_id\" id=\"city_id\" value=\"\" required></div></div><div class=\"col-4\"><div class=\"form-group\"><label for=\"zip\">CAP *</label><input type=\"text\" class=\"form-control\" name=\"zip\" id=\"zip\" value=\"\" required></div></div></div>");

            } else {
                $("#box_province_new_address").hide();
                $("#box_city_new_address").html("<div class=\"row\"><div class=\"col-12\"><div class=\"form-group\"><label for=\"city_id\">Provincia *</label><input type=\"text\" class=\"form-control required-if-show-address\" name=\"province_2\" id=\"province_2\" value=\"\"></div></div></div><div class=\"row\"><div class=\"col-8\"><div class=\"form-group\"><label for=\"city_id\">Città *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"city_id_2\" id=\"city_id_2\" value=\"\"></div></div><div class=\"col-4\"><div class=\"form-group\"><label for=\"zip_2\">CAP *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"zip_2\" id=\"zip_2\" value=\"\"></div></div></div>");
            }
        }
    }

    /** Cambia dati di spedizione in base al cambio di nazione */
    function change_country(element){
        var token = '{{ csrf_token() }}';
        var id = $('#'+element).val();

        if(element == "country_id") {
            $("#provinceSel").val('').trigger('change');
        }else{
            $("#provinceSel2").val('').trigger('change');
        }

        if(id == 106){ //Italia
            if(element == "country_id"){
                $("#box_province").show();
                $("#provinceSel").addClass("required-if-show");
                $('#provinceSel').attr('required', 'true');
                $("#box_city").html("");
            }else{
                $("#box_province_new_address").show();
                $("#provinceSel2").addClass("required-if-show-address");

                $("#box_city_new_address").html("");
            }
        }else{ // NON ITALIA
            if(element == "country_id"){
                $("#box_province").hide();
                $('#provinceSel').removeAttr('required');

                $("#box_city").html("<div class=\"row\"><div class=\"col-12\"><div class=\"form-group\"><label for=\"city_id\">Provincia *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"province\" id=\"province\" value=\"\"></div></div></div><div class=\"row\"><div class=\"col-8\"><div class=\"form-group\"><label for=\"city_id\">Città *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"city_id\" id=\"city_id\" value=\"\"></div></div><div class=\"col-4\"><div class=\"form-group\"><label for=\"zip\">CAP *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"zip\" id=\"zip\" value=\"\"></div></div></div>");

            }else{
                $("#box_province_new_address").hide();
                $("#box_city_new_address").html("<div class=\"row\"><div class=\"col-12\"><div class=\"form-group\"><label for=\"city_id\">Provincia *</label><input type=\"text\" class=\"form-control required-if-show-address\" name=\"province_2\" id=\"province_2\" value=\"\"></div></div></div><div class=\"row\"><div class=\"col-8\"><div class=\"form-group\"><label for=\"city_id\">Città *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"city_id_2\" id=\"city_id_2\" value=\"\"></div></div><div class=\"col-4\"><div class=\"form-group\"><label for=\"zip_2\">CAP *</label><input type=\"text\" class=\"form-control required-if-show\" name=\"zip_2\" id=\"zip_2\" value=\"\"></div></div></div>");
            }
        }

        var first_ship_id = {{ $contr }}; /** Contrassegno */

        $.ajax({
            type: 'POST',
            url: '{{ route('get.shippings') }}',
            data: 'id='+id+'&_token=' + token,
            dataType: 'json',
            success: function (data) {
                $('#shippings').html(data.contents);
                $('#total').val(data.total);
                $('#total_no_tax').val(data.total_no_tax);
                $('#sum_tax').val(data.sum_tax);
                $('#total_ship').val(data.total_ship);

                if(data.first_ship_id == first_ship_id) {
                    $('.is_not_contrassegno').prop('disabled', true);
                    $('.is_contrassegno').prop('disabled', false).prop('checked', true);
                    methodCheckRadioDisabled();
                } else {
                    $('.is_not_contrassegno').prop('disabled', false);
                    $('.is_not_contrassegno:first').prop('checked', true);
                    $('.is_contrassegno').prop('disabled', true);
                    methodCheckRadioDisabled();
                }

                var sum_total = data.total + data.total_ship;
                var sum_total_format = sum_total.toFixed(2).replace(".", ",");

                var sum_total_ship = data.total_ship;
                var sum_total_ship_format = sum_total_ship.toFixed(2).replace(".", ",");

                $('#total_view').html(sum_total_format);
                $('#shipping_view').html('<th>Spedizione</th><td class="text-right">€ ' + sum_total_ship_format + '</td>');
            },
            error: function(){}
        });
    }

    function round(
        value,
        minimumFractionDigits,
        maximumFractionDigits
    ) {
        const formattedValue = value.toLocaleString('en', {
            useGrouping: false,
            minimumFractionDigits,
            maximumFractionDigits
        })
        return Number(formattedValue)
    }


    /** Shipping */
    function change_shipping(value, id){
        var total = parseFloat($('#total_product').val());
        var new_total = parseFloat((total + value).toFixed(3));

        //$('#total').val(new_total);
        $('#total_ship').val(value);
        $('#total_no_tax').val(new_total/1.22);

        if(id == <?php echo $contr; ?>){
            $('.is_not_contrassegno').prop('disabled', true);
            $('.is_contrassegno').prop('disabled', false).prop('checked', true);
            themeCheckRadioDisabled();
        } else {
            $('.is_not_contrassegno').prop('disabled', false);
            $('.is_not_contrassegno:first').prop('checked', true);
            $('.is_contrassegno').prop('disabled', true);
            themeCheckRadioDisabled();
        }

        var num1 = new_total.toFixed(2).toString().replace(/\./g, ',');
        $('#total_view').html(num1);

        @if(!\Auth::user())
             var num1 = value.toFixed(2).replace(".", ",");
             $('#shipping_view').html('<th>{{ @$labels['shop-partials-tot-spedizione'] }}</th><td class="text-end">€ ' + num1 + '</td>');
        @else
            @if(\Auth::user()->type_client == 1)
                var value_no_tax = value / 1.22;
                value_no_tax = round(value_no_tax,2,2);

                var total_sum_tax_22 = (round(total,2, 2) - ((round(total,2, 2) + value)/1.22)) + value;
                total_sum_tax_22 = round(total_sum_tax_22,2,2);

                var prod_no_iva = round(total,2, 2)/1.22;
                prod_no_iva = round(prod_no_iva,2, 2);

                var totale_new = prod_no_iva + total_sum_tax_22 + value_no_tax;

                console.log("Totale prod "+round(total,2, 2));
                console.log("Totale prod no iva"+prod_no_iva);

                console.log("Spedizione tasse escl "+total_sum_tax_22);
                console.log("Valore no tasse "+value_no_tax);
                console.log("Totale "+totale_new);

                var num1 = totale_new.toFixed(2).toString().replace(/\./g, ',');
                $('#total_view').html(num1);

                var num1 = value_no_tax.toFixed(2).replace(".", ",");
                $('#shipping_view').html('<th>{{ @$labels['shop-partials-tot-spedizione'] }} {{ @$labels['shop-tasse-escl'] }}</th><td class="text-end">€ ' + num1 + '</td>');

                $("#sum_tax_22").val(total_sum_tax_22);
                $("#sum_tax").html(total_sum_tax_22);

            @else
                var num1 = value.toFixed(2).replace(".", ",");
                $('#shipping_view').html('<th>{{ @$labels['shop-partials-tot-spedizione'] }}</th><td class="text-end">€ ' + num1 + '</td>');
            @endif
        @endif
       // $('#shipping_view').html('<th>Spedizione</th><td class="text-right">&euro; ' + num1 + '</td>');
    }

    /** Radio Method list */
    function methodCheckRadioDisabled() {
        $('.list-methods .custom-control-input').each(function () {
            if ( $(this).is(':disabled') ) {
                $(this).closest('.method-item').addClass('disabled').removeClass('active');
            } else {
                $(this).closest('.method-item').removeClass('disabled');
            }

            if ( $(this).is(':checked') ) {
                $(this).closest('.method-item').addClass('active');
            } else {
                $(this).closest('.method-item').removeClass('active');
            }
        })
    }

    /** Tema Funzione Radiobutton list */
    function themeCheckRadioDisabled() {
        $('.input-radio__input').each(function () {
            if ( $(this).is(':disabled') ) {
                $(this).closest('li').addClass('methods__item--disabled').removeClass('methods__item--active');
            } else {
                $(this).closest('li').removeClass('methods__item--disabled');
            }

            if ( $(this).is(':checked') ) {
                $(this).closest('li').addClass('methods__item--active');
            } else {
                $(this).closest('li').removeClass('methods__item--active');
            }
        })
    }

    /** Prendo le città della provincia selezionata */
    function change_city(element){
        var token = '{{ csrf_token() }}';
        var id = $('#'+element).val();
        var nazioneId = $('#country_id').val();
        var first_ship_id = {{ $contr }}; /** Contrassegno */

        $.ajax({
            type: 'POST',
            url: '{{ route('get.shippings_by_cities') }}',
            data: 'nazioneId='+nazioneId+'&id='+id+'&_token=' + token,
            dataType: 'json',
            success: function (data) {
                $('#shippings').html(data.contents);
                $('#total').val(data.total);
                $('#total_no_tax').val(data.total_no_tax);
                $('#sum_tax').val(data.sum_tax);
                $('#total_ship').val(data.total_ship);

                if(data.first_ship_id == first_ship_id) {
                    $('.is_not_contrassegno').prop('disabled', true);
                    $('.is_contrassegno').prop('disabled', false).prop('checked', true);
                    methodCheckRadioDisabled();
                } else {
                    $('.is_not_contrassegno').prop('disabled', false);
                    $('.is_not_contrassegno:first').prop('checked', true);
                    $('.is_contrassegno').prop('disabled', true);
                    methodCheckRadioDisabled();
                }

                var sum_total = data.total + data.total_ship;
                var sum_total_format = sum_total.toFixed(2).replace(".", ",");

                var sum_total_ship = data.total_ship;
                var sum_total_ship_format = sum_total_ship.toFixed(2).replace(".", ",");

                $('#total_view').html(sum_total_format);
                $('#shipping_view').html('<th>Spedizione</th><td class="text-right">€ ' + sum_total_ship_format + '</td>');
            },
            error: function(){}
        });
    }


    /** Controlla Codice Coupon e inseriscilo nel carrello */
    function set_coupon(){
        var token = '{{ csrf_token() }}';
        var value =         $('#code_coupon').val();
        var total =         $('#total').val();
        var total_ship =    $('#total_ship').val();
        var total_product = $('#total_product').val();
        var total_extra =    $('#total_extra').val();

        $.ajax({
            type: 'POST',
            url: '{{ route('check.code_coupon') }}',
            data: 'total='+total+'&total_ship='+total_ship+'&total_extra='+total_extra+'&value='+value+'&total_product='+total_product+'&_token=' + token,
            dataType: 'json',
            success: function (data) {

                $('#total_product').val(data.total_product);
                $('#total').val(data.total);

                var sum_total_format = data.total_view.toFixed(2).replace(".", ",");
                $('#total_view').html(sum_total_format);

                var sum_total_ship_format = data.total_ship.toFixed(2).replace(".", ",");


                $('#total_ship').val(data.total_ship);
                $('#result_code_coupon').html(data.contents);
                $('#discount_coupon').html(data.contents_coupon);

                if(data.contents_ship != ""){
                    $('#shipping_view').html(data.contents_ship);
                }else{
                    $('#shipping_view').html('<th>Spedizione</th><td class="text-right">€ ' + sum_total_ship_format + '</td>');
                }

                $('#total_coupon').val(data.total_discount);

                if(data.rule > 0){
                    $('#code_coupon').attr('readonly', true);
                    $('#button_coupon').html('<button class="btn btn-danger" onclick="delete_coupon(' + data.ex_total + ',' + data.ex_total_ship + ', ' + total_extra + ')">Annulla</button>');
                }
            },
            error: function () {
                console.log('Errore Applicazione Coupon');
            }
        });
    }

    /** Rimuovi Coupon */
    function delete_coupon(total, total_ship, total_extra){
        var token = '{{ csrf_token() }}';
        var total_ship = parseFloat($('#total_ship').val());

        $('#code_coupon').attr('readonly', false).val('');
        $('#button_coupon').html('<button class="btn btn-primary" id="check_code_coupon" type="button" onclick="set_coupon()">Applica</button>');
        $('#result_code_coupon').html('');
        $('#discount_coupon').html('');
        $('#total_coupon').val(0);

        $.ajax({
            type: 'POST',
            url: '{{ route('uncheck.code_coupon') }}',
            data: 'total_ship='+total_ship+'&_token=' + token,
            dataType: 'json',
            success: function (data) {
                $('#total_product').val(data.total_product);
                $('#total').val(data.total_product + total_extra);

                var total_ship = data.total_ship;
                $('#total_ship').val(total_ship);

                var total = data.total_product + total_ship + total_extra;
                var sum_total_format = total.toFixed(2).replace(".", ",");
                $('#total_view').html(sum_total_format);

                var sum_total_ship_format = total_ship.toFixed(2).replace(".", ",");
                $('#shipping_view').html('<th>Spedizione</th><td class="text-right">€ ' + sum_total_ship_format + '</td>');
            },
            error: function() {}
        });
    }

    /** Payment */
    function change_payment(id){
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.checkout.get_payment_by_id') }}',
            data: 'id='+id+'&_token=' + token,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if(data){
                    if(data.is_contrassegno == 0){
                        $('#payment_contrassegno').html('');
                        $('#total_payment').val(0);

                        var perc = 1;
                        if(perc > 0) {
                            var ship = parseFloat($('#total_ship').val());
                            var total = parseFloat($('#total_product').val());
                            var new_total = total + ship;

                            var total_view = (new_total).toFixed(2);
                            $('#total_view').html(total_view);
                            $('#total').val(new_total);
                            $('#service_view').html('');
                        }

                        methodCheckRadioDisabled();
                    }else{
                        var sum_total_contrassegno = parseFloat(data.price_contrassegno);
                        $('#total_payment').val(sum_total_contrassegno);

                        var sum_total_contrassegno_format = sum_total_contrassegno.toFixed(2).replace(".", ",");
                        $('#payment_contrassegno').html('<th>Contrassegno</th><td class="text-right">€ ' + sum_total_contrassegno_format + '</td>');

                        var ship = parseFloat($('#total_ship').val());
                        var total = parseFloat($('#total_product').val());

                        var new_total = total + ship + sum_total_contrassegno;

                        var total_view = (new_total).toFixed(2);
                        $('#total_view').html(total_view);
                        $('#total').val(new_total);
                    }
                }

            },
            error: function() {}
        });


    }

</script>
