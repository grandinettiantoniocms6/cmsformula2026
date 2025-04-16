<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Nuovo Ordine</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="la la-close"></i>
            </button>
        </div>

        <form id="form-prenotazione" method="post" action="{{ route('PluginOrder.store_from_planning') }}">
            <div class="modal-body">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4" id="col-cliente">
                        <div class="card shadow-sm" id="client-detail">
                            <div class="card-header bg-light">
                                <h5 class="my-0">Cliente</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Cerca cliente</label>
                                    <select class="form-control select2" id="choose-baseuser" name="baseuser_id"></select>
                                </div>
                                <!--<a class="btn btn-dark btn-block" href="#" id="new_client">Nuovo Cliente?</a>-->
                            </div>
                            <div class="card-footer">
                                <div class="form-group" id="box_baseuser">
                                    <label class="d-block mb-0">Cliente</label>
                                    <label class="d-block font-weight-normal font-sm mb-3">*Nome,Cognome e Telefono sono obbligatori</label>

                                    <input type="hidden" id="client_id" name="client_id" value="0">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Cognome*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nome*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+39</span>
                                            </div>
                                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Telefono*" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Giorno della consegna</label>
                                    <input type="date" class="form-control" name="day" id="appuntamento" value="{{ $day }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Orario della consegna</label>
                                    <input type="time" class="form-control" name="start" id="orario1" data-rule-required="true" value="{{ $hour }}" required>
                                </div>
                            </div>
                        </div>

                        @if($products)
                            <div class="card px-3 py-2">
                                <div class="form-group mb-2" id="prodotti-field">
                                    <label>Prodotti</label>
                                    <select class="form-control" id="choose-categories" multiple name="choose-categories">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>

                                    <a class="mt-1 btn btn-default btn-block btn-xs" id="add_new_product">Prodotto non presente in lista? Aggiungi nuovo</a>
                                </div>
                                <table class="table table-striped table-bordered" id="table-categories">
                                    <tbody></tbody>
                                </table>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Il cliente ha lasciato un acconto?</label>
                                    <input type="number" name="acconto" class="form-control"></input>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note Ordine</label>
                                    <textarea name="note" id="summernote" class="form-control" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Luogo ritiro</label>
                                    <?php
                                    $places = ["Ritiro in negozio", "Consegna a domicilio"];
                                    ?>
                                    <select class="form-control" id="choose-place" name="place_ritiro">
                                        @foreach ($places as $place)
                                            <option value="{{ $place }}">{{ $place }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" id="box_address">
                                    <label>Inserisci indirizzo di consegna</label>
                                    <textarea id="address" name="address" rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form-prenotazione" id="save_reservation" class="btn btn-success">
                    <i class="la la-save"></i> <span>Salva</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#box_address").hide();

    $('select#choose-place').on('change', function() {
        var place = $(this).val();
        if(place == "Consegna a domicilio"){
            $("#box_address").show();
        }else{
            $("#box_address").hide();
        }
    });

    $("#add_new_product").click(function (){
        var _token = "{{ csrf_token() }}";
        var resourceId = "{{ $resourceId }}";
        $.ajax({
            type: "POST",
            url: "{{ route('PluginOrder.add_new_products') }}",
            data: "resourceId="+resourceId+"&_token=" + _token,
            success: function(data) {
                $('#table-categories tbody').append(data.html);
            },
            error: function(){
            }
        });
    });

    /** Client selection */
    $('select#choose-baseuser').select2({
        language: "it",
        placeholder: 'Digita Nome o Cognome del cliente',
        width: '100%',
        multiple: false,
        minimumInputLength: 1,
        ajax: {
            url: "{{ route('PluginOrder.clients_autocomplete') }}",
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            }
        }
    });

    $('select#choose-baseuser').on('change', function() {
        var _token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{ route('PluginOrder.get_client') }}",
            data: "id="+$(this).val()+"&_token="+_token,
            success: function(data) {
                $('#client-detail .card-footer').removeClass('d-none');
                if(data.client){
                    $('#client_id').val(data.client.id);
                    $('#first_name').val(data.client.first_name);
                    $('#last_name').val(data.client.last_name);
                    $('#email').val(data.client.email);
                    $('#mobile').val(data.client.mobile_1);
                }
                $('select#choose-baseuser').removeClass('is-invalid');
            },
            error: function(){
            }
        });
    });

    $('select#choose-categories').select2({
        width: '100%',
        containerCssClass: 'choice__remove'
    });

    $('select#choose-categories').on('select2:select', function (e) {
        var catSelected = e.params.data;
        var _token = "{{ csrf_token() }}";
        var resourceId = "{{ $resourceId }}";
        $.ajax({
            type: "POST",
            url: "{{ route('PluginOrder.get_row_products') }}",
            data: "id="+catSelected.id+"&resourceId="+resourceId+"&_token=" + _token,
            success: function(data) {
                $('#table-categories thead').removeClass('d-none');
                $('#table-categories tbody').append(data.html);
                $('select#choose-categories').removeClass('is-invalid');
            },
            error: function(){
            }
        });
    }).on('select2:unselecting', function (e) {

        var catSelected = e.params.args.data;
        var _token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{ route('PluginOrder.get_row_products') }}",
            data: "id="+catSelected.id+"&_token=" + _token,
            success: function(data) {
                $('#table-categories tbody').append(data.html);
                $('select#choose-categories').removeClass('is-invalid');
            },
            error: function(){
            }
        });

        e.preventDefault();
        $('select#choose-categories').select2('close');
    });

    $('#table-categories').on('click', '.btn-delete-row', function () {
        var catRemoved = $(this).closest('tr').data('catid');
        var catRemovedId = catRemoved.split('-');
        catRemovedId = catRemovedId[1];

        $(this).closest('tr').remove();

        if (!$('#table-categories tbody tr[data-catidsel='+catRemovedId+']').length > 0) {
            $('#choose-categories option[value="'+ catRemovedId +'"]').prop('selected', false);
        }

        $('#choose-categories').trigger('change.select2');

        if ($('#table-categories tbody tr').length == 0) {
            $('#table-categories thead').addClass('d-none');
        }
    });

    $('#summernote').summernote({
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', []],
            ['insert', []],
            ['view', []]
        ]
    });

</script>
