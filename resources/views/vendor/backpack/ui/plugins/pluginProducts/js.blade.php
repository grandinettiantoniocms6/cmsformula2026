<script type="text/javascript">
    @php
       $parameters = \Route::current()->parameters(); //se sono in modifica
       $langs = \App\Models\AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
    @endphp

    var services = '';
    @foreach ($langs as $lang)
        services += '<br>{{ $lang }}<input type="text" value="" class="form-control" name="name_services[]" required>';
    @endforeach


    $('#add-quantity').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;

        var selectedRow = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_quantity_'+random+'">'+
            '<div class="form-group col-md-4">'+
            '<label>Minimo</label>'+
            '<input type="number" value="" class="form-control" name="min_quantities[]" id="min_quantities_'+random+'" required>'+
            '</div>'+
            '<div class="form-group col-md-4">'+
            '<label>Prezzo &euro; iva escl.</label>'+
            '<input type="text" value="" class="form-control" name="price_quantities[]" id="price_quantities_'+random+'" required>'+
            '</div>'+
            '<div class="form-group col-md-4">'+
            '<a class="btn-danger btn mt-4" onclick="deleteRow('+random+', \'quantity\')" href="#"><i class="la la-trash la-lg"></i></a>'+
            '</div>'+
            '</div>';

        $('#box_quantities').append(selectedRow);
    });

    $('#add-service').click(function() {

        var random = Math.floor(Math.random() * 200000) + 1000000;
        var selectedRow = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_service_'+random+'">'+
            '<div class="form-group col-md-6">'+
            '<label>Nome</label>'+
            '<input type="text" value="" class="form-control" name="name_services[]" required>'+
            '</div>'+
            '<div class="form-group col-md-4">'+
            '<label>Prezzo &euro; iva escl. (da aggiungere)</label>'+
            '<input type="text" value="" class="form-control" name="price_services[]" id="price_services_'+random+'" required>'+
            '</div>'+
            '<div class="form-group col-md-2">'+
            '<a class="btn-danger btn" onclick="deleteRow('+random+', \'service\')" href="#"><i class="la la-trash la-lg"></i></a>'+
            '</div>'+
            '</div>';

        $('#box_services_add').append(selectedRow);
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
