<script type="text/javascript">
    function add_day(){
        var random = Math.floor(Math.random() * 200000) + 1000000;

        var selectedRow = '<div class="col-sm-6 px-2 mb-4" id="box-'+random+'">' +
            '<div class="card-header border bg-light">' +
            '<div class="row align-items-center">' +
            '<div class="col"><select class="custom-select" name="days[]" id="day_select_'+random+'">' +
                '<option value="1" selected="">Lunedì</option>' +
                '<option value="2">Martedì</option>' +
                '<option value="3">Mercoledì</option>' +
                '<option value="4">Giovedì</option>' +
                '<option value="5">Venerdì</option>' +
                '<option value="6">Sabato</option>' +
                '<option value="7">Domenica</option>' +
                '</select></div>' +
            '<div class="col-auto px-1"><button class="btn-danger btn btn-sm" type="button" onclick="delete_day('+random+')" href="#">Elimina Giorno</button></div>' +
            '<div class="col-auto px-1"><button class="btn btn-info btn-sm" type="button" onclick="add_time('+random+')">Aggiungi Orario</button></div>' +
            '</div>' +
            '</div>' +
            '<div id="timetable_'+random+'"></div>' +
            '</div>';

        $('#box_days').append(selectedRow);

    }

    function add_time(id){
        var random = Math.floor(Math.random() * 200000) + 1000000;

        var day_select = $("#day_select_"+id).val();

        var selectedRow = '<div class="card p-2 my-1" id="time_'+random+'"><table class="table-sm">' +
            '<tr>' +
            '<td class="align-middle font-weight-bold" width="100">Orario</td>'+
            '<td class="align-middle"><input type="text" class="form-control" name="time_title['+day_select+'][]" placeholder="Orario"></td>'+
            '<td class="align-middle" width="170"><select class="custom-select" name="time_is_special['+day_select+'][]">' +
            '<option value="0" selected="">Orario normale</option>' +
            '<option value="1">Orario speciale</option>' +
            '</select></td>' +
            '<td class="align-middle" width="50"><button class="btn btn-sm btn-danger" type="button" onclick="delete_time('+random+')"><i class="la la-trash la-lg"></i></button></td>'+
            '</tr>' +
            '<tr>' +
            '<td class="align-top font-weight-bold" width="100">Descrizione</td>' +
            '<td class="align-middle" colspan="3"><textarea class="form-control summernote" name="time_description['+day_select+'][]" id="editor_'+random+'" placeholder="Descrizione"></textarea></td>'+
            '</tr></table></div>';

        $('#timetable_'+id).append(selectedRow);

        callback_summernote('#editor_'+random);
    }

    function delete_day(id){
        Swal.fire({
            title: "Eliminazione",
            text: "Sicuro di voler eliminare questo giorno?",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Chiudi',
            confirmButtonText: 'Conferma',
        }).then((result) => {
            if (result.isConfirmed) {
                $("#box-"+id).remove();
            }
        })
    }

    function delete_time(id){
        Swal.fire({
            title: "Eliminazione",
            text: "Sicuro di voler eliminare questo orario?",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Chiudi',
            confirmButtonText: 'Conferma',
        }).then((result) => {
            if (result.isConfirmed) {
                $("#time_"+id).remove();
            }
        })
    }

    function callback_summernote(id){
        $(id).summernote({
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
    }

    $('.summernote').summernote({
        height: 100,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
        ]
    });
</script>
