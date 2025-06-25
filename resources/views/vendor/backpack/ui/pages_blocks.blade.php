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
    <?php
    $admin_blocks = \App\Models\AdminBlock::where("is_active", 1)->orderBy("label", "asc")->get()->pluck("label", "name")->toArray();

    /*$admin_blocks_exists = \App\Models\PageBlock::selectRaw("blocks_pages.*, admin_blocks.label, admin_blocks.name, admin_blocks.name_table")
        ->join("admin_blocks", "admin_blocks.name", "=", "blocks_pages.type")
        ->whereNotNull("obj_id")
        ->whereNull("is_ereditable_from_id")
        ->whereNull("blocks_pages.deleted_at")
        ->orderBy("admin_blocks.label", "asc")
        ->get();*/

    $admin_blocks_exists = [];

    ?>
    <div class="card-header border-0 font-weight-bold pb-1" style="background-color:#467fd0; color:#FFFFFF; padding:6px; margin-bottom: 4px;"> <i class="las la-arrow-circle-up"></i> Header pagina / Parte Alta</div>
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

    <div class="card-header border-0 font-weight-bold pb-1" style="background-color:#42ba96; color:#FFFFFF; padding:6px; margin-bottom: 4px;"><i class="las la-arrows-alt-v"></i> Contenuto pagina / Parte Centrale</div>
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

    <div class="card-header border-0 font-weight-bold pb-1" style="background-color:#ffc107; color:#000000; padding:6px; margin-bottom: 4px;"> <i class="las la-arrow-circle-down"></i>  Footer pagina / Parte Bassa </div>
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
