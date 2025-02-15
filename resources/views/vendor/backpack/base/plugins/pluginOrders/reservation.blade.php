<?php
 $readonly = "readonly";
 $disabled = "disabled";
 if(backpack_user()->roles[0]->id <= 3){
     $readonly = "";
     $disabled = "";
 }
?>

<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modifica Ordine</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="la la-close"></i>
            </button>
        </div>

        <form id="form-prenotazione" class="bold-labels" method="post" action="{{ route('PluginOrder.update_from_planning') }}">
            <div class="modal-body">
                {{ csrf_field() }}
                <input type="hidden" id="reservation_id" name="reservation_id" value="{{ $reservation->id }}">
                <div class="row">
                    <div class="col-md-4" id="col-cliente">
                        <div class="card shadow-sm" id="client-detail">
                            <div class="card-header bg-light">
                                <h5 class="my-0">Cliente</h5>
                            </div>
                            <div class="card-footer d-none">
                                <div class="form-group" id="box_baseuser">
                                    <label class="d-block font-weight-normal font-sm mb-3">*Nome,Cognome e Telefono sono obbligatori</label>

                                    <input type="hidden" id="client_id" name="client_id" value="{{ $client->id }}">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Cognome*" value="{{ $client->last_name }}" required <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nome*" value="{{ $client->first_name }}" required <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $client->email }}" <?php echo $readonly;?>>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+39</span>
                                            </div>
                                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Telefono*" value="{{ $client->mobile_1 }}" required <?php echo $readonly;?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm" id="client-detail">
                            <div class="card-header bg-light">
                                <h5 class="my-0">Cassa</h5>
                            </div>
                            <div class="card-footer d-none">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Totale prodotti</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">&euro;</span>
                                            </div>
                                            <input type="text" class="form-control" name="total" value="{{ $reservation->total }}" disabled <?php echo $readonly;?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Acconto cliente</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">&euro;</span>
                                            </div>
                                            <input type="number" class="form-control" name="acconto" value="{{ $reservation->acconto }}" required <?php echo $readonly;?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Totale da pagare</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">&euro;</span>
                                            </div>
                                            <input type="text" class="form-control" name="acconto" value="{{ $reservation->total - $reservation->acconto }}" disabled <?php echo $readonly;?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Giorno della consegna</label>
                                    <input type="date" class="form-control" name="day" id="appuntamento" value="{{ $reservation->date_delivery }}" <?php echo $readonly;?>>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Orario della consegna</label>
                                    <input type="time" class="form-control" name="start" id="orario1" data-rule-required="true" value="{{ $reservation->time_delivery }}" <?php echo $readonly;?>>
                                </div>
                            </div>
                        </div>

                        <?php $v_products = [] ;?>
                        @if($reservation_detail)
                            @foreach($reservation_detail as $detail)
                                <?php $v_products[] = $detail->plugin_product_id ;?>
                            @endforeach
                        @endif

                        @if($products)
                            <div class="card px-3 py-2">
                                @if(backpack_user()->roles[0]->id <= 3)
                                <div class="form-group mb-2" id="prodotti-field">
                                    <label>Prodotti</label>
                                    <select class="form-control" id="choose-categories" multiple name="choose-categories">
                                        @foreach ($products as $product)
                                            @if(in_array($product->id, $v_products))
                                                <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                                            @else
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <table class="table table-sm table-striped table-fluid my-0" id="table-categories">
                                    <tbody>
                                    @if($reservation_detail)
                                        @foreach($reservation_detail as $detail)
                                            <?php
                                            $product = \App\Models\PluginOrdersProducts::find($detail->plugin_product_id);
                                            if(!$product){
                                                continue;
                                            }
                                            ?>
                                            <tr data-catid="new-{{ $detail->plugin_product_id }}-{{ $detail->id }}" data-catidsel="{{ $detail->plugin_product_id }}" id="product-{{ $detail->plugin_product_id }}-row-{{ $detail->id }}">
                                                @if(backpack_user()->roles[0]->id <= 3)
                                                    <td class="align-middle" width="60">
                                                        <button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="las la-trash-alt"></i></button>
                                                    </td>
                                                @endif
                                                <td class="align-middle">
                                                    <input type="hidden" name="products[]" value="{{ $product->id }}">
                                                    <h6 class="font-weight-bold">{{ $product->name }}</h6>
                                                    <div class="row">
                                                        <div class="col">
                                                            <label class="d-block small mb-0">Persone</label>
                                                            <input type="number" class="form-control" name="products_num[]" value="{{ $detail->num }}" min="1" <?php echo $readonly;?>>
                                                        </div>
                                                        <div class="col">
                                                            <label class="d-block small mb-0">Reparto</label>
                                                            <select class="custom-select form-control" name="products_units[]" <?php echo $disabled;?>>
                                                                @if($units)
                                                                    @foreach ($units as $unit)
                                                                        @if($unit->id == $detail->plugin_category_id)
                                                                            <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                                                                        @else
                                                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <label class="d-block small mb-0">Quantità</label>
                                                            <input type="text" class="form-control" name="products_qty[]" value="{{ $detail->qty }}" <?php echo $readonly;?>>
                                                        </div>
                                                        <div class="col">
                                                            <label class="d-block small mb-0">Prezzo</label>
                                                            <input type="text" class="form-control" name="products_price[]" value="{{ $detail->price }}" <?php echo $readonly;?>>
                                                        </div>
                                                        <div class="col">

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note Ordine</label>
                                    @if(backpack_user()->roles[0]->id <= 3)
                                        <textarea name="note" id="summernote" class="form-control" cols="30" rows="2">{{ $reservation->note }}</textarea>
                                    @else
                                        {!! $reservation->note !!}
                                    @endif
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
                                    <select class="form-control" id="choose-place" name="place_ritiro" <?php echo $readonly;?>>
                                        @foreach ($places as $place)
                                            @if($place == $reservation->place_ritiro)
                                                <option value="{{ $place }}" selected>{{ $place }}</option>
                                            @else
                                                <option value="{{ $place }}">{{ $place }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                @if($reservation->place_ritiro == "Consegna a domicilio")
                                    <div class="form-group" id="box_address">
                                        <label>Inserisci indirizzo di consegna</label>
                                        <textarea id="address" name="address" rows="2" class="form-control" <?php echo $readonly;?>>{{ $reservation->address }}</textarea>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($status)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Stato dell'ordine</label>
                                        <select name="status_id" class="form-control">
                                            @foreach($status as $s)
                                                @if($s->id == $reservation->plugin_order_status_id)
                                                    <option value="{{ $s->id }}" selected>{{ $s->name }}</option>
                                                @else
                                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('PluginOrder.print_pdf', $reservation->id) }}" class="btn btn-info" target="_blank">
                    <span>Stampa PDF</span>
                </a>

                @if(backpack_user()->roles[0]->id <= 3)
                <a href="#" onclick="delete_reservation({{ $reservation->id }});" class="btn btn-danger">
                    <i class="la la-close"></i> <span>Cancella</span>
                </a>
                @endif

                <button type="submit" form="form-prenotazione" id="save_reservation" class="btn btn-success">
                    <i class="la la-save"></i> <span>Salva</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('#client-detail .card-footer').removeClass('d-none');

    $('select#choose-categories').select2({
        width: '100%',
        containerCssClass: 'choice__remove'
    });

    $('select#choose-categories').on('select2:select', function (e) {
        var catSelected = e.params.data;
        var _token = "{{ csrf_token() }}";
        var resourceId = 1;
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

    function delete_reservation(id){
        var _token = "{{ csrf_token() }}";
        swal({
            title: "Sicuro di voler cancellare l'ordine?",
            text: "Una volta eseguita, l'operazione non é più reversibile",
            icon: "warning",
            buttons: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $('#modal').modal('hide');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('PluginOrder.delete_reservation') }}",
                        data: "id="+id+"&_token=" + _token,
                        success: function(data) {
                            location.reload();
                        },
                        error: function(){
                        }
                    });
                }
            })
    }

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
