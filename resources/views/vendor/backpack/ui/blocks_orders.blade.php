@extends(backpack_view('blank'))

@section('content')
    <div class="container-fluid">
        <h2>
            <?php
            $adminBlock = \App\Models\AdminBlock::where("name_table", $type)->first();
            ?>
            <span class="text-capitalize">Ordinamento blocco <strong>{{ $adminBlock->label }}</strong></span>
            <small>{{ $page->name }}</small>

            <small><a href="/admin/pages_blocks/{{ $page->id }}" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Torna alla gestione della pagina</a>
            </small>
        </h2>
    </div>

    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-md-8 col-md-offset-2">
                <div class="card p-4">
                    <p>Seleziona e trascina per riordinare.</p>
                    <div id="esito"></div>

                    <div id="block_order">
                        @foreach($content as $k=>$value)
                            <div id="content_{{ $k }}" data-index="{{ $value['title'] }}" data-position="{{ $value['order'] }}">
                                <span class="btn btn-primary"> {{ $value['title'] }}</span>
                            </div>
                        @endforeach
                    </div>

                </div><!-- /.card -->
            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#block_order').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });
        });

    </script>

    <script type="text/javascript">
        function saveNewPositions() {
            var positions = [];
            $('.updated').each(function () {
                positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                $(this).removeClass('updated');
            });

            $.ajax({
                url: '{{ route('pages.blocks.saveOrder.single.block', [$type, $id]) }}',
                method: 'PUT',
                dataType: 'text',
                data: {
                    updated: 1,
                    positions: positions,
                    _token: '{{ csrf_token() }}'
                }, success: function (response) {
                     $("#esito").html("<div class='alert alert-success'>Dati salvati con successo!</div>");

                    $(".alert").delay(4000).slideUp(200, function() {
                        $(this).alert('close');
                    });
                },error: function (data, textStatus, errorThrown) {
                    $("#esito").html("<div class='alert alert-danger'>Errore dati non salvati!</div>");
                },
            });
        }
    </script>
@endsection

