@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
@endphp

@php $blocks_in_page = \App\Models\PageBlock::where("page_id", $page->id)->get(); @endphp

@section('header')
    <div class="pages-blocks-header-shell">
        <h3 class="page-title mb-0">
            <span class="text-capitalize">{{ $page->name }}</span>
            <small>({{ count($blocks_in_page) }} blocchi creati)</small>
        </h3>
    </div>
@endsection

@section('before_breadcrumbs_widgets')
    <div class="col-auto pages-blocks-top-actions">
        @if($page->slug == "/")
            <a href="/" target="_blank" class="btn btn-sm btn-secondary pages-toolbar-btn">
                <span><i class="la la-eye"></i></span>
                <span class="d-none d-md-inline">Anteprima</span>
            </a>
        @else
            <a href="/{{ $page->slug }}" target="_blank" class="btn btn-sm btn-secondary pages-toolbar-btn">
                <span><i class="la la-eye"></i></span>
                <span class="d-none d-md-inline">Anteprima</span>
            </a>
        @endif

        <a href="/admin/page/{{ $page->id }}/edit" class="btn btn-sm btn-outline-dark pages-toolbar-btn">
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
    @if(!$isModernAdminTemplate)
    <style>
        .pages-blocks-shell .blocks-section-title {
            border: 1px solid #d6dce8;
            border-radius: 4px;
            font-weight: 700;
            padding: 8px 12px;
            margin-bottom: 8px;
            color: #fff;
        }

        .pages-blocks-shell .blocks-section-title.section-header {
            background-color: #141b36;
            border-color: #141b36;
        }

        .pages-blocks-shell .blocks-section-title.section-content {
            background-color: #47c29a;
            border-color: #47c29a;
        }

        .pages-blocks-shell .blocks-section-title.section-footer {
            background-color: #f4be00;
            border-color: #f4be00;
            color: #1f2a44;
        }
    </style>
    @endif
    @if($isModernAdminTemplate)
    <style>
        input.search::placeholder {
            color: #333;
        }

        .pages-blocks-header-shell {
            background: linear-gradient(120deg, #ffffff 0%, #f3f7ff 100%);
            border: 1px solid #dbe5fb;
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(24, 43, 81, 0.08);
        }

        .pages-blocks-header-shell .page-title {
            color: #182b51;
            font-weight: 700;
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pages-blocks-header-shell .page-title small {
            color: #5f6f95;
            font-size: .9rem;
            font-weight: 600;
        }

        .pages-blocks-top-actions .pages-toolbar-btn {
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 6px 14px rgba(20, 39, 75, 0.12);
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .pages-blocks-top-actions .pages-toolbar-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(20, 39, 75, 0.16);
        }

        .pages-blocks-shell .blocks-section-title {
            border: 0;
            border-radius: 12px;
            font-weight: 700;
            padding: 10px 14px;
            margin-bottom: 8px;
            box-shadow: 0 6px 16px rgba(21, 37, 70, 0.12);
            color: #fff;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .blocks-section-title i {
            opacity: .9;
            margin-right: 5px;
        }

        .pages-blocks-shell .blocks-section-title.section-header {
            background: linear-gradient(90deg, #3f72c2 0%, #5586d6 100%);
        }

        .pages-blocks-shell .blocks-section-title.section-content {
            background: linear-gradient(90deg, #31aa8a 0%, #4cc1a2 100%);
        }

        .pages-blocks-shell .blocks-section-title.section-footer {
            background: linear-gradient(90deg, #f4b000 0%, #ffc93b 100%);
            color: #2c2c2c;
        }

        .pages-blocks-shell .card.my-0 {
            border: 1px solid #dfe7f5;
            border-radius: 12px;
            box-shadow: 0 10px 22px rgba(18, 34, 68, 0.07);
            overflow: hidden;
        }

        .pages-blocks-shell .card.my-0 .card-header {
            background: #f7f9ff;
            border-bottom: 1px solid #e2e9f7;
            color: #22375f;
            font-weight: 700;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn {
            border-radius: 9px;
            font-weight: 700;
            box-shadow: none;
        }

        .pages-blocks-shell .card.my-0 .list-group-item {
            border: 1px solid #e5ebf7 !important;
            border-radius: 10px;
            background: #ffffff;
            margin-bottom: 8px;
            padding: 12px;
            transition: border-color .12s ease, box-shadow .12s ease, transform .12s ease;
        }

        .pages-blocks-shell .card.my-0 .list-group-item:hover {
            border-color: #cddbf7 !important;
            box-shadow: 0 8px 16px rgba(28, 50, 93, 0.1);
            transform: translateY(-1px);
        }

        .pages-blocks-shell .card.my-0 .list-group-item em {
            color: #4d6fb2 !important;
            font-style: italic;
        }

        .pages-blocks-shell .card.my-0 .list-group-item .btn {
            border-radius: 8px;
            min-width: 36px;
            font-weight: 600;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 {
            border: 1px solid #f7d1d6;
            background: #fff3f4;
            border-radius: 10px;
            padding: 10px 12px !important;
            margin-top: 4px;
        }
    </style>
    @endif
@endsection

@section('content')
    <?php
    $thema = env('TEMA');

    $admin_blocks = \App\Models\AdminBlock::where("is_active", 1)->orderBy("label", "asc")
        ->whereRaw("(templates LIKE '%$thema%' OR templates is null)")
        ->get()->pluck("label", "name")->toArray();

    /*$admin_blocks_exists = \App\Models\PageBlock::selectRaw("blocks_pages.*, admin_blocks.label, admin_blocks.name, admin_blocks.name_table")
        ->join("admin_blocks", "admin_blocks.name", "=", "blocks_pages.type")
        ->whereNotNull("obj_id")
        ->whereNull("is_ereditable_from_id")
        ->whereNull("blocks_pages.deleted_at")
        ->orderBy("admin_blocks.label", "asc")
        ->get();*/

    $admin_blocks_exists = [];

    ?>
    <div class="pages-blocks-shell">
    <div class="blocks-section-title section-header"><i class="las la-arrow-circle-up"></i> Header pagina / Parte Alta</div>
    <div class="row gutters-pages mb-3">
        <?php
        $position = "header";
        switch($page->template_header){
            case "row": ?>
                <?php $col = 1;?>
                <div class="col-12 mb-1">
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna unica</span>
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;

            case "two_cols": ?>
                <div class="col-lg-6 mb-1">
                    <?php $col = 1;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-1">
                    <?php $col = 2;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;

            case "three_cols":
            ?>
                <div class="col-lg-4 mb-1">
                    <?php $col = 1;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 2;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna centrale</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>
                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 3;?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div class="p-2">
                            <div id="header_col_<?php echo $col;?>">
                                @include('vendor.backpack.base.inc.blocks_loop')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
        } ?>
    </div>

    <div class="blocks-section-title section-content"><i class="las la-arrows-alt-v"></i> Contenuto pagina / Parte Centrale</div>
    <div class="row gutters-pages mb-3">
        <?php
        $position = "content";
        switch($page->template){
            case "full_page": ?>
                <div class="col-12 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna unica</span>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "sidebar_left": ?>
                <div class="col-lg-5 col-xl-4 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Sidebar Sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-xl-8 mb-1">
                    <?php $col = 2; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Contenuto Destro</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                                @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "sidebar_right": ?>
                <div class="col-lg-7 col-xl-8 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Contenuto Sinistro</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4 mb-1">
                    <?php $col = 2; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Sidebar Destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "three_columns": ?>
                <div class="col-lg-4 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna Sinistra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 2; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna Centrale</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-1">
                    <?php $col = 3; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna Destra</span>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="content_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
        } ?>
    </div>

    <div class="blocks-section-title section-footer"><i class="las la-arrow-circle-down"></i> Footer pagina / Parte Bassa</div>
    <div class="row gutters-pages mb-4">
        <?php
        $position = "footer";
        switch($page->template_footer){
            case "row": ?>
                <div class="col-12 mb-1">
                    <?php $col = 1; ?>
                    <div class="card my-0 h-100">
                        <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                                <span>Colonna unica</span>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                            </div>

                            <input type="hidden" name="position" value="<?php echo $position;?>">
                            <input type="hidden" name="col" value="<?php echo $col;?>">

                            @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                        </form>
                        <div id="footer_col_<?php echo $col;?>" class="p-2">
                            @include('vendor.backpack.base.inc.blocks_loop')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('vendor.backpack.base.inc.blocks_loop_limbo')
                </div>
            <?php
            break;
            case "two_cols": ?>
            <div class="col-lg-6 mb-1">
                <?php $col = 1; ?>
                <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna sinistra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
                </div>
            </div>
            <div class="col-lg-6 mb-1">
                <?php $col = 2; ?>
                <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna destra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
                </div>
            </div>
            <div class="col-12">
                @include('vendor.backpack.base.inc.blocks_loop_limbo')
            </div>
        <?php
        break;
            case "three_cols":
        ?>
            <div class="col-lg-4 mb-1">
            <?php $col = 1; ?>
            <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna sinistra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-lg-4 mb-1">
            <?php $col = 2; ?>
            <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna centrale</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-lg-4 mb-1">
            <?php $col = 3; ?>
            <div class="card my-0 h-100">
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna destra</span>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-12">
                @include('vendor.backpack.base.inc.blocks_loop_limbo')
            </div>
        <?php
        break;
            case "four_cols":
        ?>
            <div class="col-lg-3 mb-1">
                <?php $col = 1; ?>
                <div class="card my-0 h-100">
                <?php
                $position = "footer";
                $col = 1;
                ?>
                <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                        <span>Colonna 1</span>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                    </div>

                    <input type="hidden" name="position" value="<?php echo $position;?>">
                    <input type="hidden" name="col" value="<?php echo $col;?>">

                    @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                </form>
                <div id="footer_col_<?php echo $col;?>" class="p-2">
                    @include('vendor.backpack.base.inc.blocks_loop')
                </div>
            </div>
        </div>
            <div class="col-lg-3 mb-1">
                <?php $col = 2; ?>
                <div class="card my-0 h-100">
                    <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                            <span>Colonna 2</span>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                        </div>

                        <input type="hidden" name="position" value="<?php echo $position;?>">
                        <input type="hidden" name="col" value="<?php echo $col;?>">

                        @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                    </form>
                    <div id="footer_col_<?php echo $col;?>" class="p-2">
                        @include('vendor.backpack.base.inc.blocks_loop')
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-1">
                <?php $col = 3; ?>
                <div class="card my-0 h-100">
                    <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                            <span>Colonna 3</span>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                        </div>

                        <input type="hidden" name="position" value="<?php echo $position;?>">
                        <input type="hidden" name="col" value="<?php echo $col;?>">

                        @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                    </form>
                    <div id="footer_col_<?php echo $col;?>" class="p-2">
                        @include('vendor.backpack.base.inc.blocks_loop')
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-1">
                <?php $col = 4; ?>
                <div class="card my-0 h-100">
                    <form method="post" action="{{ route('pages.blocks.switch', [$page->id]) }}">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center py-2 px-3">
                            <span>Colonna 4</span>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_{{ $position }}_col{{ $col }}_block"><i class="la la-plus"></i> Aggiungi Blocco</button>
                        </div>

                        <input type="hidden" name="position" value="<?php echo $position;?>">
                        <input type="hidden" name="col" value="<?php echo $col;?>">

                        @include('vendor.backpack.base.inc.modal_form_blocks', ['position'=>$position,'col'=>$col])
                    </form>
                    <div id="footer_col_<?php echo $col;?>" class="p-2">
                        @include('vendor.backpack.base.inc.blocks_loop')
                    </div>
                </div>
            </div>
            <div class="col-12">
                @include('vendor.backpack.base.inc.blocks_loop_limbo')
            </div>
        <?php
        break;
        } ?>
    </div>
    </div>

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
                text: "Una volta eseguita, l'operazione non è più reversibile",
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
