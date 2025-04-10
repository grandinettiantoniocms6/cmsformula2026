@extends(backpack_view('blank'))

@section('header')
    <?php
    if(request()->has('block')){
        $table = request()->get('table');
    }else{
        $product = \App\Models\PluginProducts::find($id);
    }
    ?>
    @if(request()->has('block'))
        <h3 class="page-title mb-0">
            <span>Immagini per blocco <span class="badge badge-info">{{ $table }}</span></span>
            <small><a href="/admin/blockGallery?block_id={{ $id }}&block={{ request()->get('block') }}&page_id={{ request()->get('page_id') }}" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> Torna indietro </a></small>
        </h3>
    @else
        <h3 class="page-title mb-0">
            <span>Immagini per <span class="badge badge-info">{{ $product->name }}</span></span>
            <?php
            $url_back = "/admin/pluginProducts";
            if($product->is_variant == 1){
                $url_back = "/admin/shopProductsVariants?group_id=$product->group_id";
            }
            ?>
            <small><a href="{{ $url_back }}" class="d-print-none font-sm"><i class="la la-angle-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> Torna indietro </a></small>
        </h3>
    @endif
@endsection

@section('content')
    <div class="container">
        <form method="post" action="{{url('admin/image/upload/store')}}" enctype="multipart/form-data"
              class="dropzone sortable dz-clickable sortable" id="dropzone">

            <input type="hidden" name="table" value="{{ $table }}">
            <input type="hidden" name="id" value="{{ $id }}">

            <br>
            @if($images)
                @foreach($images as $image)
                    @if(request()->has('block'))
                        <div class="dz-preview dz-complete" data-id="{{ $image->id }}">
                            <img class="dropzone-thumbnail" src={{ url($image->foto) }}>
                        </div>
                    @else
                        <div class="dz-preview dz-complete" data-id="{{ $image->id }}">

                            @if(is_numeric(strpos($image->image, "uploads")))
                                <img class="dropzone-thumbnail" src={{ url("$image->image") }}>
                            @else
                                <img class="dropzone-thumbnail" src={{ url("uploads/products/$image->image") }}>
                            @endif

                            <a class="dz-remove" href="javascript:void(0);" data-remove="{{ $image->id }}">Rimuovi</a>
                        </div>
                    @endif

                @endforeach
            @endif

            @csrf
        </form>

    </div>
@endsection
@push('after_scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <style>
        .sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; overflow: auto;}
        .sortable { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 120px; height: 120px; vertical-align:bottom; text-align: center;}
        .dropzone-thumbnail {
            width: 120px;

            cursor: move !important;
        }
        .dropzone {
            width: 100%;
            height: 800px;
        }
    </style>

@endpush

@push('after_scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    @if(!request()->has('block'))
        <script>
            $(".dropzone").sortable({
                items: '.dz-preview',
                cursor: 'move',
                opacity: 0.5,
                containment: '.dropzone',
                distance: 20,
                scroll: true,
                tolerance: 'pointer',
                stop: function (event, ui) {
                    var idsOrder = [];

                    $('.dz-preview').each(function() {
                        idsOrder.push($(this).data('id'))
                    });

                    $.ajax({
                        url: '{{ route('reorderProductImages') }}',
                        type: 'POST',
                        data: {
                            order: idsOrder,
                            id: {{ $id }}
                        },
                    })
                        .done(function(resp) {
                            console.log(resp);
                            swal({
                                title: "Ordinamento",
                                text: "Operazione eseguita con successo",
                                icon: "success",
                                buttons: false,
                            })
                        });
                }
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
        <script type="text/javascript">
            Dropzone.options.dropzone =
                {
                    maxFilesize: 12,
                    renameFile: function(file) {
                        var dt = new Date();
                        var time = dt.getTime();
                        return time+file.name;
                    },
                    acceptedFiles: ".jpeg,.jpg,.png,.gif",
                    addRemoveLinks: true,
                    timeout: 50000,
                    removedfile: function(file)
                    {
                        var name = file.upload.filename;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'POST',
                            url: '{{ url("admin/image/delete") }}',
                            data: {filename: name},
                            success: function (data){
                               // location.reload();
                            },
                            error: function(e) {
                                console.log(e);
                            }});
                        var fileRef;
                        return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;
                    },

                    success: function(file, response)
                    {
                        console.log(response);
                    },
                    error: function(file, response)
                    {
                        return false;
                    }
                };


            // Delete image
            $(document).on('click', '.dz-remove', function () {
                var id = $(this).data('remove');

                swal({
                    title: "Cancellazione foto",
                    text: "Sicuro di voler cancellare questa foto?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Annulla",
                            value: null,
                            visible: true,
                            className: "bg-secondary",
                            closeModal: true,
                        },
                        delete: {
                            text: "Si cancella",
                            value: true,
                            visible: true,
                            className: "bg-danger",
                        }
                    },
                }).then((value) => {
                    if (value) {
                        $.ajax({
                            url: '{{ url('admin/image/delete') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                        })
                        .done(function(status) {
                            location.reload();
                        });
                    }
                });

            });
        </script>
    @else
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
        <script type="text/javascript">
            Dropzone.options.dropzone =
                {
                    maxFilesize: 12,
                    renameFile: function(file) {
                        var dt = new Date();
                        var time = dt.getTime();
                        return time+file.name;
                    },
                    acceptedFiles: ".jpeg,.jpg,.png,.gif",
                    addRemoveLinks: true,
                    timeout: 50000,
                    removedfile: function(file)
                    {
                       /* var name = file.upload.filename;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'POST',
                            url: '{{ url("admin/image/delete") }}',
                            data: {filename: name},
                            success: function (data){
                                // location.reload();
                            },
                            error: function(e) {
                                console.log(e);
                            }});
                        var fileRef;
                        return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;*/
                    },

                    success: function(file, response)
                    {
                        console.log(response);
                    },
                    error: function(file, response)
                    {
                        return false;
                    }
                };


            // Delete image
            $(document).on('click', '.dz-remove', function () {
                var id = $(this).data('remove');

                swal({
                    title: "Cancellazione foto",
                    text: "Sicuro di voler cancellare questa foto?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Annulla",
                            value: null,
                            visible: true,
                            className: "bg-secondary",
                            closeModal: true,
                        },
                        delete: {
                            text: "Si cancella",
                            value: true,
                            visible: true,
                            className: "bg-danger",
                        }
                    },
                }).then((value) => {
                    if (value) {
                        $.ajax({
                            url: '{{ url('admin/image/delete') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                        })
                            .done(function(status) {
                                location.reload();
                            });
                    }
                });

            });
        </script>
    @endif
@endpush
