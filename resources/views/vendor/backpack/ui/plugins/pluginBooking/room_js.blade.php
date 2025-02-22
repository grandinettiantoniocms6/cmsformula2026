<script type="text/javascript">
    @php
        $services = \App\Models\PluginBookingServices::whereNull("price_1")->whereNull("price_2")
           ->where("plugin_booking_type_id", \request()->get('type'))
           ->get()->pluck("name", "id")->toArray();

       $services_payments = \App\Models\PluginBookingServices::whereNotNull("price_1")
           ->where("plugin_booking_type_id", \request()->get('type'))
           ->whereNotNull("price_2")->get()->pluck("name", "id")->toArray();

       $parameters = \Route::current()->parameters(); //se sono in modifica

       $rooms = null;
       $item = null;

       $type_item = \request()->get('type');

       if(count($parameters) > 0){
           $item = \App\Models\PluginBookingRoom::find($parameters['id']);
           $services = \App\Models\PluginBookingServices::whereNull("price_1")->whereNull("price_2")
               ->where("plugin_booking_type_id", $item->plugin_booking_type_id)
               ->get()->pluck("name", "id")->toArray();

           $services_payments = \App\Models\PluginBookingServices::whereNotNull("price_1")
               ->where("plugin_booking_type_id", $item->plugin_booking_type_id)
               ->whereNotNull("price_2")->get()->pluck("name", "id")->toArray();

           $rooms = \App\Models\PluginBookingRoom::where("plugin_booking_type_id", "!=", $item->plugin_booking_type_id)
               ->get()->pluck("name", "id")->toArray();

           $type_item = $item->plugin_booking_type_id;
       }
    @endphp

    var services = '';
    @foreach ($services as $k=>$label)
        services += "<option value='{{ $k }}'>{{ $label }}</option>";
    @endforeach


    var services_pay = '';
    @foreach ($services_payments as $k=>$label)
        services_pay += "<option value='{{ $k }}'>{{ $label }}</option>";
    @endforeach

    var rooms = '';
    @if($rooms)
        @foreach ($rooms as $k=>$label)
            rooms += "<option value='{{ $k }}'>{{ $label }}</option>";
        @endforeach
    @endif

    var ripetizione = "<option value='0'>Data specifica</option><option value='1'>Ripeti ogni anno</option>";

    $('#add-addiction').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;
        var selectedRow = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_addiction_'+random+'">'+
            '<div class="form-group col-md-8">'+
            '<label>Struttura</label>'+
            '<select class="form-control" name="addictions['+random+']" id="addiction_'+random+'"><option value=""></option>'+
            rooms+
            '</select>'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<a class="btn-danger btn" onclick="deleteRow('+random+', \'addiction\')" href="#"><i class="la la-trash la-lg"></i></a>'+
            '</div>'+
            '</div>';

        $('#box_addictions').append(selectedRow);
    });

    $('#add-service-gratis').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;
        var selectedRow = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_service_gratis_'+random+'">'+
            '<div class="form-group col-md-8">'+
            '<label>Servizio</label>'+
            '<select class="form-control" name="services_list_free['+random+']" id="services_list_free_'+random+'"><option value=""></option>'+
            services+
            '</select>'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<label>Ordine</label>'+
            '<input type="number" value="" class="form-control" name="lft_free['+random+']" id="lft_free_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<a class="btn-danger btn" onclick="deleteRow('+random+', \'service_gratis\')" href="#"><i class="la la-trash la-lg"></i></a>'+
            '</div>'+
            '</div>';

        $('#box_services_gratis').append(selectedRow);
    });

    $('#add-service-payment').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;
        var selectedRow = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_service_payment_'+random+'">'+
            '<div class="form-group col-md-8">'+
            '<label>Servizio</label>'+
            '<select class="form-control" name="services_list['+random+']" id="services_list_'+random+'"><option value=""></option>'+
            services_pay+
            '</select>'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<label>Ordine</label>'+
            '<input type="number" value="" class="form-control" name="lft['+random+']" id="lft_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<a class="btn-danger btn" onclick="deleteRow('+random+', \'service_payment\')" href="#"><i class="la la-trash la-lg"></i></a>'+
            '</div>'+
            '</div>';

        $('#box_services_payment').append(selectedRow);
    });


    $('#add-price').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;

        @if(@$type_item == env('ID_TIPOLOGIA_MIN_MAX_GIORNI'))
            var selectedRow = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_price_'+random+'">'+
                '<div class="form-group col-md-2">'+
                '<label>Prezzo &euro; iva incl.</label>'+
                '<input type="text" value="" class="form-control" name="price[]" id="price_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1">'+
                '<label>Min.Giorni</label>'+
                '<input type="number" value="1" class="form-control" name="min_day[]" id="min_day_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1">'+
                '<label>Max.Giorni</label>'+
                '<input type="text" value="1" class="form-control" name="max_day[]" id="max_day_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1">'+
                '<label>Min.Ospiti</label>'+
                '<input type="number" value="" class="form-control" name="min[]" id="min_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1">'+
                '<label>Max.Ospiti</label>'+
                '<input type="text" value="" class="form-control" name="max[]" id="max_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<label>Data inizio</label>'+
                '<input type="date" value="" class="form-control" name="date_start[]" id="date_start_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<label>Data fine</label>'+
                '<input type="date" value="" class="form-control" name="date_end[]" id="date_end_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<a class="btn-danger btn" onclick="deleteRow('+random+', \'price\')" href="#"><i class="la la-trash la-lg"></i></a>'+
                '</div>'+
                '</div>';

        @else
            var selectedRow = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_price_'+random+'">'+
                '<div class="form-group col-md-2">'+
                '<label>Prezzo &euro; iva incl.</label>'+
                '<input type="text" value="" class="form-control" name="price[]" id="price_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1 d-none">'+
                '<label>Min.Giorni</label>'+
                '<input type="number" value="1" class="form-control" name="min_day[]" id="min_day_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1 d-none">'+
                '<label>Max.Giorni</label>'+
                '<input type="text" value="1" class="form-control" name="max_day[]" id="max_day_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1">'+
                '<label>Min.Ospiti</label>'+
                '<input type="number" value="" class="form-control" name="min[]" id="min_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-1">'+
                '<label>Max.Ospiti</label>'+
                '<input type="text" value="" class="form-control" name="max[]" id="max_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<label>Data inizio</label>'+
                '<input type="date" value="" class="form-control" name="date_start[]" id="date_start_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<label>Data fine</label>'+
                '<input type="date" value="" class="form-control" name="date_end[]" id="date_end_'+random+'" required>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<label>Ripetizione</label>'+
                '<select class="form-control" name="all_years[]" id="all_years_'+random+'"><option value=""></option>'+
                ripetizione+
                '</select>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<a class="btn-danger btn" onclick="deleteRow('+random+', \'price\')" href="#"><i class="la la-trash la-lg"></i></a>'+
                '</div>'+
                '</div>';
        @endif
        $('#box_prices').append(selectedRow);

    });

    $('#add-promo').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;
        var selectedRowPromo = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_promo_'+random+'">'+
            '<div class="form-group col-md-1">'+
            '<label>Sconto</label>'+
            '<input type="text" value="" class="form-control" name="discount[]" id="discount_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-1">'+
            '<label>Tipo sconto</label>'+
            '<select class="form-control" name="type_discount[]" id="type_discount_'+random+'"><option value="0">&euro;</option><option value="1">%</option></select>'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<label>Data inizio</label>'+
            '<input type="date" value="" class="form-control" name="discount_date_start[]" id="discount_date_start_'+random+'" required>'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<label>Data fine</label>'+
            '<input type="date" value="" class="form-control" name="discount_date_end[]" id="discount_date_end_'+random+'" required>'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<label>Condizione sconto</label>'+
            '<select class="form-control" name="condition_discount[]" id="condition_discount_'+random+'"><option value="0"></option><option value="1">Numero giorni</option><option value="2">Numero partecipanti</option></select>'+
            '</div>'+
            '<div class="form-group col-md-1">'+
            '<label>Regola</label>'+
            '<select class="form-control" name="rule_discount[]" id="rule_discount_'+random+'"><option value="0">Uguale</option><option value="1">Maggiore</option></select>'+
            '</div>'+
            '<div class="form-group col-md-1">'+
            '<label>Valore</label>'+
            '<input type="number" value="" class="form-control" name="value_discount[]" id="value_discount_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-1">'+
            '<label>Ordine</label>'+
            '<input type="number" value="" class="form-control" name="lft_discount[]" id="lft_discount_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-1">'+
            '<a class="btn-danger btn" onclick="deleteRow('+random+', \'promo\')" href="#"><i class="la la-trash la-lg"></i></a>'+
            '</div>'+
            '</div>';

        $('#box_promos').append(selectedRowPromo);
    });

    function deleteRow(id, value){
        Swal.fire({
            title: "Eliminazione",
            text: "Sicuro di voler eliminare?",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Chiudi',
            confirmButtonText: 'Conferma',
        }).then((result) => {
            if (result.isConfirmed) {
                $("#box_"+value+"_"+id).remove();
            }
        })
    }

</script>
