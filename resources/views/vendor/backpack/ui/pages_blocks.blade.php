﻿﻿@extends(backpack_view('blank'))

@php
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isFutureAdminTemplate = \App\Models\WebsiteSetting::isAdminFutureTemplate();
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
    @if($isFutureAdminTemplate)
    <style>
        .future-blocks-modal-dialog {
            max-width: 1180px;
        }

        .future-blocks-modal-content {
            border-radius: 14px;
            border: 1px solid #dbe6fb;
            box-shadow: 0 20px 42px rgba(13, 34, 74, .16);
            overflow: hidden;
        }

        .future-blocks-modal-header {
            padding: 14px 16px 12px;
            border-bottom: 1px solid #e3ebfa;
            background: linear-gradient(180deg, #ffffff 0%, #f6f9ff 100%);
        }

        .future-blocks-modal-header .modal-title {
            font-weight: 800;
            color: #132048;
            letter-spacing: -.01em;
        }

        .future-modal-close {
            color: #1f3366;
            opacity: .9;
        }

        .future-blocks-modal-body {
            padding: 12px 14px 6px;
            background: #f8fbff;
        }

        .future-blocks-tabs {
            border-bottom: 1px solid #dae4f7;
            margin-bottom: 10px;
        }

        .future-blocks-tabs .nav-link {
            border: 0;
            border-radius: 8px 8px 0 0;
            color: #476296;
            font-weight: 700;
            padding: .52rem .72rem;
        }

        .future-blocks-tabs .nav-link.active {
            color: #132048;
            background: #ffffff;
            border: 1px solid #dbe6fb;
            border-bottom-color: #ffffff;
        }

        .future-blocks-tab-content {
            background: #ffffff;
            border: 1px solid #dbe6fb;
            border-radius: 0 10px 10px 10px;
            padding: 8px 10px 10px;
        }

        .future-name-group label {
            color: #2a4375;
            font-weight: 700;
            font-size: .84rem;
        }

        .future-blocks-search-input {
            border: 1px solid #cfdbf2;
            border-radius: 10px;
            min-height: 40px;
            background: #f9fbff !important;
        }

        .future-blocks-search-input:focus {
            border-color: #8ca9df;
            box-shadow: 0 0 0 3px rgba(64, 106, 198, .12);
            background: #fff !important;
        }

        .future-category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }

        .future-category-pills .btn {
            border-radius: 999px;
            border: 1px solid #d3def3;
            color: #274074;
            background: #f7faff;
            font-weight: 700;
            font-size: .73rem;
            padding: .24rem .58rem;
            line-height: 1.2;
            box-shadow: none;
        }

        .future-category-pills .btn.is-active {
            background: #132048;
            border-color: #132048;
            color: #fff;
        }

        .future-blocks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(215px, 1fr));
            gap: 10px;
        }

        .future-block-card {
            margin: 0;
            border: 1px solid #dbe6fb;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .future-block-card:hover {
            border-color: #b6caee;
            box-shadow: 0 10px 22px rgba(19, 42, 86, .12);
            transform: translateY(-1px);
        }

        .future-block-card .card__body-cover {
            height: 118px;
            background: #edf3ff;
        }

        .future-block-card .card__body-cover-image {
            object-fit: cover;
            height: 100%;
        }

        .future-block-card .card__body-header {
            padding: 10px 10px 12px;
            min-height: 74px;
        }

        .future-block-card .card__body-header-title {
            color: #132048;
            font-size: .86rem;
            line-height: 1.3;
            font-weight: 800;
            display: block;
            margin-bottom: 3px;
        }

        .future-block-card .card__body-header-subtitle {
            color: #5e759f;
            font-size: .74rem;
            margin-bottom: 0;
        }

        .future-block-badge {
            display: inline-flex;
            margin-top: 4px;
            padding: .18rem .5rem;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
            color: #264172;
            border: 1px solid #d1def5;
            background: #f5f9ff;
        }

        .future-blocks-empty {
            margin-top: 8px;
            border: 1px dashed #cfdcf3;
            border-radius: 9px;
            padding: 12px 10px;
            text-align: center;
            font-size: .82rem;
            color: #5f749b;
            background: #f8fbff;
        }

        .future-blocks-modal-footer {
            border-top: 1px solid #e3ebfa;
            background: #fff;
            padding: 10px 12px;
        }

        .future-blocks-modal-footer .btn-dark {
            background: #132048;
            border-color: #132048;
        }

        .pages-blocks-shell .card.my-0 {
            border: 1px solid #dbe6fb;
            border-radius: 14px;
            box-shadow: 0 10px 24px rgba(14, 35, 76, 0.08);
            overflow: hidden;
            background: #ffffff;
        }

        .pages-blocks-shell .blocks-section-title {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            border: 1px solid transparent;
            padding: 8px 14px;
            margin-bottom: 10px;
            font-size: .8rem;
            font-weight: 800;
            letter-spacing: .02em;
            text-transform: uppercase;
            box-shadow: 0 8px 18px rgba(15, 34, 72, .12);
        }

        .pages-blocks-shell .blocks-section-title i {
            font-size: 1rem;
            opacity: .95;
        }

        .pages-blocks-shell .blocks-section-title.section-header {
            background: linear-gradient(140deg, #1f3f88 0%, #2c60cc 100%);
            border-color: #224d9f;
            color: #fff;
        }

        .pages-blocks-shell .blocks-section-title.section-content {
            background: linear-gradient(140deg, #1f7a62 0%, #27a87e 100%);
            border-color: #1f8667;
            color: #fff;
        }

        .pages-blocks-shell .blocks-section-title.section-footer {
            background: linear-gradient(140deg, #8b6712 0%, #c79c2a 100%);
            border-color: #9f7920;
            color: #fff;
        }

        .pages-blocks-shell .card.my-0 .card-header {
            background: linear-gradient(180deg, #fcfdff 0%, #f2f6ff 100%);
            border-bottom: 1px solid #dee8fb;
            padding-top: .56rem !important;
            padding-bottom: .56rem !important;
        }

        .pages-blocks-shell .card.my-0 .card-header > span {
            color: #1f3d73;
            font-weight: 700;
            font-size: .82rem;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn {
            min-height: 34px;
            border-radius: 8px;
            font-weight: 700;
            padding: 0 10px;
            line-height: 1;
            box-shadow: none !important;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn.btn-info,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-success,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-dark {
            border: 1px solid #132048;
            background: #132048;
            color: #fff;
        }

        .pages-blocks-shell .card.my-0 .card-header .btn.btn-info:hover,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-success:hover,
        .pages-blocks-shell .card.my-0 .card-header .btn.btn-dark:hover {
            background: #1a2b5f;
            border-color: #1a2b5f;
        }

        .pages-blocks-shell .page-block-sort-item + .page-block-sort-item {
            margin-top: 8px;
        }

        .pages-blocks-shell [id^="header_col_"],
        .pages-blocks-shell [id^="content_col_"],
        .pages-blocks-shell [id^="footer_col_"] {
            min-height: 72px;
            border: 1px dashed transparent;
            border-radius: 12px;
            transition: border-color .16s ease, background-color .16s ease;
        }

        .pages-blocks-shell [id^="header_col_"]:empty,
        .pages-blocks-shell [id^="content_col_"]:empty,
        .pages-blocks-shell [id^="footer_col_"]:empty {
            border-color: #d8e4fa;
            background: repeating-linear-gradient(
                -45deg,
                #fbfdff,
                #fbfdff 8px,
                #f4f8ff 8px,
                #f4f8ff 16px
            );
            position: relative;
        }

        .pages-blocks-shell [id^="header_col_"]:empty::after,
        .pages-blocks-shell [id^="content_col_"]:empty::after,
        .pages-blocks-shell [id^="footer_col_"]:empty::after {
            content: 'Nessun blocco presente';
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6f83ab;
            font-size: .77rem;
            font-weight: 700;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .page-block-row {
            border: 1px solid #dfe9fb !important;
            border-radius: 11px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            padding: 10px 10px !important;
            min-height: 62px;
            box-shadow: 0 6px 16px rgba(19, 41, 84, 0.06);
            transition: border-color .14s ease, box-shadow .14s ease, transform .14s ease;
        }

        .pages-blocks-shell .page-block-row:hover {
            border-color: #c8d9f6 !important;
            box-shadow: 0 10px 18px rgba(19, 41, 84, 0.11);
            transform: translateY(-1px);
        }

        .pages-blocks-shell .page-block-drag {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #4d6fa8;
            background: #edf3ff;
            border: 1px solid #d9e6fc;
            cursor: move;
            flex: 0 0 30px;
        }

        .pages-blocks-shell .page-block-drag i {
            font-size: 1rem;
        }

        .pages-blocks-shell .page-block-meta {
            min-width: 0;
        }

        .pages-blocks-shell .page-block-name {
            color: #1a3568;
            font-size: .87rem;
            line-height: 1.25;
            max-width: 520px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pages-blocks-shell .page-block-type {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-style: normal;
            color: #4f6a98 !important;
            font-size: .75rem;
            font-weight: 700;
            background: #eef4ff;
            border: 1px solid #d6e3f8;
            border-radius: 999px;
            padding: 2px 8px;
            max-width: 100%;
        }

        .pages-blocks-shell .page-block-actions {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding-left: 10px;
            flex-wrap: wrap;
        }

        .pages-blocks-shell .page-block-action-btn {
            min-width: 30px;
            min-height: 30px;
            width: 30px;
            height: 30px;
            padding: 0 !important;
            border-radius: 8px !important;
            border: 1px solid #d5e1f7;
            background: #ffffff;
            color: #2a4475;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: none !important;
            transition: background .12s ease, border-color .12s ease, color .12s ease;
        }

        .pages-blocks-shell .page-block-action-btn:hover {
            background: #edf3ff;
            border-color: #bcd1f4;
            color: #132048;
            text-decoration: none;
        }

        .pages-blocks-shell .page-block-action-btn.page-block-action-btn-danger {
            border-color: #f0c4ca;
            background: #fff5f6;
            color: #c63e52;
        }

        .pages-blocks-shell .page-block-action-btn.page-block-action-btn-danger:hover {
            border-color: #e6a8b1;
            background: #ffecef;
            color: #b72b3f;
        }

        .pages-blocks-shell .page-block-action-btn i {
            font-size: .95rem;
        }

        .pages-blocks-shell .page-block-actions .btn-warning.page-block-action-btn {
            width: auto;
            min-width: 86px;
            padding: 0 10px !important;
            background: #fff6de;
            border-color: #efd496;
            color: #8a6308;
            font-weight: 700;
        }

        .pages-blocks-shell .page-block-actions .page-block-inherit-btn {
            width: auto;
            min-width: 106px;
            padding: 0 12px !important;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .01em;
        }

        .pages-blocks-shell .page-block-actions .btn-light.page-block-action-btn:not([class*='text-']) {
            color: #284576;
        }

        .pages-blocks-shell .page-block-toggle-btn.is-on {
            background: #ebfbf2;
            border-color: #b7e8cc;
            color: #1f8a56 !important;
        }

        .pages-blocks-shell .page-block-toggle-btn.is-off {
            background: #fff3f5;
            border-color: #f2ccd4;
            color: #c93b54 !important;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 {
            border: 1px solid #f2ced5;
            background: linear-gradient(180deg, #fff6f7 0%, #fff1f3 100%);
            border-radius: 12px;
            padding: 10px 12px !important;
            margin-top: 6px;
            color: #b8364d !important;
            font-weight: 700;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 .btn-outline-danger {
            border-radius: 8px;
            font-weight: 700;
            border-color: #d5586e;
            color: #b5334b;
            background: #fff;
        }

        .pages-blocks-shell .text-danger.d-flex.align-items-center.py-1.px-2 .btn-outline-danger:hover {
            background: #ffecef;
        }

        @media (max-width: 991.98px) {
            .pages-blocks-shell .card.my-0 .card-header {
                gap: 8px;
            }

            .pages-blocks-shell .card.my-0 .card-header .btn {
                min-height: 32px;
                padding: 0 8px;
                font-size: .73rem;
            }

            .pages-blocks-shell .page-block-row {
                padding: 8px !important;
                min-height: 58px;
            }

            .pages-blocks-shell .page-block-name {
                font-size: .82rem;
                max-width: 320px;
            }
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

    @if($isFutureAdminTemplate)
    <script>
        (function () {
            function applyFutureModalFilters($panel) {
                if (!$panel || !$panel.length) {
                    return;
                }

                var query = (($panel.find('.js-future-tab-search').val() || '') + '').toLowerCase().trim();
                var $activeCategory = $panel.find('.js-future-category-btn.is-active');
                var activeCategory = $activeCategory.length ? ($activeCategory.data('category') + '') : 'all';
                var visibleCount = 0;

                $panel.find('.js-future-block-card').each(function () {
                    var $card = $(this);
                    var searchIndex = (($card.data('search') || '') + '').toLowerCase();
                    var cardCategory = (($card.data('category') || '') + '').toLowerCase();

                    var queryMatch = query === '' || searchIndex.indexOf(query) !== -1;
                    var categoryMatch = activeCategory === 'all' || cardCategory === activeCategory;
                    var shouldShow = queryMatch && categoryMatch;

                    $card.toggle(shouldShow);
                    if (shouldShow) {
                        visibleCount++;
                    }
                });

                $panel.find('.js-future-empty').toggleClass('d-none', visibleCount > 0);
            }

            function initFutureBlockModal($modal) {
                if (!$modal || !$modal.length || $modal.data('futureInitDone')) {
                    return;
                }

                $modal.data('futureInitDone', true);

                $modal.on('click', '.js-future-category-btn', function () {
                    var $btn = $(this);
                    var $panel = $btn.closest('.js-future-filter-panel');
                    $btn.siblings('.js-future-category-btn').removeClass('is-active');
                    $btn.addClass('is-active');
                    applyFutureModalFilters($panel);
                });

                $modal.on('input', '.js-future-tab-search', function () {
                    applyFutureModalFilters($(this).closest('.js-future-filter-panel'));
                });

                $modal.on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                    var target = $(e.target).attr('href');
                    if (!target) {
                        return;
                    }
                    $(target).find('.js-future-filter-panel').each(function () {
                        applyFutureModalFilters($(this));
                    });
                });
            }

            $(document).on('shown.bs.modal', '.modal[id^="modal_"][id$="_block"]', function () {
                var $modal = $(this);
                initFutureBlockModal($modal);
                $modal.find('.js-future-filter-panel').each(function () {
                    applyFutureModalFilters($(this));
                });
            });
        })();
    </script>
    @endif

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
