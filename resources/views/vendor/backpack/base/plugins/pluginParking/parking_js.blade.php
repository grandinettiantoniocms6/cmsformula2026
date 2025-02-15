<script type="text/javascript">
    $('#add-promo').click(function() {
        var random = Math.floor(Math.random() * 200000) + 1000000;
        var selectedRowPromo = '<div class="col-md-12 well repeatable-element row m-1 p-2" id="box_promo_'+random+'">'+
            '<div class="form-group col-md-1">'+
            '<label>Tipo</label>'+
            '<select class="form-control" name="rule_discount[]" id="rule_discount_'+random+'"><option value="0">Sottrai</option><option value="1">Aggiungi</option></select>'+
            '</div>'+
            '<div class="form-group col-md-1">'+
            '<label>Valore</label>'+
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
            '<label>Tipo Parcheggio</label>'+
            '<select class="form-control" name="condition_discount[]" id="condition_discount_'+random+'"><option value="0"></option><option value="1">Scoperto</option><option value="2">Coperto</option></select>'+
            '</div>'+
            /*'<div class="form-group col-md-1">'+
            '<label>Regola</label>'+
            '<select class="form-control" name="rule_discount[]" id="rule_discount_'+random+'"><option value="0">Uguale</option><option value="1">Maggiore</option></select>'+
            '</div>'+
            '<div class="form-group col-md-1">'+
            '<label>Valore</label>'+
            '<input type="number" value="" class="form-control" name="value_discount[]" id="value_discount_'+random+'">'+
            '</div>'+*/
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
