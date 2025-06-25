@extends(backpack_view('blank'))

@php $blocks_in_page = \App\Models\PageBlock::where("page_id", $page->id)->get(); @endphp

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">{{ $page->name }}</span>
        <small>({{ count($blocks_in_page) }} blocchi creati)</small>
    </h3>
@endsection

@section('before_breadcrumbs_widgets')
    <div class="col-auto">
        @if($page->slug == "/")
            <a href="/" target="_blank" class="btn btn-sm btn-secondary">
                <span><i class="la la-eye"></i></span>
                <span class="d-none d-md-inline">Anteprima</span>
            </a>
        @else
            <a href="/{{ $page->slug }}" target="_blank" class="btn btn-sm btn-secondary">
                <span><i class="la la-eye"></i></span>
                <span class="d-none d-md-inline">Anteprima</span>
            </a>
        @endif

        <a href="/admin/page/{{ $page->id }}/edit" class="btn btn-sm btn-outline-dark">
            <span><i class="la la-pencil"></i></span>
            <span class="d-none d-md-inline">Layout pagina</span>
        </a>
    </div>
@endsection

@section('after_breadcrumbs_widgets')
    <div class="col">
        <ol class="breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/admin/dashboard">Bacheca</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="/admin/page">pagine</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">{{ $page->name }}</li>
        </ol>
    </div>
@endsection


@section('after_styles')
    <!-- include select2 css-->
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        input.search::placeholder {
            color: #333;
        }
    </style>
@endsection

@section('content')


@endsection

@section('after_scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- include select2 js-->
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    @if (app()->getLocale() !== 'en')
        <script src="{{ asset('packages/select2/dist/js/i18n/' . app()->getLocale() . '.js') }}"></script>
    @endif

    <script type="text/javascript">
        $(document).ready(function () {

            $('.select2').select2({
                    theme: "bootstrap"
            });

            $('#header_col_1').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#header_col_2').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#header_col_3').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });


            $('#content_col_1').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#content_col_2').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#content_col_3').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#footer_col_1').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#footer_col_2').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#footer_col_3').sortable({
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                    });
                    saveNewPositions();
                }
            });

            $('#footer_col_4').sortable({
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
                url: '{{ route('pages.blocks.saveOrder', $page->id) }}',
                method: 'PUT',
                dataType: 'text',
                data: {
                    updated: 1,
                    positions: positions,
                    _token: '{{ csrf_token() }}'
                }, success: function (response) {
                    console.log(response);
                },error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        }
    </script>

    <script>
        function deleteBlock(url) {
            swal({
                title: "Sicuro di voler cancellare il blocco?",
                text: "Una volta eseguita, l'operazione non é più reversibile",
                icon: "warning",
                buttons: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $(location).attr('href', url)
                    }
                })
        }
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script>
        var options = {
            valueNames: [ 'nomeblocco' ],
            listClass: 'grid'
        };
        var b_exist_header_col_1 = new List('b_exist_header_col_1', options);
        var b_new_header_col_1 = new List('b_new_header_col_1', options);
        var b_exist_header_col_2 = new List('b_exist_header_col_2', options);
        var b_new_header_col_2 = new List('b_new_header_col_2', options);
        var b_exist_header_col_3 = new List('b_exist_header_col_3', options);
        var b_new_header_col_3 = new List('b_new_header_col_3', options);

        var b_exist_content_col_1 = new List('b_exist_content_col_1', options);
        var b_new_content_col_1 = new List('b_new_content_col_1', options);
        var b_exist_content_col_2 = new List('b_exist_content_col_2', options);
        var b_new_content_col_2 = new List('b_new_content_col_2', options);
        var b_exist_content_col_3 = new List('b_exist_content_col_3', options);
        var b_new_content_col_3 = new List('b_new_content_col_3', options);

        var b_exist_footer_col_1 = new List('b_exist_footer_col_1', options);
        var b_new_footer_col_1 = new List('b_new_footer_col_1', options);
        var b_exist_footer_col_2 = new List('b_exist_footer_col_2', options);
        var b_new_footer_col_2 = new List('b_new_footer_col_2', options);
        var b_exist_footer_col_3 = new List('b_exist_footer_col_3', options);
        var b_new_footer_col_3 = new List('b_new_footer_col_3', options);
    </script>
@endsection
