<script type="text/javascript">
    function add_checkin(id){
        var random = Math.floor(Math.random() * 200000) + 1000000;

        var selectedRow = '<div class="card mb-2"><div class="card-body" id="box_'+random+'"><div class="row">'+
            '<div class="col-12 text-right"><a class="btn-danger btn btn-sm" onclick="deleteRow('+random+')" href="#">Elimina</a></div>'+
            '<div class="form-group col-md-6 col-xl-3">'+
            '<label>Nome</label>'+
            '<input type="text" value="" class="form-control" name="first_name[]" id="first_name_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-6 col-xl-3">'+
            '<label>Cognome</label>'+
            '<input type="text" value="" class="form-control" name="last_name[]" id="last_name_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-4 col-xl-2">'+
            '<label>Data di nascita</label>'+
            '<input type="date" value="" class="form-control" name="birthdate[]" id="birthdate_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-4 col-xl-2">'+
            '<label>Email</label>'+
            '<input type="text" value="" class="form-control" name="email[]" id="email_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-4 col-xl-2">'+
            '<label>Telefono</label>'+
            '<input type="text" value="" class="form-control" name="mobile[]" id="mobile_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-6 col-xl-3">'+
            '<label>Carta di identita</label>'+
            '<input type="text" value="" class="form-control" name="carta[]" id="carta_'+random+'">'+
            '</div>'+
            '<div class="form-group col-md-6 col-xl-3">'+
            '<label>Scadenza</label>'+
            '<input type="date" value="" class="form-control" name="scadenza_carta[]" id="scadenza_carta_'+random+'">'+
            '</div>'+
            '<div class="form-group col-xl-6">'+
            '<label>Rilasciato da</label>'+
            '<input type="text" value="" class="form-control" name="comune[]" id="comune_carta_'+random+'">'+
            '</div>'+
            '<div class="form-group col-12">'+
            '<label>Documento File</label>'+
            '<input type="file" value="" class="form-control" name="file[]" id="file_carta_'+random+'">'+
            '</div>'+
            '</div></div></div>';

        $('#box_'+id).append(selectedRow);
    }


    function deleteRow(id){
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
                $("#box_"+id).remove();
            }
        })
    }

    function deleteRowService(id){
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
                $("#box_service_"+id).remove();
            }
        })
    }



    @php
        $services = \App\Models\PluginBookingServices::get()->pluck("name", "id")->toArray();;
    @endphp
    var services = '';
    @foreach ($services as $k=>$label)
        services += "<option value='{{ $k }}'>{{ $label }}</option>";
    @endforeach

    $('#add-service').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;

        var selectedRow = '<div class="row border-bottom align-items-end" id="box_service_'+random+'">'+
            '<div class="py-2 col-md">'+
            '<label>Servizio</label>'+
            '<select class="custom-select" name="service_id[]" id="service_select_'+random+'" onchange="carica_dati('+random+')"><option value=""></option>'+
            services+
            '</select>'+
            '</div>'+
            '<div class="py-2 col-md-2 col-xl-1">'+
            '<label>Qty</label>'+
            '<input type="number" value="1" class="form-control" name="service_qty[]" id="service_qty_'+random+'">'+
            '</div>'+
            '<div class="py-2 col-md-2 col-xl-1">'+
            '<label>Prezzo</label>'+
            '<input type="text" value="" class="form-control" name="service_price[]" id="service_price_'+random+'">'+
            '</div>'+
            '<div class="py-2 col-md-auto">'+
            '<a class="btn-danger btn" onclick="deleteRow('+random+')" href="#">Elimina</a>'+
            '</div>'+
            '</div>';

        $('#box_services').append(selectedRow);
    });

    function carica_dati(random){
        var value = $("#service_select_"+random).val();

        $.ajax({
            url: '{{ route('pluginBookings.get-service-info') }}',
            method: 'GET',
            data: {
                id: value,
                _token: '{{ csrf_token() }}',
            }, success: function (response) {
                $("#service_price_"+random).val(response.item.price_1);
            },error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });

    }


</script>
